<!-- kadai10_PHP04 認証_login_act.php(PHP) --> 
<?php
// 0.0.まずこれをしてからコードを書き始める！
// detail.phpでPOSTしたデータが受け取れているかを確認する
// 確認ができたら直下の4行はコメントアウトすること！
// echo('<pre>');
// var_dump($_POST);
// echo('</pre>');
// exit;

// 0.1 最初にSESSIONを開始！！ココ大事！！
session_start();

// 0.5 POSTデータ取得 login.php で入力した(POSTされた）データを受け取る.
$lid = $_POST["lid"]; // lid(login.phpで入力された/POSTされたidを $lid で受け取る)
$lpw = $_POST["lpw"]; // lpw(login.phpで入力された/POSTされたpwdを $lpw で受け取る)

// 0.6 自作関数群の読み込み
include("funcs.php"); // まず、include関数でfuncs.phpを読み込む.

// 1.0 自作関数db_conn()でDB接続
$pdo = db_conn();

// 2. lid(ログインID)確認SQL作成
// 2.1 SQL作成(lid(ログインID)確認するSQL文を作成する＝準備)
// * Passwordがhash化→条件はlidのみ！！まず、この人（このid）いますか？ idがテーブルにある AND life_flg=0のひと（在籍している人）
$stmt = $pdo->prepare("SELECT * FROM user_table WHERE lid=:lid AND life_flg=0"); 
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
// 2.2 実行！$statusにはTrueかFalseが返る.
$status = $stmt->execute();

// 3.0 lid確認後処理
// SQL実行時にエラーがある場合、STOP
// $statusがFalseの場合、つまりSQL実行時にエラーがある場合、
// SQLエラー関数sql_error($stmt)でエラーオブジェクト取得して表示.
if($status==false){
  sql_error($stmt); // 関数化したSQLエラー関数：sql_error($stmt)
}

// 4.0 SQL実行時にエラーがない場合、つまりlidが存在していてかつその人のlife_flg=0の場合、抽出データ数を取得
$val = $stmt->fetch(); // 関数fetch()で1レコードだけ取得する.１レコードを$valに入れる
// $count = $stmt->fetchColumn(); // SELECT COUNT(*)で使用可能()

// 5.0 ログイン
// 5.1 Pwdの整合性確認(入力したPasswordと暗号化されたPasswordを比較！)
// password_verify()関数[戻り値：true,false]を使って
// $lpw（入力したパスワード と $val["lpw"]（select文でDBのgs_user_tableからとってきたレコードのハッシュ化されたパスワード）が一致しているかどうかを確かめる
// 一致していたら $pw にtrueが返ってくる。一致していなかったら $pw にfalseが返ってくる
$pw = password_verify($lpw, $val["lpw"]); // $lpw = password_hash($lpw, PASSWORD_DEFAULT);   // パスワードハッシュ化
if($pw){ // if($pw) は$pwがtrueだったらという意味
// 5.2 Login成功時処理
// SESSIONに値を代入
  $_SESSION["chk_ssid"]  = session_id(); // 現在のページのセッションidを $_SESSION["chk_ssid"] に渡す
  $_SESSION["kanri_flg"] = $val['kanri_flg']; // 今とってきた人のデータ（レコード）から kanri_flg を $_SESSION["kanri_flg"] に渡す
  $_SESSION["name"]      = $val['name']; // 今とってきた人のデータ（レコード）から name を $_SESSION["name"] に渡す ログイン後の●●さんこんにちは！とかに使える。
// index.phpへリダイレクト
  redirect("index.php");// 自作関数redirect("$file_name")でindex.php にリダイレクト.
}else{
// 5.3 Login失敗時処理(リダイレクト)
  redirect("login.php"); // 自作関数redirect("$file_name")でlogin.php にリダイレクト.
}
exit();
