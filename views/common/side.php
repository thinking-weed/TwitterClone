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
            </li><!--マイアイコンの画像のセッションのユーザー情報から読み取った画像-->
            <li class="nav-item my-icon"><!--左のdata-bs-containerは親要素を受けにくくするためのもの-->
                    <img src="<?php echo htmlspecialchars($view_user['image_path']); ?>" alt="" class="js-popover"
                    data-bs-container="body"  data-bs-toggle="popover" data-bs-placement="right" data-bs-html="true"-
                    data-bs-content="<a href='profile.php'>プロフィール</a><br><a href='sign-out.php'>ログアウト</a>">
            </li>                           <!--toggleオプションでpopoverを初期化とは？おそらくtoggleをつけた-->
        </ul>                               <!--placementオプションでポップを右側に表示-->
    </div>                                  <!--data-bs-html～は次の～contentを書くのに必要なオプション-->
</div>
