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
    <meta name="description" content="つぶやく画面です">
    <title>つぶやく画面 / Twitterクローン</title>
</head>
<body class="home">
    <div class="container">
        <?php include_once('../views/common/side.php'); ?>
        <div class="main">
            <div class="main-header">
                <h1>つぶやく</h1>
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
        </div>
    </div>
    <!--Javascriptのscriptタグはボディの閉じタグの上に基本書く-->
    <?php include_once('../views/common/foot.php'); ?>
</body>
</html>