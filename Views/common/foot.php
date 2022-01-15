    <!-- HTML内にJavaScriptを書くときは、/bodyタグの前に書くべき -->
    <script> //第一引数にDOMContentLoadedを書くと、ブラウザがHTMLの解析を完了した時点で第二引数の関数が実行される。
        document.addEventListener('DOMContentLoaded', function(){
            $('.js-popover').popover();
            // popoverは、クリックされて初めて起動する機能。画像とかに重ねたら出るやつじゃない。HAHAHA
        },false);
    </script>
