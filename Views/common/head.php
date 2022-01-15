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

