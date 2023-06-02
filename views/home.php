<?php
//エラー表示あり
ini_set('display_errors',1);
//日本時間にする
date_default_timezone_set('Asia/Tokyo');
//URLをディレクトリに設定
define('HOME_URL','http://localhost/TECH-I.S.-curriculum/TwitterClone/');

///////////////////////////////////////////////////////////////
//　ツイート一覧
///////////////////////////////////////
$view_tweets = [
    [
        'user_id' => 1,
        'user_name' => 'taro',
        'user_nickname' => '太郎',
        'user_image_name' => 'sample-person.jpg', 
        'tweet_body' => '今プログラミングをしています。',
        'tweet_image_name' => null,
        'tweet_created_at' => '2023-05-15-14:00:00',
        'like_id' => null,
        'like_count' => 0       
    ],
    [
        'user_id' => 2,
        'user_name' => 'jiro',
        'user_nickname' => '次郎',
        'user_image_name' => null, 
        'tweet_body' => 'コワーキングスペースをオープンしました！',
        'tweet_image_name' => 'sample-post.jpg',
        'tweet_created_at' => '2021-03-15-14:00:00',
        'like_id' => 1,
        'like_count' => 1       
    ]
];
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



?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ホーム画面です">
    <title>ホーム画面 / Twitterクローン</title>
    <link href="../../../fontawesome-free-6.4.0-web/css/all.min.css">
    <link rel="icon" href="<?php echo HOME_URL;?>views/img/logo-twitterblue.svg">
    <!--bootstrapのrink-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo HOME_URL;?>views/css/style.css">
    </head>
<body class="home">
    <div class="container">
        <div class="side">
            <div class="side-inner">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="home.php" class="nav-link">
                            <img src="<?php echo HOME_URL;?>views/img/logo-twitterblue.svg" alt="" class="icon">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="home.php" class="nav-link">
                            <img src="<?php echo HOME_URL;?>views/img/icon-home.svg" alt="">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="search.php" class="nav-link">
                            <img src="<?php echo HOME_URL;?>views/img/icon-search.svg" alt="">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="notification.php" class="nav-link">
                            <img src="<?php echo HOME_URL;?>views/img/icon-notification.svg" alt="">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="profile.php" class="nav-link">
                            <img src="<?php echo HOME_URL;?>views/img/icon-profile.svg" alt="">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="post.php" class="nav-link">
                            <img src="<?php echo HOME_URL;?>views/img/icon-post-tweet-twitterblue.svg" alt="" class="post-tweet">
                        </a>
                    </li>
                    <li class="nav-item my-icon">
                            <img src="<?php echo HOME_URL;?>views/img_uploaded/user/sample-person.jpg" alt="">
                    </li>
                </ul>
            </div>
        </div>
        <div class="main">
            <div class="main-header">
                <h1>ホーム</h1>
            </div>

            <!--つぶやき投稿エリア-->
            <div class="tweet-post">
                <div class="my-icon">
                    <img src="<?php echo HOME_URL;?>views/img_uploaded/user/sample-person.jpg" alt="">
                </div>
                <div class="input-area">
                    <form action="post.php" method="post" enctype="multipart/form-data">
                        <textarea name="body" placeholder="いまどうしてる？" maxlength="140"></textarea>
                            <div class="bottom-area">                            
                                <div class="mb-0">
                                    <input type="file" name="image" class="form-control form-control-sm">
                            </div>
                            <button class="btn" type="submit">
                                つぶやく
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!--仕切りエリア-->
            <div class="ditch">
            </div>
            <!---つぶやき一覧エリア-->
            <?php if(empty($view_tweets)) : ?>
                <p class="p-3">ツイートがありません</p>
            <?php else : ?>
            <div class="tweet-list">
                <?php foreach ($view_tweets as $view_tweet):  ?>
                    <div class="tweet">
                        <div class="user">
                            <a href="profile.php?user_id=<?php echo htmlspecialchars($view_tweet['user_id']); ?>">
                                <img src="<?php echo buildImagePath($view_tweet['user_image_name'],'user') ; ?>"  alt="">
                            </a>
                        </div>
                        <div class="content">
                            <div class="name">
                                <a href="profile.php?user_id=<?php echo htmlspecialchars($view_tweet['user_id']); ?>">
                                    <span class="nickname"><?php echo htmlspecialchars($view_tweet['user_nickname']); ?></span>
                                    <span class="user-name">@<?php echo htmlspecialchars($view_tweet['user_name']); ?>" ・ <?php echo convertTodayTimeAgo($view_tweet['tweet_created_at']); ?></span>
                                </a>
                            </div>
                            <p><?php echo $view_tweet['tweet_body']; ?></p>
                            <!--画像があるときは下のimgタグを表示。構文内には処理の{}は必要ない-->
                            <?php if(isset($view_tweet['tweet_image_name'])) : ?>
                            <img src="<?php echo buildImagePath($view_tweet['tweet_image_name'], 'tweet'); ?>" alt="" class="post-image"> 
                            <?php endif; ?>
                            
                            <div class="icon-list">
                                <div class="like">
                                    <?php
                                    if(isset($view_tweet['like_id'])){
                                        //いいね！している場合、青のハートを表示
                                        echo '<img src="'.HOME_URL.'views/img/icon-heart-twitterblue.svg" alt="">';
                                    } else {
                                        //いいね！していない場合、グレーのハートを表示
                                        echo '<img src="'.HOME_URL.'views/img/icon-heart.svg" alt="">';
                                    } 
                                    ?>
                                </div>
                                <div class="like-count">
                                    <?php echo htmlspecialchars($view_tweet['like_count']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>