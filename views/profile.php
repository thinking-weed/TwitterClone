<?php
//includeでもファイル読み込みができる。_onceをつけることで１回しか読み込みしない設定にする
//設定関連を読み込む
include_once('../config.php');
//便利な関数を読み込む
include_once('../util.php');

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
    ]
];

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include_once('../views/common/head.php');?>
    <meta name="description" content="プロフィール画面です">
    <title>プロフィール画面 / Twitterクローン</title>
</head>
<body class="home profile text-center">
    <div class="container">
    <?php include_once('../views/common/side.php'); ?>
        <div class="main">
            <div class="main-header">
                <h1>太郎</h1>
            </div>
            <!--プロフィールエリア-->
            <div class="profile-area">
                <div class="top">
                    <div class="user"><img src="<?php echo HOME_URL; ?>views/img_uploaded/user/sample-person.jpg" alt=""></div>
                    
                    <?php if(isset($_GET['user_id'])): ?>
                        <!--相手のページ-->
                        <?php if(isset($_GET['case'])): ?>
                            <button class="btn btn-sm">フォローを外す</button>
                        <?php else: ?>
                            <button class="btn btn-reverse btn-sm">フォローする</button>
                        <?php endif; ?><!--制御構文内の文書は変数を使わない場合はechoがなくても出力される-->
                    <?php else: ?>
                    <!--自分のページ-->
                        <button class="btn btn-reverse btn-sm" data-bs-toggle="modal" data-bs-target="#js-modal">プロフィール編集</button>
                    <?php endif; ?>
                    
                    <div class="modal fade" id="js-modal" tabindex="-1" area-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="profile.php" method="post" enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <h5 class="modal-title">プロフィールを編集</h5><!--aria-labelで端末が読み上げるようにする-->
                                        <button class="btn-close"type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="user">
                                            <img src="<?php echo HOME_URL; ?>views/img_uploaded/user/sample-person.jpg" alt="">
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="mb-1">プロフィール写真</label>
                                            <input type="file" class="form-control form-control-sm" name="image">
                                        </div>
                                        <input type="text" class="form-control mb-4" name="nickname" value="太郎" placeholder="ニックネーム" maxlength="50" required >
                                        <!--placeholderはテキスト部分の背景文字を、maxlengthで入力可能文字数を入力、required は必須、autofocusはページ表示時自動選択されている状態にする設定-->
                                        <input type="text" class="form-control mb-4" name="name" value="taro" placeholder="ユーザー名、例）techis132" maxlength="50" required >
                                        <input type="email" class="form-control mb-4" name="email" value="taro@techis.jp" placeholder="メールアドレス" maxlength="254" required >
                                        <input type="password" class="form-control mb-4" name="password" placeholder="パスワードを変更する場合ご入力ください" minlength="4" maxlength="128" >

                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-reverse" data-bs-dismiss="modal">キャンセル</button>
                                        <button class="btn" type="submit">保存する</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!--modalとは、プロフィール編集ボタンを押したら出てくるポップアップようなもの-->
                        <!--tabindex="-1"でタブ操作から除外？、area-hidden="true"は端末の読み上げ操作防止（セキリティ？）-->
                <div class="name">太郎</div>
                <div class="text-muted">@taro</div>
                <div class="follow-follower">
                    <div class="follow-count">1</div>
                    <div class="follow-text">フォロー中</div>
                    <div class="follow-count">1</div>
                    <div class="follow-text">フォロワー</div>
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