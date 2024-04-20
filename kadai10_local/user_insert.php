<!-- kadai10_PHP04 認証_login.php (PHP・HTML) --> 
<?php
//0.まずこれをしてからコードを書き始める！
//index.phpでクリックしたレコードのidが受け取れているかを確認する.
//確認ができたら直下の4行はコメントアウトすること！
// echo('<pre>');
// var_dump($_POST);
// echo('</pre>');
// exit;

//0.1 最初にSESSIONを開始！！ココ大事！！
session_start();

// 0.5 POSTデータ取得
$name      = filter_input( INPUT_POST, "name" );
$lid       = filter_input( INPUT_POST, "lid" );
$lpw       = filter_input( INPUT_POST, "lpw" );
$kanri_flg = filter_input( INPUT_POST, "kanri_flg" );
$lpw       = password_hash($lpw, PASSWORD_DEFAULT);   //パスワードハッシュ化

// 0.6. 自作関数群の読み込み
include("funcs.php"); // まず、include関数でfuncs.phpを読み込む.

// 0.9. 自作関数sschk()でセッションチェック
sschk();// DB接続する前にセッションチェックを行う

// 1.0 自作関数db_conn()でDB接続
$pdo = db_conn();

//2.0．ユーザーデータ登録
// 2.1 SQL作成(ユーザーデータを登録するSQL文を作成する＝準備） 
$sql = "INSERT INTO user_table(name,lid,lpw,kanri_flg,life_flg)VALUES(:name,:lid,:lpw,:kanri_flg,0)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':kanri_flg', $kanri_flg, PDO::PARAM_INT); //Integer（数値の場合 PDO::PARAM_INT)
// 2.2 実行！$statusにはTrueかFalseが返る.
$status = $stmt->execute();

// 3.0 ユーザーデータ登録処理後
// 3.1. SQLエラー発生時処理（エラーを表示）
// $statusがFalseの場合、つまりSQL実行時にエラーがある場合、
// SQLエラー関数sql_error($stmt)でエラーオブジェクト取得して表示.
if ($status == false) {
    sql_error($stmt); // 自作関数sql_error($stmt)
} else {
// 3.2 SQL成功時処理(リダイレクト)
    redirect("user.php"); // 自作関数redirect("$file_name")でuser.php にリダイレクト.
}
