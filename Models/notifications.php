<?php
///////////////////////////////////////////////
//通知データ処理
/////////////////////////////////////////////

/*
通知を作成

@param array(received_user_id:int, sent_user_id:int,message:string)$data
@return int|false

 */
function createNotification(array $data){
    //DBに接続（$mysqliにオブジェクトの形で代入される）
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。 : '  .$mysqli->connect_error . "\n";
        exit;
    }
    //----------------------------------------------------------
    //SQLクエリを登録
    //----------------------------------------------------------
    //新規登録のクエリを作成
    $query = 'INSERT INTO notifications (received_user_id, sent_user_id, message)VALUES(?,?,?)';
    $statement = $mysqli->prepare($query);
    //プレースホルダーに値をセット
    $statement->bind_param('iis',$data['received_user_id'], $data['sent_user_id'], $data['message']);

    //---------------------
    //戻り値を作成
    //---------------------
    //クエリを実行し、SQLエラーでない場合
    if($statement->execute()){
        //戻り値用の変数にセット
        $response = $mysqli->insert_id; 
    } else {
        //戻り値用の変数にセット・失敗
        $response = false;
        echo 'エラーメッセージ : ' . $mysqli->error . "\n";
    }
    //--------------------------------------------------
    //後処理
    //--------------------------------------------------
    $statement->close();
    $mysqli->close();

    return $response;
}


/*通知の一覧を取得

@param int $user_id
@return array|false
*/
function findNotifications(int $user_id){//第二引数は何もなければnull（ここではキーワードなし検索）を代入
    //DBに接続（$mysqliにオブジェクトの形で代入される）
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。 : '  .$mysqli->connect_error . "\n";
        exit;
        }

 //ログインユーザーIDをエスケープ
    $user_id = $mysqli->real_escape_string($user_id);

//------------------------------------
//検索のSQLクエリを作成
//-----------------------------------
$query = <<<SQL
SELECT
        -- 通知
    N.id AS notification_id,
    N.message AS notification_message,
        --  ユーザー
    U.name AS user_name,
    U.nickname AS user_nickname,
    U.image_name AS user_image_name
FROM
    notifications AS N
    JOIN
        users AS U ON U.id = N.sent_user_id AND U.status = 'active'
WHERE
    N.status = 'active' AND N.received_user_id = '$user_id'
ORDER BY
    N.created_at DESC
LIMIT 50
SQL;

//-------------------------------------
//戻り値を作成
//--------------------------------------
//クエリを実行し、SQLエラーでない場合
if($result = $mysqli->query($query)){
    //データを配列で受け取る
    $notifications = $result->fetch_all(MYSQLI_ASSOC);
}else{
    $notifications = false;
    echo 'エラーメッセージ : ' . $mysqli->error . "\n"; 
}

return $notifications;
}

?>