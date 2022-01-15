<?php
//includeで、別ファイルを読み込む。onceをつけると一度だけの設定になる。
//設定関連を読み込む
include_once('../config.php');
//便利な関数も読み込む
include_once('../util.php');

//////
// ツイート一覧
/////
$view_tweets = [
    [
        'user_id' => 1,
        'user_name' => 'taro',
        'user_nickname' => '太郎',
        'user_image_name' => 'sample-person.jpg',
        'tweet_body' => '今プログラミングをしています。',
        'tweet_image_name' => null,
        'tweet_created_at' => '2021-11-22 14:00:00',
        'like_id' => null,
        'like_count' => 0,
    ],
    [
        'user_id' => 2,
        'user_name' => 'jiro',
        'user_nickname' => '次郎',
        'user_image_name' => null,
        'tweet_body' => 'コワーキングスペースをオープンしました！',
        'tweet_image_name' => 'sample-post.jpg',
        'tweet_created_at' => '2021-12-23 17:00:00',
        'like_id' => 1,
        'like_count' => 1,
    ]
];


?>
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
                    <input type="text" class="form-control" placeholder="キーワード検索" name="keyword" value="">
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