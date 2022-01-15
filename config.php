<?php
//エラー表示する設定。ini_set文。
ini_set('display_errors',1);
// 日本時間にする
date_default_timezone_set('Asia/Tokyo');
// URL/ディレクトリを定数に設定する
define('HOME_URL','http://localhost:8888/TwitterClone/');
//defineは定数を指定する関数。URLをHOME_URLという名前の定数にしている。呼び出すときはHOME_URLだけでいい。
//http~localhostは省略可。というか入れたら動かなかったのだが･･･調べたらなんかうまくできた。よくわからんが、8888が必要だったみたい。
//置換(../を上で作った定数に変更。)編集→置換→上に置換する文字列、下に変更後の文字列を記入。一括置換が可能。