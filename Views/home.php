<?php
//エラー表示する設定。ini_set文。
ini_set('display_errors',1);
// 日本時間にする
date_default_timezone_set('Asia/Tokyo');
// URL/ディレクトリを定数に設定する
define('HOME_URL','http://localhost:8888/TwitterClone/');
//defineは定数を指定する関数。URLをHOME_URLという名前の定数にしている。呼び出すときはHOME_URLだけでいい。
//http~localhostは省略可。というか入れたら動かなかったのだが･･･調べたらなんかうまくできた。よくわからんが、8888が必要だったみたい。
//置換(../を上で作った定数に変更。)編集→置換→上に置換する文字列、下に変更後の文字列を記入。一括置換が可能。
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

/////
//便利な関数
/////
//関数を作るときは、Docコメントを書きましょう。以下に書いてるやつ

/**
 * 画像ファイル名から画像のURLを生成する
 * 
 * @param string $name 画像ファイル名
 * @param string $type user | tweet  画像がアイコン画像なのかツイート画像なのかの識別
 * @return string  URLが返るのでstringにしておく。
 */
function buildImagePath(string $name = null, string $type) //画像ファイルが無いこともあるので、nullを許可。
{
    if ($type === 'user' && !isset($name)){ // $typeがuserで、かつ$nameが存在しないとき、デフォ画像にするif文
        return HOME_URL . 'Views/img/icon-default-user.svg';
    }

    return HOME_URL . 'Views/img_uploaded/' . $type . '/' . htmlspecialchars($name);
    //$typeがそのままディレクトリ名に入る。userまたはtweet。
    //htmlspecialcharsは、タグに使うような特殊文字を通常文字として扱えるように変換する関数。画像ファイル名に<>とかが入ってたら困るから使う。
}

/**
 * 指定した日時からどれだけ経過したかを取得
 * 
 * @param string $datetime 日時  ←引数の情報
 * @return string               ←戻り値の情報
 */

// 引数の$datetimeは2021-03-15 14:00:00 西暦から秒数までのこの形でデータが入ってくる想定。
// stringはタイプヒンティング(型宣言)と言い、違う型が入ったとき、エラーになるので、ミスに気づきやすくなる。
function convertToDayTimeAgo(string $datetime){
    $unix = strtotime($datetime);  //unixtimeに変換(unixtimeとは、1970年1月1日からの経過秒数)
    $now = time(); //unixtime開始から現在までの秒数を返す
    $diff_sec = $now - $unix;  //unixtime始まりから現在までの秒数から投稿日時までの秒数を引く→投稿日時から現在までの秒数がわかる

    //$diff_secを使って現在とどれだけ差があるかを調べる。
    if ($diff_sec < 60){ // =1分
        $time = $diff_sec;
        $unit = '秒前';
    } elseif ($diff_sec < 3600){ // =1時間
        $time = $diff_sec / 60;
        $unit = '分前';
    } elseif ($diff_sec < 86400){ // =24時間
        $time = $diff_sec / 3600;
        $unit = '時間前';
    }elseif ($diff_sec < 2764800){  // =32日
        $time = $diff_sec / 86400;
        $unit = '日前';
    } else {

        // 現在の年と投稿日の年が違うときは年まで表示するif文(!==はイコールじゃないってこと)
        if (date('Y') !== date('Y', $unix)){
            $time = date('Y年n月j日', $unix);
        } else {
            $time = date('n月j日', $unix);
        }
        return $time;
    }

    return (int)$time . $unit;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo HOME_URL;?>Views/img/logo-twitterblue.svg">
    <!--Bootstrap CSS -->
    <!-- getbootstrap.jp(または.com)からjsDelivrの欄からCSSonlyをコピーして、リンクタグのcssの上に貼り付ける -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo HOME_URL;?>Views/css/style.css">
    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous" defer></script>
    <!-- JavaScript Bundle with Popper -->  <!-- Javaのbootstrapはjqueryに依存してるので、jqueryを先に書く。 -->
    <!-- 最新版を使いたいときはサイトから最新版のコードを引用すること。code.jquery.com  getbootstrap.jp -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous" defer></script>
    <!-- いいね用JS -->
    <script src="<?php echo HOME_URL; ?>Views/js/likes.js" defer></script>
    <!-- defer属性を付与すると、JSよりHTMLの解析の方が先にされるので、サイトの表示が速くなる。ただし、通常通り表示したいJSも遅く表示されることになるので、defer属性に依存していた場合エラーになる可能性があるので注意が必要 -->

    <title>ホーム画面 / Twitterクローン</title>
    <meta name="description" content="ホーム画面です">
</head>

<body class="home">
    <div class="container">   <!-- divタグを使うときのテクニック div.クラス名 とすることで、一気にクラス名までできる -->
        <div class="side"> <!-- div.side でこうなる-->
            <div class="side-inner">
                <ul class="nav flex-column">  <!-- navはメニューに適したレイアウトが適用される。flex-columnは子要素を上から下に並べる。それぞれbootstrapの機能 -->
                                              <!-- ul.nav.flex-columnって書き方。 -->
                                              <!-- bootstrapの機能はクラス名に使った時点で適用されるようだ -->
                                              <!-- なので、cssを当てなくてもクラス名に使うだけで価値がある。 -->
                    <li class="nav-item"><a href="home.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/logo-twitterblue.svg" alt="" class="icon"></a></li>
                    <li class="nav-item"><a href="home.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-home.svg" alt=""></a></li>
                    <li class="nav-item"><a href="search.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-search.svg" alt=""></a></li>
                    <li class="nav-item"><a href="notification.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-notification.svg" alt=""></a></li>
                    <li class="nav-item"><a href="profile.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-profile.svg" alt=""></a></li>
                    <li class="nav-item"><a href="post.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-post-tweet-twitterblue.svg" alt="" class="post-tweet"></a></li>
                    <li class="nav-item my-icon"><img src="<?php echo HOME_URL;?>Views/img_uploaded/user/sample-person.jpg" alt="" class="js-popover"
                    data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-html="true"
                    data-bs-content="<a href='profile.php'>プロフィール</a><br><a href='sign-out.php'>ログアウト</a>"
                    ></li>
                    <!-- データオプションでpopoverの処理にオプションを指定できる。containerオプションでbodyを指定すると、親要素のスタイルの影響を受けにくくなる -->
                    <!-- data-bs-toggle="popover"を書かないとpopoverは動かない。placementオプションにrightを指定してポップを右側に表示。 -->
                    <!-- htmlオプションをtrueにすることで、その後のコンテントオプションをHTML可する -->
                </ul>
            </div>
        </div>
        <div class="main">
            <div class="main-header">
                <h1>ホーム</h1>
            </div>
            
            <!-- つぶやき投稿エリア -->
            <div class="tweet-post">
                <div class="my-icon">
                    <img src="<?php echo HOME_URL;?>Views/img_uploaded/user/sample-person.jpg" alt="">
                </div>
                <div class="input-area">
                    <form action="post.php" method="post" enctype="multipart/form-data"> <!--placeholder属性でtextarea内に文字を表示することができる -->
                        <textarea name="body" placeholder="いまどうしてる？" maxlength="140"></textarea>
                        <div class="bottom-area">
                            <div class="mb-0"><!--mb-0で、margin-bottom=0が適用される-->
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
            <?php if (empty($view_tweets)) : ?>
                <p class="p-3">ツイートがありません</p> 
                <!-- p-3はブートストラップのやつで、padding-3ってこと。全方向に1remの余白を空ける -->
            <?php else: ?>
            <div class="tweet-list">
            <?php foreach($view_tweets as $view_tweet) : ?>
                    <!-- $view_tweetに入っている配列を1個ずつ呼び出す関数。tweet-listのdivの中じゃないと意味が無いよ。 -->
                    <!-- 今回の場合、$view_tweetはいわゆるvalueにあたる。以下呼び出すのはvalueの方。 -->
                <div class="tweet">
                    <div class="user">
                        <!-- user-idなどを配列データに置き換える。 -->
                        <a href="profile.php?user_id=<?php echo htmlspecialchars($view_tweet['user_id']); ?>">
                            <img src="<?php echo buildImagePath($view_tweet['user_image_name'], 'user');?>" alt="">
                        </a>
                    </div>
                    <div class="content">
                        <div class="name">
                            <a href="profile.php?user_id=<?php echo htmlspecialchars($view_tweet['user_id']); ?>">
                                <span class="nickname"><?php echo htmlspecialchars($view_tweet['user_nickname']); ?></span>
                                <span class="user-name">@<?php echo htmlspecialchars($view_tweet['user_name']); ?> ・<?php echo convertToDayTimeAgo($view_tweet['tweet_created_at']); ?></span>
                                                                                                <!-- convertToDayTimeAgo($datetime=($view_tweet['tweet_created_at'])) -->
                            </a>
                        </div>
                        <p><?php echo $view_tweet['tweet_body']; ?></p>

                        <?php if (isset($view_tweet['tweet_image_name'])): ?>
                            <img src="<?php echo buildImagePath($view_tweet['tweet_image_name'],'tweet');?>" alt="" class="post-image">
                        <?php endif;?>

                        <div class="icon-list">
                            <div class="like js-like" data-like-id="<?php echo htmlspecialchars($view_tweet['like_id']);?>">
                            <!-- js-likeクラスをつけることで、作ったjs-like関数を使っている -->
                                <?php  //いいねがあるかないかで処理を分ける。
                                if (isset($view_tweet['like_id'])){ // isset関数は、変数があればtrue、無ければfalseを返す
                                    //いいねがあるときは青のハート
                                    echo '<img src="' . HOME_URL . 'Views/img/icon-heart-twitterblue.svg" alt="">';
                                    //HOME_URLは定数なので、URLに直接ぶっ込めない。.でつなげている。
                                } else {
                                    //いいねが無いときは灰のハート
                                    echo '<img src="' . HOME_URL . 'Views/img/icon-heart.svg" alt="">';
                                }
                                ?>
                            </div>
                            <div class="like-count js-like-count"><?php echo htmlspecialchars($view_tweet['like_count']); ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- HTML内にJavaScriptを書くときは、/bodyタグの前に書くべき -->
    <script> //第一引数にDOMContentLoadedを書くと、ブラウザがHTMLの解析を完了した時点で第二引数の関数が実行される。
        document.addEventListener('DOMContentLoaded', function(){
            $('.js-popover').popover();
            // popoverは、クリックされて初めて起動する機能。画像とかに重ねたら出るやつじゃない。HAHAHA
        },false);
    </script>
</body>
</html>