////////////////
// いいね！用のJavaScript
////////////////

//JavaScript内でクラス名を書くときは.js-likeのように.をつける。

$(function(){
    // いいね！がクリックされたとき
    $('.js-like').click(function(){  //js-likeクラスがクリックされたときに実行される関数
        const this_obj = $(this);  
        // $(this)は、jQueryの要素で、この場合、クリックされたjs-like要素が入る。
        // 自動的に値を代入してくれる。
        const like_id = $(this).data('like-id'); 
        // クリックされた要素(.js-like)のdata属性のlike-idが入る。
        const like_count_obj = $(this).parent().find('.js-like-count'); 
        // クリック要素の中にあるjs-like-countクラスの要素が入る。
        // parentは、jQueryの要素で、1段階上の階層(親要素)を取得することができる。
        // この場合、js-likeの親要素であるicon-listからfindで中にあるjs-like-countクラスを取得する。
        // $(起点にする要素).parent()で、要素の親要素を取得する。findを入れないとicon-listが取得される。
        let like_count = Number(like_count_obj.html()); 
        //js-like-count要素からいいね数を取得。可変なのでletで宣言。

        if(like_id){
            // like_idがすでにある=いいね済みのときはクリックされたらいいねを取り消す
            // いいね取り消しはcountを減らす
            like_count--;
            like_count_obj.html(like_count);  //減らしたいいね数(like_count)をhtmlにセットしている
            this_obj.data('like-id',null);  //クリック要素のデータ属性のlike-idにnullを代入

            // いいね！ボタンの色をグレーに変更
            $(this).find('img').attr('src','../Views/img/icon-heart.svg');
            // attrはjQueryの要素で、attr(<target>,<value>)のように、
            // 第一引数に変更したい属性、第二引数に設定したい値を入力することで値を変更することができる。
            // 手前で指定した場所(タグ名)から探してくる。
            // この場合、js-likeクラスのimgタグのsrc属性を書き換えている。

        } else {
            // そうでないときはいいねをつける
            // いいね付与はcountを増やす
            like_count++;
            like_count_obj.html(like_count);
            this_obj.data('like-id',true);  
            //後にサーバーから取得してきたlike-idをここにセットする予定だが、ここではtrueとする。

            // いいね！ボタンの色を青に変更
            $(this).find('img').attr('src','../Views/img/icon-heart-twitterblue.svg');
        }

    })
})

// HTMLから取り込んでいる要素は、data属性のlike-idと、js-like-countの2種類