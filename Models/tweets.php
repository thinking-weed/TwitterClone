<?php
/////////////////////////////////
//ツイートデータを処理
/////////////////////////////////

/*

ツイート作成

@param array $data
@return  bool

*/
function createTweet(array $data){
     //DBに接続（$mysqliにオブジェクトの形で代入される）
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。 : '  .$mysqli->connect_error . "\n";
        exit;
        }
    
    //新規登録のSQLクエリを作成
    $query = 'INSERT INTO  tweets (user_id, body, image_name) VALUES(?,?,?)';

    //プリペアドステートメントにクエリを登録
    $statement = $mysqli -> prepare($query);

    //プレースホルダーにcolumn値を後付け（i = int 、s = string）
    $statement -> bind_param('iss',$data['user_id'],$data['body'],$data['image_name']);

    //クエリを実行
    $response = $statement -> execute();
    if($response === false){
        echo 'エラーメッセージ：' . $mysqli -> error . "\n";
    }
    //DB接続を解放
    $statement -> close();
    $mysqli -> close();

    return $response;
}


/*ツイート１件取得
@param int $tweet_id 
@return array|false
*/
function findTweet(int $tweet_id){ 
    //DBに接続（$mysqliにオブジェクトの形で代入される）
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if($mysqli->connect_errno){
    echo 'MySQLの接続に失敗しました。 : '  .$mysqli->connect_error . "\n";
    exit;
    }

    //ツイートIDをエスケープ
    $tweet_id = $mysqli->real_escape_string($tweet_id);

    //-----------------------------------------
    //SQLクエリを作成
    //---------------------------------------
    $query = 'SELECT * FROM tweets WHERE status = "active" AND id = "' .$tweet_id .'"';

    //------------------------------------
    //戻り値を作成
    //------------------------------------
    if($result = $mysqli->query($query)){
    //データを１件取得
    $response = $result->fetch_array(MYSQLI_ASSOC);
    } else{
    $response = false;
    echo 'エラーメッセージ : ' . $mysqli->error . "\n";
    }

    //---------------------------------
    //後処理
    //--------------------------------
    //DB接続を開放
    $mysqli->close();

    return $response;
}


/*ツイート一覧を取得

@param array $user　ログインしているユーザー情報
@param string $keyword 検索キーワード
@param array $user_ids ユーザーID一覧
@return void
*/
function findTweets(array $user, string $keyword = null, array $user_ids = null){//第二引数は何もなければnull（ここではキーワードなし検索）を代入
        //DBに接続（$mysqliにオブジェクトの形で代入される）
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。 : '  .$mysqli->connect_error . "\n";
        exit;
    }

     //ログインユーザーIDをエスケープ
    $login_user_id = $mysqli->real_escape_string($user['id']);

     //検索のSQLクエリを作成
    $query = <<<SQL
    SELECT
        T.id AS tweet_id,
        T.status AS tweet_status,
        T.body AS tweet_body,
        T.image_name AS tweet_image_name,
        T.created_at AS tweet_created_at,
        U.id AS user_id,
        U.name AS user_name,
        U.nickname AS user_nickname,
        U.image_name AS user_image_name,
        -- ログインユーザーがいいね！したか（いいね！している場合、値が入る）
        L.id AS like_id,
        -- いいね！数
        (SELECT COUNT(*) FROM likes WHERE status = 'active' AND tweet_id = T.id) AS like_count
    FROM
        tweets AS T
        -- ユーザーテーブルをuser_idとtweets.user_idで紐付ける
        JOIN
        users AS U ON U.id = T.user_id AND U.status = 'active'
        -- いいね！テーブルをlikes.tweet_idとtweets.idで紐付ける
        -- SQLのコメントアウトは「--と「スペース１回」」
        LEFT JOIN
        likes AS L ON L.tweet_id = T.id AND L.status = 'active' AND L.user_id = '$login_user_id'
    WHERE
        T.status = 'active'
    SQL;

    //検索キーワードが入力されている場合
    if(isset($keyword)){
        //エスケープ
        $keyword = $mysqli->real_escape_string($keyword);
        //ツイート主のニックネーム・ユーザー名・本文から部分一致検索
        $query .= ' AND CONCAT(U.nickname, U.name, T.body) LIKE "%' . $keyword . '%" ';
            // .= は「一番最後に付け加えて代入する」
            //CONCATは引数の変数を連結
    }

    //ユーザーIDが指定されている場合
    if(isset($user_ids)){
        foreach ($user_ids as $key => $user_id){
            $user_ids[$key] = $mysqli->real_escape_string($user_id);
        }
        $user_ids_csv = '"' . join('","', $user_ids) . '"';
        //ユーザーID一覧に含まれるユーザーで絞る IN(～)
        $query .= ' AND T.user_id IN (' . $user_ids_csv . ')';
    }


    //新しい順に並び替え
    $query .= ' ORDER BY T.created_at DESC'; //クエリを連結させる場合、スペースを適当に入れないと、
    //表示件数５０件                          //文字列が変なところでくっつきクエリが上手く動かない
    $query .= ' LIMIT 50';

    //クエリ実行
    $result = $mysqli->query($query);
    if($result){
        //データを配列で受け取る
        $response = $result->fetch_all(MYSQLI_ASSOC);
    }else{
        $response = false;
        echo 'エラーメッセージ : ' . $mysqli->error . "\n"; 
    }
    $mysqli->close();

    return $response;
}


?>
