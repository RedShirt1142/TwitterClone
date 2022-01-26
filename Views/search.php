<!DOCTYPE html>
<html lang="ja">

<head>
    <?php include_once('../Views/common/head.php'); ?>
    <title>検索画面 / Twitterクローン</title>
    <meta name="description" content="検索画面です">
</head>

<body class="home search text-center">
    <div class="container">
        <!-- divタグを使うときのテクニック div.クラス名 とすることで、一気にクラス名までできる -->
        <?php include_once('../Views/common/side.php'); ?>
        <div class="main">
            <div class="main-header">
                <h1>検索</h1>
            </div>

            <!-- 検索エリア -->
            <form action="search.php" method="get">
                <div class="search-area">
                    <input type="text" class="form-control" placeholder="キーワード検索" name="keyword" value="<?php echo htmlspecialchars($view_keyword); ?>">
                    <button type="submit" class="btn">検索</button>
                </div>
            </form>

            <!-- 仕切りエリア -->
            <div class="ditch"></div>

            <!-- つぶやき一覧エリア -->
            <?php if (empty($view_tweets)) : ?>
                <p class="p-3">ツイートがありません</p>
                <!-- p-3はブートストラップのやつで、padding-3ってこと。全方向に1remの余白を空ける -->
            <?php else : ?>
                <div class="tweet-list">
                    <?php foreach ($view_tweets as $view_tweet) : ?>
                        <!-- $view_tweetに入っている配列を1個ずつ呼び出す関数。tweet-listのdivの中じゃないと意味が無いよ。 -->
                        <!-- 今回の場合、$view_tweetはいわゆるvalueにあたる。以下呼び出すのはvalueの方。 -->
                        <?php include('../Views/common/tweet.php'); ?>
                        <!-- foreach内でinclude_onceすると、つぶやきが1件しか読み込まれないので、onceは外す。 -->
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include_once('../Views/common/foot.php'); ?>
</body>

</html>