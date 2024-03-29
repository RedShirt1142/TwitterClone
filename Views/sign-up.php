<!-- アプリケーション設定はコントローラーで読み込むので、こっちは削除 -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include_once('../Views/common/head.php'); ?>
    <!-- macは、command+shift+Lで同じ文字列を一気に編集できる。escで戻る。 -->
    <title>会員登録画面 / Twitterクローン</title>
    <meta name="description" content="会員登録画面です">
</head>
<body class="signup text-center">
    <main class="form-signup">
        <form action="sign-up.php" method="post">
            <img src="<?php echo HOME_URL;?>Views/img/logo-white.svg" alt="" class="logo-white">
            <h1>アカウントを作る</h1> 
            <!-- form-controlはモダンなデザインになるクラス。requiredは必須入力。autofocusはページが開かれたとき自動で選択される。 -->
            <input type="text" class="form-control" name="nickname" placeholder="ニックネーム" maxlength="50" required autofocus>
            <input type="text" class="form-control" name="name" placeholder="ユーザー名、例)techis132" maxlength="50" required>
            <input type="email" class="form-control" name="email" placeholder="メールアドレス" maxlength="254" required>
            <input type="password" class="form-control" name="password" placeholder="パスワード" minlength="4" maxlength="128" required>
            <!-- w-100はwidth:100%、btn-lgは大きいボタン -->
            <button class="w-100 btn btn-lg" type="submit">登録する</button>
            <!-- mt-3 mb-2はmarginのtop1rem、bottom0.5rem -->
            <p class="mt-3 mb-2"><a href="sign-in.php">ログインする</a></p>
            <!-- text-mutedは文字が灰色になる -->
            <p class="mt-2 mb-3 text-muted">&copy; 2022</p>
        </form>
    </main>
    <?php include_once('../Views/common/foot.php'); ?>
</body>
</html>