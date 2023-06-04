<?php
//includeでもファイル読み込みができる。_onceをつけることで１回しか読み込みしない設定にする
//設定関連を読み込む
include_once('../config.php');
//便利な関数を読み込む
include_once('../util.php');


//下の行までが一旦phpの区切り
?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include_once('../views/common/head.php');?>
    <meta name="description" content="通知画面です">
    <title>通知画面 / Twitterクローン</title>
</head>
<body class="home notification text-center">
    <div class="container">
        <?php include_once('../views/common/side.php'); ?>
        <div class="main">
            <div class="main-header">
                <h1>通知</h1>
            </div>

            <!--仕切りエリア-->
            <div class="ditch">
            </div>
            <!--通知一覧エリア-->
            <div class="notification-list">
                <?php if(isset($_GET['case'])): ?>
                    <p class="no-result">通知はまだありません。</p>
                <?php else : ?>
                    <div class="notification-item">
                        <div class="user">
                            <img src="<?php echo HOME_URL; ?>views/img_uploaded/user/sample-person.jpg" alt="">
                        </div>
                        <div class="content">
                            <p>いいね！されました。</p>
                        </div>
                    </div>

                    <div class="notification-item">
                        <div class="user">
                            <img src="<?php echo HOME_URL; ?>views/img_uploaded/user/sample-person.jpg" alt="">
                        </div>
                        <div class="content">
                            <p>フォローされました。</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!--Javascriptのscriptタグはボディの閉じタグの上に基本書く-->
    <?php include_once('../views/common/foot.php'); ?>
</body>
</html>