<!-- kadai10_PHP04 認証_funcs.php(PHP) -->
<!-- よく使う処理や複数のpfpファイルで使う処理を関数化 -->
<?php
// XSS対応.サニタイジング（ echoする場所で使用！それ以外はNG ）
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

// DB接続関数：db_conn()　PDO(PHP Data Object) を使ってDBに接続する
function db_conn(){
  try {
    $db_name = "ca_moms_db"; // データベース名
    $db_id   = "root";       // アカウント名
    $db_pw   = "";           // パスワード：XAMPPはパスワード無し or MAMPはパスワード”root”に修正してください。
    $db_host = "localhost";  // DBホスト
    return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
  } catch (PDOException $e) {
    exit('DB_CONNECT_ERROR:'.$e->getMessage());// exitはバチっとここで止めてしまう
  }
}

// SQLエラー関数：sql_error($stmt)
// $statusがfalseの場合、つまりSQL実行時にエラーがある場合
function sql_error($stmt){ 
  $error = $stmt->errorInfo(); // エラーオブジェクト取得する。
  exit("SQL_ERROR:".$error[2]); // SQL実行時のエラーであることが分かるように"SQL_ERROR:"という文言をつけてエラーメッセージを表示する。
}

// リダイレクト関数: redirect($file_name)
// $statusがTrueの場合、つまりSQL実行が成功した場合
// LocationのLは大文字、コロンの後は半角スペース入れる
function redirect($file_name){
  header("Location: ".$file_name);
  exit();
}

// SessionCheck
// $_SESSION["chk_ssid"がセットされていなかったら or ログインしたときのセッションID $_SESSION["chk_ssid"]がselect.phpのセッションID session_id()と合致していなかったら
// ログインエラーを出して強制終了させる
function sschk(){
  if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){
    exit("LOGIN_ERROR");
  }else{
    session_regenerate_id(true); // セキュリティ強化！！ 関数session_regenerate_id(true)でセッションキーを作り変える
    $_SESSION["chk_ssid"] = session_id(); // $_SESSION["chk_ssid"]に新しく作り変えたセッションキーを入れる
  }
}
?>