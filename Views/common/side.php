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
                    <!-- my-iconをセッションのユーザー情報から取得したpathに変更 -->
                    <li class="nav-item my-icon"><img src="<?php echo htmlspecialchars($view_user['image_path']);?>" alt="" class="js-popover"
                    data-bs-container="body" data-bs-toggle="popover" data-bs-placement="right" data-bs-html="true"
                    data-bs-content="<a href='profile.php'>プロフィール</a><br><a href='sign-out.php'>ログアウト</a>"
                    ></li>
                    <!-- データオプションでpopoverの処理にオプションを指定できる。containerオプションでbodyを指定すると、親要素のスタイルの影響を受けにくくなる -->
                    <!-- data-bs-toggleは、トグル機能。クリックするたびにオンオフされる。 -->
                    <!-- data-bs-toggle="popover"を書かないとpopoverは動かない。placementオプションにrightを指定してポップを右側に表示。 -->
                    <!-- htmlオプションをtrueにすることで、その後のコンテントオプションをHTML可する -->
                </ul>
            </div>
        </div>
