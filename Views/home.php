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
    <title>ホーム画面 / Twitterクローン</title>
    <meta name="description" content="ホーム画面です">
</head>

<body class="home">
    <div class="container">
        <!-- divタグを使うときのテクニック div.クラス名 とすることで、一気にクラス名までできる -->
        <?php include_once('../Views/common/side.php'); ?>
        <div class="main">
            <div class="main-header">
                <h1>ホーム</h1>
            </div>

            <!-- つぶやき投稿エリア -->
            <div class="tweet-post">
                <div class="my-icon">
                    <img src="<?php echo HOME_URL; ?>Views/img_uploaded/user/sample-person.jpg" alt="">
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

            <!-- つぶやき一覧エリア -->
            <!-- HTML内でif文などを書くとき 
                 php if(条件) : ?
                 php else : ?
                 php endif; ?
                のように、:と;を使うと、{}を使わなくて良くなる。スマート。 -->
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