<?php
///////////////////////////////////////////////////////////
////////////サインアップコントローラー
/////////////////////////////////////////////////////////

//設定を読み込み
include_once('../config.php');
//便利な関数を読み込む
include_once('../util.php');
//ユーザーデータ設定モデルを読み込み
include_once('../Models/users.php');


//登録情報が全て入力されていれば
if(isset($_POST['nickname']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])){
    $data= [
        'nickname' => $_POST['nickname'],
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
    ];
    //----------------------
    //バリデーション（入力フォームの内容の妥当性をチェックするもの）
    //-----------------------
    //文字数制限（全ての入力項目に対して行う）
    $length = mb_strlen($data['nickname']);
    if($length < 1 || $length > 50){
        $error_messages[] = 'ニックネームは1～50文字にしてください';
    }
    //メールアドレス
    if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
        $error_messages[] = 'メールアドレスが不正です。';
    }


    //ユーザーを作成し成功すれば、
    if(createUser($data)){
        //ログイン画面に遷移
        header('Location:' . HOME_URL . 'Controllers/sign-in.php');
        exit;
    }
}

//画面表示
include_once('../views/sign-up.php');


?>