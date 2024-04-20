<!-- kadai10_PHP04 認証_index.php (PHP・HTML) --> 
<?php
//0. SESSION開始！！
session_start();

//1.0. 自作した関数群の読み込み
include("funcs.php"); //include関数でfuncs.phpを読み込む

//1.5. LOGINチェック 
sschk();
?>

<!-- ここからHTML -->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CA Moms 管理者</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="img/png" href="img/favicon.png">
</head>

<!-- Header部分 Logoとナビゲーションメニュー-->
<body>
<header>
  <div class="container">
    <div><img src="img/cheers.png" alt=""></div>
    <div><h1>CA Moms ユーザー登録</h1></div>
    <?=$_SESSION["name"]?>さん こんにちは！　
    <?php include("menu.php"); ?>
  </div>
</header>

<!-- Main[Start] -->
<form method="POST" action="user_insert.php">
  <div id="user_reg">
    <fieldset>
      <legend>ユーザー登録</legend>
        <div class="info_row">
          <div class="info_label">
            <label>名前：</label>
          </div>
          <div class="info_input">
            <input type="text" name="name"><br>
          </div>
        </div>
        <div class="info_row">
          <div class="info_label">
            <label>Login ID：</label>
          </div>
          <div class="info_input">
            <input type="text" name="lid"><br>
          </div>
        </div>
        <div class="info_row">
          <div class="info_label">
            <label>Login パスワード:</label>
          </div>
          <div class="info_input">
            <input type="text" name="lpw"><br>
          </div>
        </div>
        <div class="info_row">
          <div class="info_label">
            <label>管理FLG：</label>
          </div>
          <div class="info_input">
            <input type="radio" name="kanri_flg" value="0"> 一般ユーザー
            <input type="radio" name="kanri_flg" value="1">管理者<br>
            </div>
        </div>
     <!-- <label>退会FLG：<input type="text" name="life_flg"></label><br> -->
     <!-- <input type="submit" value="送信"> -->

     <button type="submit" class="regist">送信</button>
    </fieldset>
  </div>
</form>
<!-- Main[End] -->
</body>
</html>