<?php
//////////////////////////////
// ユーザーデータを処理
//////////////////////////////

/**
 * 会員登録のユーザー関数
 * 
 * @param array $data
 * @return bool  true|false
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

/**
 *  ユーザー情報取得 : ログインチェックのユーザー関数
 * 
 * @param string $email
 * @param string $password
 * @return array|false
 */
function findUserAndCheckPassword(string $email, string $password){
    // DB接続
    $mysqli = new mysqli(DB_HOST , DB_USER , DB_PASSWORD , DB_NAME);

    // 接続エラーがある場合->処理停止
    if ($mysqli -> connect_errno){
        echo 'MySQLの接続に失敗しました。 :' . $mysqli -> connect_errno . "\n";
        exit;
    }

    // 入力値をエスケープ
    // real_escape_string関数で$emailにSQL文が入っていても実行されないようにする
    $email = $mysqli->real_escape_string($email);

    // SQLクエリを作成
    // - 外部からのリクエストは何が入ってくるかわからないので、必ずエスケープしたものをクオートで囲む
    // SQLインジェクション対策のため、エスケープした$emailを''または""で囲む。
    // ' . $email . 'を""で囲ってる。
    // 会員登録で使用したプレイスホルダー(?,?,?,?)形式で後から値を入れる形なら、エスケープは不要
    $query = 'SELECT * FROM users WHERE email = "' . $email . '"';

    // クエリ実行
    // $resultにユーザー情報が入る。
    $result = $mysqli->query($query);

    // クエリ実行に失敗した場合->return
    // if(!$result)は、ユーザー情報が無い場合ということ。
    if(!$result){
        //MySQL処理中にエラー発生
        echo 'エラーメッセージ: ' . $mysqli->errno . "\n";
        $mysqli->close();
        return false;
    }

    // ユーザー情報を取得
    // fetch_arrayメソッドはレコードを1件取得する
    // fetch_array(MYSQLI_ASSOC)は、連想配列として取得される。他にMYSQLI_NUMとBOTHがある。
    // 新しめの情報が見つからなかった。多分変わってない？
    $user = $result->fetch_array(MYSQLI_ASSOC);
    // ユーザーが存在しない場合->return
    if(!$user){
        $mysqli->close();
        return false;
    }

    // パスワードチェック、不一致の場合->return
    // password_verify関数で
    // 入力されたパスワードとデータベースに保存されたパスワードのハッシュ値を比較して一致するかチェック
    // 不一致だった場合にfalseを返す。!がついてるので、一致しない場合って文。
    if(!password_verify($password, $user['password'])){
        $mysqli->close();
        return false;
    }

    // DB接続を解放
    $mysqli->close();

    return $user;
}