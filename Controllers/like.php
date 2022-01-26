<?php
/////////////////////
// ライクコントローラー
/////////////////////

// 設定を読み込み
include_once '../config.php';
// 便利な関数を読み込む
include_once '../util.php';
// いいね！データ操作モデルを読み込む
include_once '../Models/likes.php';

// -----------------------------
// ログインチェック
// -----------------------------
$user = getUserSession();
// ログインしていない場合
if (!$user){
    // 404エラー
    header('HTTP/1.0 404 Not Found');
    exit;
}

// -----------------------------
// いいね！する
// -----------------------------
$like_id = null;
// tweet_idがPOSTされた場合
if (isset($_POST['tweet_id'])){
    // 登録する内容を$dataにまとめる
    $data = [
        'tweet_id' => $_POST['tweet_id'],
        'user_id' => $user['id'],
    ];
    // いいね！登録
    $like_id = createLike($data);
}

// -----------------------------
// いいね！取り消し
// -----------------------------
// like_id がPOSTされた場合
if (isset($_POST['like_id'])){
    $data = [
        'like_id' => $_POST['like_id'],
        'user_id' => $user['id'],
    ];
    // いいね！削除
    deleteLike($data);
}

// -----------------------------
// JSON形式で結果を返却
// -----------------------------
// JSON形式とは テキストベースのフォーマット javascriptなんたら
$response = [
    'message' => 'successful',
    // いいね！したときに値が入る
    'like_id' => $like_id,
];
// 返却したコンテンツがどういった形式で作られているのかをブラウザに伝える
header('Content-Type: application/json; charset=uft-8');
// 配列のデータをjson形式にして出力
echo json_encode($response);