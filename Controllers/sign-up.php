<?php
///////////////////////
// サインアップコントローラー
///////////////////////

// コントローラーの流れ
// 最初にアプリケーションの設定や、コントローラーで使うモデルや関数を読み込み
// 処理を行い
// 最後にまとめて結果を出力する。
// これがコントローラーの定番。今後作成するコントローラーもだいたいこんなの。

// 設定を読み込み
include_once '../config.php';
// 便利な関数を読み込む
include_once '../util.php';
// ユーザーデータ操作モデルを読み込み
include_once '../Models/users.php';

// 登録項目が全て入力されていれば
if(isset($_POST['nickname']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])){
    $data = [
        'nickname' => $_POST['nickname'],
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
    ];
    // ユーザーを作成(モデルの方で処理する)し、成功すれば
    if (createUser($data)){
        //ログイン画面に遷移
        //header関数はブラウザに命令ができる。
        // Locationは、以下に書いたURLに遷移させる。
        header('Location: ' . HOME_URL . 'Controllers/sign-in.php');
        exit;
    }
}

// 画面表示
include_once '../Views/sign-up.php';