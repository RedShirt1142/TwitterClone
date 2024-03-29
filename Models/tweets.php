<?php
////////////////////////
// ツイートデータを処理
////////////////////////

/**
 * ツイート作成
 * 
 * @param array $data
 * @return bool true|false
 */
function createTweet(array $data){
    // DB接続
    $mysqli = new mysqli(DB_HOST , DB_USER , DB_PASSWORD , DB_NAME);

    // 接続エラーがある場合->処理停止
    if ($mysqli -> connect_errno){
        echo 'MySQLの接続に失敗しました。 :' . $mysqli -> connect_error . "\n";
        exit;
    }

    // 新規登録のSQLクエリを作成
    $query = 'INSERT INTO tweets (user_id, body, image_name) VALUES (?,?,?)';

    // プリペアドステートメントにクエリを登録
    $statement = $mysqli->prepare($query);

    // プレースホルダにカラム値を紐付け (i=int, s=string)
    // user_id=int body,image_name=string
    $statement->bind_param('iss', $data['user_id'], $data['body'], $data['image_name']);

    // クエリを実行
    $response = $statement->execute();
    if ($response === false){
        echo 'エラーメッセージ: ' . $mysqli->error . "\n";
    }

    // DB接続を解放
    $statement->close();
    $mysqli->close();

    return $response;
}

/**
 * ツイート一覧を取得
 * 
 * @param array $user ログインしているユーザー情報
 * @param string $keyword 検索キーワード
 * @return array|false
 */
function findTweets(array $user, string $keyword = null){
    // キーワード検索をしない可能性があるので、$keywordにはnullを許容
    // DB接続
    $mysqli = new mysqli(DB_HOST , DB_USER , DB_PASSWORD , DB_NAME);

    // 接続エラーがある場合->処理停止
    if ($mysqli -> connect_errno){
        echo 'MySQLの接続に失敗しました。 :' . $mysqli -> connect_error . "\n";
        exit;
    }

    // ログインユーザーIDをエスケープ
    $login_user_id = $mysqli->real_escape_string($user['id']);

    // 検索のSQLクエリを作成
    $query = <<<SQL
        SELECT
            T.id AS tweet_id,
            T.status AS tweet_status,
            T.body AS tweet_body,
            T.image_name AS tweet_image_name,
            T.created_at AS tweet_created_at,
            U.id AS user_id,
            U.name AS user_name,
            U.nickname AS user_nickname,
            U.image_name AS user_image_name,
            -- ログインユーザーがいいね！したか(いいね！している場合、値が入る)
            L.id AS like_id,
            -- いいね！数 相関サブクエリ 処理が重くなることがある
            (SELECT COUNT(*) FROM likes WHERE status = 'active' AND tweet_id = T.id) AS like_count
        FROM -- カラム名やテーブル名 AS 名前 とすると、別名をつけることができる。
            tweets AS T
            -- ユーザーテーブルをusers.idとtweets.user_idで紐付ける
            JOIN
            users AS U ON U.id = T.user_id AND U.status = 'active'
            -- いいね！テーブルをlikes.tweet_idとtweets.idで紐付ける
            LEFT JOIN
            likes AS L ON L.tweet_id = T.id AND L.status = 'active' AND L.user_id = '$login_user_id'

        WHERE -- T.status tweetsテーブルのステータス
            T.status = 'active'
    SQL;

    // 検索キーワードが入力されていた場合
    if (isset($keyword)){
        // エスケープ
        $keyword = $mysqli->real_escape_string($keyword);
        // ツイート主のニックネーム・ユーザー名・本文から部分一致検索
        // CONCATは複数の文字・カラムを連結することができる。
        $query .= ' AND CONCAT(U.nickname, U.name, T.body) LIKE "%' . $keyword . '%"';
    }

    // 新しい順に並び替え
    // DESC 数の大きい順
    $query .= ' ORDER BY T.created_at DESC';
    // 表示件数を50件まで
    $query .= ' LIMIT 50';

    // クエリ実行
    //$result = $mysqli->query($query);
    //if ($result){
    if ($result = $mysqli->query($query)) {
        // データを配列で受け取る fetch_all 実行結果から、全てのレコードを取得する(配列)
        $response = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $response = false;
        echo 'エラーメッセージ: ' . $mysqli->error . "\n";
    }

    $mysqli->close();

    return $response;
}