<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include_once('../Views/common/head.php'); ?>
    <title>つぶやく画面 / Twitterクローン</title>
    <meta name="description" content="つぶやく画面です">
</head>

<body class="home">
    <div class="container">
        <!-- divタグを使うときのテクニック div.クラス名 とすることで、一気にクラス名までできる -->
        <?php include_once('../Views/common/side.php'); ?>
        <div class="main">
            <div class="main-header">
                <h1>つぶやく</h1>
            </div>

            <!-- つぶやく投稿エリア -->
            <div class="tweet-post">
                <div class="my-icon">
                    <img src="<?php echo htmlspecialchars($view_user['image_path']); ?>" alt="">
                </div>
                <div class="input-area">
                    <form action="post.php" method="post" enctype="multipart/form-data">
                        <!--placeholder属性でtextarea内に文字を表示することができる -->
                        <textarea name="body" placeholder="いまどうしてる？" maxlength="140"></textarea>
                        <div class="bottom-area">
                            <div class="mb-0">
                                <!--mb-0で、margin-bottom=0が適用される-->
                                <input type="file" name="image" class="form-control form-control-sm">
                                <!-- form-controlでモダンなデザインになる。-smで、縦が小さくなる。lgで大きくなる -->
                            </div>
                            <button class="btn" type="submit">つぶやく</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- 仕切りエリア -->
            <div class="ditch"></div>

        </div>
    </div>
    <?php include_once('../Views/common/foot.php'); ?>
</body>

</html>