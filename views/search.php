<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include_once('../views/common/head.php');?>
    <meta name="description" content="検索画面です">
    <title>検索画面 / Twitterクローン</title>
</head>
<body class="home search text-center">
    <div class="container">
        <?php include_once('../views/common/side.php'); ?>
        <div class="main">
            <div class="main-header">
                <h1>検索</h1>
            </div>

            <!--検索エリア、valueの値でテキストボックスの初期値を設定-->
            <form action="search.php" method="get">
                <div class="search-area">
                    <input type="text" class="form-control" placeholder="キーワード検索"
                    name="keyword" value="<?php echo htmlspecialchars($view_keyword); ?>">
                    <button type="submit" class="btn">検索</button>
                </div>
            </form>
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