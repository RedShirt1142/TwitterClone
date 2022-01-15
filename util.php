<?php

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
// ../Viewsを <?php echo HOME_URL;？＞/Views に置き換え。
// 編集→フォルダーを指定して置換→置換したい文字列と置換後の文字列を記入、変換して大丈夫かどうか確認して一括変換が可能。

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
