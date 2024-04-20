<!-- kadai10_PHP04 認証_detail.php (PHP・HTML) --> 
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

// 0.5. URLから$_GETでidを受け取る 
$id = $_GET["id"];

// 0.6. 自作関数群の読み込み
include("funcs.php"); // まず、include関数でfuncs.phpを読み込む.

// 0.9. 自作関数sschk()でセッションチェック
sschk();// DB接続する前にセッションチェックを行う

// 1.0 自作関数db_conn()でDB接続
$pdo = db_conn();

// 2.0 データ取得
// 2.1 SQL作成(更新対象データを取得するSQL文を作成する＝準備） 
// URLから取得したidのデータだけを持ってくる
$sql = "SELECT * FROM rest_table WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id',$id,PDO::PARAM_INT); // Integer（数値の場合 PDO::PARAM_INT)
// 2.2 実行！$statusにはTrueかFalseが返る.
$status = $stmt->execute();

// 3.0 データ取得後処理
// 3.1. SQLエラー発生時処理（エラーを表示）
// $statusがFalseの場合、つまりSQL実行時にエラーがある場合、
// SQLエラー関数sql_error($stmt)でエラーオブジェクト取得して表示.
$values = "";
if($status==false) {
  sql_error($stmt); // 関数化したSQLエラー関数：sql_error($stmt)
}
// 3.2 SQL成功時処理
// $statusがtrueの場合、
// 関数fetch()で1行だけデータ取得する.取得したidのデータを$valueに入れる.
$value =  $stmt->fetch(); // PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
//  $json = json_encode($values,JSON_UNESCAPED_UNICODE);

// 4.0 セレクトボックス(レストランジャンルと名前）にDBから取得した値を表示するための準備
// レストランのジャンルの選択肢を配列にセットする
$registered_genre_data = array('イタリアン', 'フレンチ', '和食', '中華', '焼き鳥', '居酒屋', 'ラーメン', 'その他');
// 名前の選択肢を配列にセットする
$registered_name_data = array('Mie', 'Mika', 'Rita');
?>

<!-- ここからHTML -->
<!-- index.phpのHTMLをまるっと貼り付ける！ -->
<!-- 理由：入力項目は「登録/更新」はほぼ同じになるからです.登録画面で入力したものを更新するから画面はほぼ同じになる. -->
<!-- ※form要素に input type="hidden" name="id" を追加（idを非表示項目として追加）する -->
<!-- ※form要素のakutionのところ action="update.php"に変更する.更新処理をするupdate.phpに飛ばす. -->
<!-- ※input要素 value="ここに変数埋め込み" -->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CA Moms データ修正</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="img/png" href="img/favicon.png">
</head>

<body>
<header>
  <div class="container">
    <div><img src="img/cheers.png" alt=""></div>
    <div><h1>CA Moms</h1></div>
    <div><img src="img/cheers.png" alt=""></div>
  </div>
</header>

<section class="input_section">
  <h2>★My Recommended Restaurant情報の修正★</h2>
  <form action="update.php" method="POST">
    <div class="info_row">
      <div class="info_label">
        <label for="rest_name">店名：</label>
      </div>
      <div class="info_input">
        <input type="text" name="rest_name" value="<?=$value["rest_name"]?>" class="text_space"><br>
      </div>
    </div>

    <div class="info_row">
      <div class="info_label">
        <label for="genre">ジャンル：</label>
      </div>
      <div class="info_input">
        <select name="genre" id="genre">
          <!-- DBから取得したレコードのレストランジャンルの値をジャンルのセレクトボックスに表示させる（optionタグにselected属性を入れる） -->
          <!-- セレクトボックスオプションとして設定したレストランジャンルを配列に入れておいた $registered_genre_data-->
          <!-- 関数foreach()で配列 $registered_genre_data の一つ一つを$option_genreに入れる-->
          <?php foreach ($registered_genre_data as $option_genre) { ?>
          <!-- DBから取得したレコードのレストランジャンル$value["genre"] が $option_genre と一致したら selectedをoptionタグに入れる-->
           <option value="<?php echo $option_genre; ?>" <?php if ($option_genre == $value["genre"]) echo "selected"; ?>>
              <?php echo $option_genre; ?>
           </option>
          <?php } ?>
        </select><br>
        <!--デバック：DBから取得したレコードのレストランジャンル$value["genre"]を表示する.これがセレクトボックスのselectedで表示されていればOK-->
        <!-- OKであることが確認出来たら直下の1行はコメントアウトすること -->
        <!-- <?=$value["genre"];?> -->
      </div>
    </div>
    <div class="info_row">
      <div class="info_label">
        <label for="url">URL：</label>
      </div>
      <div class="info_input">
        <input type="text" name = "url" value="<?=$value["url"]?>" class="text_space"><br>
      </div>
    </div>
    <div class="info_row">
      <div class="info_label">
        <label for="memo">おすすめポイント：</label>
      </div>
      <div class="info_input">
        <textArea name="memo" rows="4" cols="53"><?=$value["memo"]?></textArea><br>
      </div>
    </div>
    <div class="info_row">
      <div class="info_label">
        <label for="name">推薦者：</label>
      </div>
      <div class="info_input">
        <select name="name" class="select_area">
          <!-- DBから取得したレコードの名前の値を推薦者のセレクトボックスに表示させる（optionタグにselected属性を入れる） -->
          <!-- セレクトボックスオプションとして設定した名前を配列に入れておいた $registered_name_data-->
          <!-- 関数foreach()で配列 $registered_name_data の一つ一つを$option_nameに入れる-->
          <?php foreach ($registered_name_data as $option_name) { ?>
          <!-- DBから取得したレコードの名前 $value["name"] が $option_name と一致したら selectedをoptionタグに入れる-->
            <option value="<?php echo $option_name; ?>" <?php if ($option_name == $value["name"]) echo "selected"; ?>>
              <?php echo $option_name; ?>
            </option>
          <?php } ?>
        </select><br>
        <!--デバック：DBから取得したレコードの名前$value["name"]を表示する.これが推薦者のセレクトボックスのselectedで表示されていればOK-->
        <!-- OKであることが確認出来たら直下の1行はコメントアウトすること -->
        <!-- <?=$value["name"];?> -->
      </div>
    </div>
    <!-- どのidのデータを更新するのかを指定するため、idを飛ばす-->
    <!-- idをユーザーに表示する必要はないのでtype="hidden"にしてみえないようにしておくが、他のデータをDBに飛ばすときに一緒に飛ばす-->
    <input type="hidden" name="id" value="<?=$value["id"]?>">
    <button type="submit" class="update">修正</button>
  </form>
</section>
</body>
</html>


