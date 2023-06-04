<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="会員登録画面です">
    <title>会員登録画面 / Twitterクローン</title>
    <link href="../../../fontawesome-free-6.4.0-web/css/all.min.css">
    <link rel="icon" href="../views/img/logo-twitterblue.svg">
    <!--bootstrapのrink-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../views/css/style.css">
    </head>
<body class="sign-up text-center">   <!--text-centerをつけることで勝手に中央寄せしてくれる-->
    <main class="form-sign-up">
        <form action="sign-up.php" method="post">
            <img src="../views/img/logo-white.svg" alt="" class="logo-white">
            <h1>アカウントを作る</h1>   <!--form-controlはbootstrap専用のクラスでなんとなくいい感じにしてくれる-->
            <input type="text" class="form-control" name="nickname" placeholder="ニックネーム" maxlength="50" required autofocus>
            <!--placeholderはテキスト部分の背景文字を、maxlengthで入力可能文字数を入力、required は必須、autofocusはページ表示時自動選択されている状態にする設定-->
            <input type="text" class="form-control" name="name" placeholder="ユーザー名、例）techis132" maxlength="50" required >
            <input type="email" class="form-control" name="email" placeholder="メールアドレス" maxlength="254" required >
            <input type="password" class="form-control" name="password" placeholder="パスワード" minlength="4" maxlength="128" required >
            <button class="w-100 btn btn-lg" type="submit">登録する</button>
                <!--w-100はwidth100「%」、btn-lgは大きな(large)ボタン-->
            <p class="mt-3 mb-2"><a href="sign-in.php">ログインする</a></p>
            <!--※mt-3はmargin-topが1rem、mb-2はmargin-bottomが0.5rem、-->
            <p class="mt-2 mb-3 text-muted">&copy; 2021</p>
        </form><!--text-mutedは文字を灰色にする、&copy;で〇cになる-->
    </main>
</body>
</html>