<!-- kadai10_PHP04 認証_delete.php (PHPのみ) -->
<?php
// 0.まずこれをしてからコードを書き始める！
// index.phpでクリックしたレコードのidが受け取れているかを確認する.
// 確認ができたら直下の4行はコメントアウトすること！
// echo('<pre>');
// var_dump($_GET);
// echo('</pre>');
// exit;

// 0.1 最初にSESSIONを開始！！ココ大事！！
session_start();

// 0.5 POSTデータ取得 削除したいデータのidを受け取る
$id = $_GET["id"];

// 0.6 自作関数群の読み込み
include("funcs.php"); // まず、include関数でfuncs.phpを読み込む.

// 0.9. 自作関数sschk()でセッションチェック
sschk();// DB接続する前にセッションチェックを行う

// 1.0 自作関数db_conn()でDB接続
$pdo = db_conn();

// 2.0 データ削除
// 2.1 SQL作成(データを削除するSQL文を作成する＝準備)
// テーブルrest_table から指定されたidのレコードを削除する
$stmt = $pdo->prepare("DELETE FROM rest_table WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT); // Integer（数値の場合 PDO::PARAM_INT)
// 2.2 実行！$statusにはTrueかFalseが返る.
$status = $stmt->execute(); // 実行

// 3.0 データ削除後処理
// 3.1. SQLエラー発生時処理
// $statusがFalseの場合、つまりSQL実行時にエラーがある場合、
// SQLエラー関数sql_error($stmt)でエラーオブジェクト取得して表示.
if($status==false){
  sql_error($stmt); // 関数化したSQLエラー関数：sql_error($stmt)
}else{
// 3.2 SQL成功時処理(リダイレクト)
  redirect("index.php");  // 自作関数redirect("$file_name")でindex.php にリダイレクト.
}
?>
