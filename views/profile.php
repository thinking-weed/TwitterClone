<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="プロフィール画面です">
    <title>プロフィール画面 / Twitterクローン</title>
    <link href="../../../fontawesome-free-6.4.0-web/css/all.min.css">
    <link rel="icon" href="../views/img/logo-twitterblue.svg">
    <!--bootstrapのrink-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../views/css/style.css">
    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" defer></script>
    <!-- JavaScript Bundle with Popper　下のBootstrapのscriptは上のjQueryの仕様に依存しているため下に貼り付けた -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous" defer></script>
    <!--いいね！のjavascript、後ろのdeferはscriptの読み込みよりhtmlの読み込みを優先させる属性⇒全体の表示が早くなる-->
    <script src="../views/js/Likes.js" defer></script>
    </head>
<body class="home profile text-center">
    <div class="container">
        <div class="side">
            <div class="side-inner">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="home.php" class="nav-link">
                            <img src="../views/img/logo-twitterblue.svg" alt="" class="icon">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="home.php" class="nav-link">
                            <img src="../views/img/icon-home.svg" alt="">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="search.php" class="nav-link">
                            <img src="../views/img/icon-search.svg" alt="">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="notification.php" class="nav-link">
                            <img src="../views/img/icon-notification.svg" alt="">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="profile.php" class="nav-link">
                            <img src="../views/img/icon-profile.svg" alt="">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="post.php" class="nav-link">
                            <img src="../views/img/icon-post-tweet-twitterblue.svg" alt="" class="post-tweet">
                        </a>
                    </li>
                    <li class="nav-item my-icon"><!--左のdata-bs-containerは親要素を受けにくくするためのもの-->
                            <img src="../views/img_uploaded/user/sample-person.jpg" alt="" class="js-popover"
                            data-bs-container="body"  data-bs-toggle="popover" data-bs-placement="right" data-bs-html="true"-
                            data-bs-content="<a href='profile.php'>プロフィール</a><br><a href='sign-out.php'>ログアウト</a>">
                    </li>                           <!--toggleオプションでpopoverを初期化とは？おそらくtoggleをつけた-->
                </ul>                               <!--placementオプションでポップを右側に表示-->
            </div>                                  <!--data-bs-html～は次の～contentを書くのに必要なオプション-->
        </div>
        <div class="main">
            <div class="main-header">
                <h1>太郎</h1>
            </div>
            <!--プロフィールエリア-->
            <div class="profile-area">
                <div class="top">
                    <div class="user"><img src="../views/img_uploaded/user/sample-person.jpg" alt=""></div>
                    
                    <?php if(isset($_GET['user_id'])): ?>
                        <!--相手のページ-->
                        <?php if(isset($_GET['case'])): ?>
                            <button class="btn btn-sm">フォローを外す</button>
                        <?php else: ?>
                            <button class="btn btn-reverse btn-sm">フォローする</button>
                        <?php endif; ?>
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
                                            <img src="../views/img_uploaded/user/sample-person.jpg" alt="">
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
            <!---TODOつぶやき一覧エリア-->
        </div>
    </div>
    <!--Javascriptのscriptタグはボディの閉じタグの上に基本書く-->
    <script>
        document.addEventListener('DOMContentLoaded',function(){
            $('.js-popover').popover();     //第２引数の関数の処理部分
        },false);//'DOMContentLoaded'はブラウザがHTMLを解析した直後、第二引数の関数が実行
    </script>
</body>
</html>