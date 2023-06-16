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
                <?php if(empty($view_notifications)): ?>
                    <p class="no-result">通知はまだありません。</p>
                <?php else : ?>
                    <?php foreach($view_notifications as $view_notification): ?>
                    <div class="notification-item">
                        <div class="user">
                            <img src="<?php echo buildImagePath($view_notification['user_image_name'],'user')?>" alt="">
                        </div>
                        <div class="content">
                            <p><?php echo htmlspecialchars($view_notification['notification_message']); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!--Javascriptのscriptタグはボディの閉じタグの上に基本書く-->
    <?php include_once('../views/common/foot.php'); ?>
</body>
</html>