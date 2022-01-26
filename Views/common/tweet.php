<div class="tweet">
    <div class="user">
        <!-- user-idなどを配列データに置き換える。 -->
        <a href="profile.php?user_id=<?php echo htmlspecialchars($view_tweet['user_id']); ?>">
            <img src="<?php echo buildImagePath($view_tweet['user_image_name'], 'user'); ?>" alt="">
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

        <?php if (isset($view_tweet['tweet_image_name'])) : ?>
            <img src="<?php echo buildImagePath($view_tweet['tweet_image_name'], 'tweet'); ?>" alt="" class="post-image">
        <?php endif; ?>

        <div class="icon-list">
            <div class="like js-like" data-tweet-id="<?php echo htmlspecialchars($view_tweet['tweet_id']); ?>" data-like-id="<?php echo htmlspecialchars($view_tweet['like_id']); ?>">
                <!-- js-likeクラスをつけることで、作ったjs-like関数を使っている -->
                <?php  //いいねがあるかないかで処理を分ける。
                if (isset($view_tweet['like_id'])) { // isset関数は、変数があればtrue、無ければfalseを返す
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