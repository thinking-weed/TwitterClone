<?php
////////////////////////////////////////
/////便利な関数
///////////////////////////////////

/*画像ファイル名から画像のURLを生成する
@param（第１引数）$name string  画像ファイル名
@param（第２引数）$type string  user-iconかtweetか
@return void

*/

function buildImagePath(string $name = null, string $type)
{             //※注意   上の=nullは、$nameに値がないときにnullになる。第１引数がnullで、
             //第２引数は値があるというのは不自然なので、本来は逆にすべき

    if( $type === 'user' && !isset($name)){ //左は$nameが定義されていなければ
        return HOME_URL.'views/img/icon-default-user.svg';
    }
        return HOME_URL.'views/img_uploaded/'.$type.'/'. htmlspecialchars($name);
};

//htmlspecialcharsは文字の中には HTML において特殊な意味を持つものがあり、 
//それらの本来の値を表示したければ HTML の表現形式に変換してやらなければなりません。
// この関数は、これらの変換を行った結果の文字列を返します。

/**指定した日時からどれだけ経過したかを取得

@param string $datetime 日時;
@return string;
*/
                                                    //タイプヒーティング
function convertTodayTimeAgo(string $datetime)      //指定したデータ型（今回ならstring）以外の文字が入るとエラー
{
    $unix = strtotime($datetime);       //投稿日時をunixタイム1970年１月１日０時０秒からの経過秒数に直す
    $now = time();                      //unixタイム開始から現在（ブラウザ視聴時）までの秒数
    $diff_sec = $now - $unix;

    if($diff_sec < 60){//１分未満の場合
        $time = $diff_sec;
        $unit = '秒前';
    } elseif($diff_sec < 3600){//１時間未満の場合
        $time = $diff_sec /60;
        $unit = '分前';
    } elseif($diff_sec < 86400){//24時間未満の場合
        $time = $diff_sec /3600;
        $unit = '時間前';
    } elseif($diff_sec < 2764800){//32日未満の場合
        $time = $diff_sec /86400;
        $unit = '日前';
    } 
        else {
        if(date('Y') !== date('Y',$unix)){
            $time = date('Y年n月j日',$unix);
        }else{
            $time = date('n月j日',$unix);      
        }
        return $time;
    }

        return (int)$time . $unit; //(int)は型キャスト：intで表せない値は０、小数点は切り捨て

};    

/*ユーザー情報をセッションに保存する関数
*
@param array $user
@return void
*/

function saveUserSession(array $user){
    //セッションを開始していない場合（session_statusで現在のセッションを確認）
    if(session_status() === PHP_SESSION_NONE){
    //セッション開始
        session_start();
    }

    $_SESSION['USER'] = $user;
}


/*セッションのユーザー情報を取得
*
@param array $user
@return void
*/

function deleteUserSession(){
    //セッションを開始していない場合（session_statusで現在のセッションを確認）
    if(session_status() === PHP_SESSION_NONE){
    //セッション開始
        session_start();
    }

    //セッションのユーザー情報を削除
    unset($_SESSION['USER']);
}

/*セッションのユーザー情報を取得
*

@return array|false
*/
function getUserSession(){
    //セッションを開始していない場合（session_statusで現在のセッションを確認）
    if(session_status() === PHP_SESSION_NONE){
        //セッション開始
        session_start();
    }

    if(!isset($_SESSION['USER'])){
        //セッションにユーザー情報がない
        return false;
    }

    $user = $_SESSION['USER'];
    //画像のファイル名からファイルのURLを取得
    if(!isset($user['image_name'])){
        $user['image_name'] = null;
    }
    $user['image_path'] = buildImagePath($user['image_name'],'user');
    
    return $user;
}

/*
画像をアップロード
@param array $user
@param array $file
@param string type
@return string 画像のファイル名

*/

function uploadImage(array $user, array $file, string $type){
    //画像のファイル名から拡張子を取得（例  .jpg）
    $image_extension = strrchr($file['name'], '.');

    //画像のファイル名を作成（YmdHis : 2021-01-01 00:00:00ならば、20210101000000）
    $image_name = $user['id'] . '_' .date('YmdHis') . $image_extension;

    //保存先のディレクトリ
    $directory = '../views/img_uploaded/'.$type.'/';
    
    //画像のパス
    $image_path = $directory . $image_name;

    //画像を設置
    move_uploaded_file($file['tmp_name'], $image_path);

    //画像ファイルの場合->ファイル名をreturn
    if(exif_imagetype($image_path)){
        return $image_name;
    }
    //画像ファイル以外の場合
    echo '選択されたファイルが画像ではないため処理を停止しました。';
    exit;//exitは処理を停止させるもの

}


?>
