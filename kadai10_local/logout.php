<!-- kadai10_PHP04 認証_logout.php (PHP) --> 
<?php
// 0.1 最初にSESSIONを開始！！ココ大事！！
session_start();

// 0.6 自作関数群の読み込み
include("funcs.php"); // まず、include関数でfuncs.phpを読み込む.

// 1.0 SESSIONを初期化（空っぽにする）
$_SESSION = array();

// 2.0 Cookieに保存してある"SessionIDの保存期間を過去にして破棄（無効化）する
if (isset($_COOKIE[session_name()])) { // session_name()は、セッションID名を返す関数
    setcookie(session_name(), '', time()-42000, '/');
}

// 3.0 サーバ側での、セッションIDの破棄
session_destroy();

// 4.0 処理後、login.phpへリダイレクトしておしまい
redirect("login.html"); // 自作関数redirect("$file_name")でlogin.php にリダイレクト.
exit();
?>
