<!-- kadai10_PHP04 認証_insert.php (PHPのみ) --> 
<?php
// 0.まずこれをしてからコードを書き始める！
// index.phpでPOSTしたデータが受け取れているかを確認する.
// 確認ができたら直下の4行はコメントアウトすること！
// echo('<pre>');
// var_dump($_POST);
// echo('</pre>');
// exit;

// 0.1 最初にSESSIONを開始！！ココ大事！！
session_start();

// 0.5 POSTデータ取得 index.php で入力した(POSTされた）データを受け取る.
$rest_name = $_POST["rest_name"];
$genre     = $_POST["genre"];
$url       = $_POST["url"];
$memo      = $_POST["memo"];
$name      = $_POST["name"];

// 0.6 自作関数群の読み込み
include("funcs.php"); // まず、include関数でfuncs.phpを読み込む.

// 0.9. 自作関数sschk()でセッションチェック
sschk();// DB接続する前にセッションチェックを行う

// 1.0 自作関数db_conn()でDB接続
$pdo = db_conn();

// 2.0データ登録SQL作成
// 2.1 SQL作成(データを登録するSQL文を作成する＝準備)
$sql ="INSERT INTO rest_table(rest_name,genre,url,memo,name,indate)VALUES(:rest_name,:genre,:url,:memo,:name,sysdate());";
$stmt = $pdo->prepare($sql);
// bindValueを使ってDBに被害を及ぼすコマンドを無効化する.危ない文字をクリーンにする.
$stmt->bindValue(':rest_name', $rest_name, PDO::PARAM_STR); // varcharの場合 PDO::PARAM_STR
$stmt->bindValue(':genre',     $genre,     PDO::PARAM_STR); // varcharの場合 PDO::PARAM_STR
$stmt->bindValue(':url',       $url,       PDO::PARAM_STR); // varcharの場合 PDO::PARAM_STR
$stmt->bindValue(':memo',      $memo,      PDO::PARAM_STR); // Textの場合 PDO::PARAM_STR
$stmt->bindValue(':name',      $name,      PDO::PARAM_STR); // Textの場合 PDO::PARAM_STR
// 2.2 実行！$statusにはTrueかFalseが返る.
$status = $stmt->execute();

// 3.0 データ登録後処理
// 3.1. SQLエラー発生時処理
// $statusがFalseの場合、つまりSQL実行時にエラーがある場合、
// SQLエラー関数sql_error($stmt)でエラーオブジェクト取得して表示.
if($status==false){
  sql_error($stmt); // 自作関数sql_error($stmt)
}else{
// 3.2 SQL成功時処理(リダイレクト)
  redirect("index.php"); // 自作関数redirect("$file_name")でindex.php にリダイレクト.
}
?>