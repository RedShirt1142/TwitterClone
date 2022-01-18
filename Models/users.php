<?php
//////////////////////////////
// ユーザーデータを処理
//////////////////////////////

// sign-upコントローラーに関数を実装して会員登録画面を完成させる。

/**
 * 
 * @param array $data
 * @return bool
 */
function createUser(array $data)
{
    // DB接続 mysqli関数でデータベースと接続 接続結果が$mysqliに入る。
    $mysqli = new mysqli(DB_HOST , DB_USER , DB_PASSWORD , DB_NAME);

    // 接続エラーがある場合->処理停止
    // 接続エラーがあった場合、connect_errnoにint型で数字が入ってくる。エラーナンバー
    // データベースが動いていないとサービスが動かないので、接続に失敗したらすぐに処理停止させるのが無難
    if ($mysqli -> connect_errno){
        echo 'MySQLの接続に失敗しました。 :' . $mysqli -> connect_errno . "\n";
        exit;
    }

    // 新規登録(insert)のSQLクエリを作成
    // VALUESの?はプレイスホルダーと言って後で値をセットできる
    // VALUESに直接$data['email']などとしないのは、$data[]にsql文が組み込まれると意図しないsqlが発動してしまうから
    // SQLインジェクション対策のためbind_paramを使う。
    $query = 'INSERT INTO users (email, name, nickname, password) VALUES (?, ?, ?, ?)';

    // プリペアドステートメントに、作成したクエリを登録
    $statement = $mysqli -> prepare($query);

    // パスワードをハッシュ値に変換
    // password_hash関数でパスワードを暗号のような形に変換する。
    // データベースを見られてもパスワードがわからないようになる。
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

    // クエリのプレースホルダ(?の部分)にカラム値を紐付け
    // 全てsなので、全てストリング型で処理される
    // 値の順番を間違えないように。左から順に処理される。
    $statement -> bind_param('ssss', $data['email'], $data['name'], $data['nickname'], $data['password']);

    // クエリを実行
    $response = $statement -> execute();

    // 実行に失敗した場合->エラー表示
    // execute関数はbool型(true/false)で結果が出る
    // →$responseにはtrueかfalseが入る
    if ($response === false){
        echo 'エラーメッセージ : ' . $mysqli->errno . "\n";
    }

    // DB接続を解放
    // phpのスクリプトが終了するタイミングで自動的に接続の解放はされる
    // すぐに解放したい場合は以下のように書く。
    $statement -> close();
    $mysqli -> close();

    return $response;
}