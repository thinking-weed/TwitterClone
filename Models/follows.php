<?php
////////////////////////////
//フォローデータを処理
//////////////////////////

/**
フォローを作成

@param array $data
@return int|false
*/
function createFollow(array $data){
        //DBに接続（$mysqliにオブジェクトの形で代入される）
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。 : '  .$mysqli->connect_error . "\n";
        exit;
    }

    //-------------------------------------
    //SQLクエリを作成（新規登録）プリペアドステートメントに値をセット
    //--------------------------------------
    $query = 'INSERT INTO follows (follow_user_id,followed_user_id) VALUES (? , ?)';
    $statement = $mysqli->prepare($query);
    //プレースホルダーに値をセット
    $statement->bind_param('ii',$data['follow_user_id'],$data['followed_user_id']);

    //--------------------------------
    //戻り値を作成
    //-------------------------------
    //クエリを実行し、SQLエラーでない場合
    if($statement->execute()){
        //戻り値用の変数にセット・インサートID（follow.id）
        $response = $mysqli->insert_id;
    } else{
        //戻り値用の変数にセット・失敗
        $response = false;
        echo 'エラーメッセージ : ' . $mysqli->error . "\n";
    }

    //------------------------------------
    //後処理
    //------------------------------------
    //DB接続を開放
    $mysqli->close();
    $statement->close();

    return $response;

}

/**
フォローを作成

@param array $data
@return bool
*/
function deleteFollow(array $data){
    //DBに接続（$mysqliにオブジェクトの形で代入される）
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if($mysqli->connect_errno){
    echo 'MySQLの接続に失敗しました。 : '  .$mysqli->connect_error . "\n";
    exit;
}
//更新日時を追加
$data['updated_at'] = date('Y-m-d H:i:s');

//-------------------------------------
//SQLクエリを作成（新規登録）プリペアドステートメントに値をセット
//--------------------------------------
$query = 'UPDATE follows SET status = "deleted",updated_at = ? WHERE id = ? AND follow_user_id = ?';
$statement = $mysqli->prepare($query);//follow_user_idがないと他の人のフォローを削除するおそれあり
//プレースホルダーに値をセット
$statement->bind_param('sii',$data['updated_at'],$data['follow_id'],$data['follow_user_id']);

//--------------------------------
//戻り値を作成
//-------------------------------
$response = $statement->execute();

//SQLエラーの場合->エラー表示
if($response === false){
    //戻り値用の変数にセット・インサートID（follow.id）
    echo 'エラーメッセージ : ' . $mysqli->error . "\n";
}

//------------------------------------
//後処理
//------------------------------------
//DB接続を開放
$mysqli->close();
$statement->close();

return $response;

}

?>





