<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include_once('../views/common/head.php');?>
    <meta name="description" content="ホーム画面です">
    <title>ホーム画面 / Twitterクローン</title>
</head>
<body class="home">
    <div class="container">
        <?php include_once('../views/common/side.php'); ?>
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
                    <?php include('../views/common/tweet.php'); ?>
                    <!--tweet.phpではforeachを回しているが、onceがあると最初の１組目しか回されないので
                    ここでは外す-->
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <!--Javascriptのscriptタグはボディの閉じタグの上に基本書く-->
    <?php include_once('../views/common/foot.php'); ?>
</body>
</html>