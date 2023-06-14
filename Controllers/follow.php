<?php
/////////////////////////////////
////////フォローコントローラー
/////////////////////////

//設定を読み込み
include_once('../config.php');
//便利な関数を読み込み
include_once('../util.php');

//ユーザーデーター操作モデルを読み込み
include_once('../Models/follows.php');

//----------------------------------------
//ログインチェック
//----------------------------------------
$user = getUserSession();
//ログインしていない場合
if(!$user){
    //404エラー
    header('HTTP/1.0 404 Not Found');
    exit;
}
//------------------------------
//フォローする
//------------------------------
$follow_id = null;
// followed_user_idがPOSTされた場合
if(isset($_POST['followed_user_id'])){
    $data = [
        'followed_user_id' => $_POST['followed_user_id'],
        'follow_user_id' => $user['id']
    ];
    //フォロー登録
    $follow_id = createFollow($data);
}

//------------------------------
//フォロー解除
//------------------------------

// follow_idがPOSTされた場合
if(isset($_POST['follow_id'])){
    $data = [
        'follow_id' => $_POST['follow_id'],
        'follow_user_id' => $user['id']
    ];

    //フォロー解除
    deleteFollow($data);
}

//---------------------------------
//JSON形式で結果を返却
//------------------------------
$response = [
    'message' => 'successful',
    //フォローしたときに値が入る
    'follow_id' => $follow_id
];
header('Content-type: application/json; charset=utf-8');
echo json_encode($response);

?>

