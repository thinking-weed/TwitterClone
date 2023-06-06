<?php
//////dta/////////////////////////////////
//ユーザーデータを処理
/////////////////////////////////////


/*
ユーザーを作成

@param array $data
@return bool
*/
function createUser(array $data){
    //DBに接続（$mysqliにオブジェクトの形で代入される）
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。  '  .$mysqli->connect_error . "\n";
        exit;
    }
    
    //新規登録のSQLクエリを作成、（?,?,?,?）をプレースホルダーという ※後で値を決められる
    $query = 'INSERT INTO users (email, name, nickname, password) VALUES (?, ?, ?, ?)';
    //上のVALUESの後に変数名を直接書くとSQLインジェクションを防ぐため（プレースホルダーで二段構えにする）
    //プリペアドステートメントに、作成したクエリを登録
    $statement = $mysqli ->prepare($query);

    //パスワードをハッシュ値に変換
    $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);

    //クエリのプレースホルダー（）の部分にカラム値を後付け代入。最初のssssはストリングが４つ（第二引数のものから～）入る」
    //今回すべて文字列型で
    $statement -> bind_param('ssss',$data['email'],$data['name'],$data['nickname'],$data['password']);
    //エスケープ処理とは

    //クエリを実行
    $response = $statement -> execute();

    //実行に失敗した場合、エラー表示
    if( $response === false){
        echo 'エラーメッセージ' . $mysqli -> error . "\n";
    }
    //DB接続を解放
    $statement -> close();
    $mysqli -> close();

    return $response;   //SQLの実行結果を返す

}








?>