
<?php

//funcs.phpに書いてある関数を使えるように。
//インサートはインサートして終わりだが、セレクトは表示まで。
require_once('funcs.php');

//1.  DB接続します

  try {
    //ID:'root', Password: xamppは 空白 ''
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root', '');
} catch (PDOException $e) {
    exit('DBConnectError:' . $e->getMessage());
}



//２．データ取得SQL作成
//execute→実行的な意味、よって下では　実行した結果が$statusに入る。
// $stmt = $pdo->prepare("SELECT * FROM career_book ");
// $status = $stmt->execute();


$stmt = $pdo->prepare("SELECT * FROM career_book WHERE id = :id");
$stmt->bindValue(':id', 3, PDO::PARAM_INT);
$status = $stmt->execute();


//３．データ表示
$view = "";
if ($status == false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("ErrorQuery:" . $error[2]);
} else {
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
       //=の前に.があることで、　date,name,contentが上書きではなく、追記されていく。viewに全部格納されていく。
        //htmlspecialなんとかで、scriptタグをhtml表示させないようにする。 
        $view .= "<p>";
        $view .=  h($result['id']) .'　'. h($result['age']) .'　'. h($result['sex']) .'　'. h($result['name']) .'　'. h($result['job']);
        $view .= "</p>";

        $view .= "<p>";
        $view .=   h($result['career'])  . "<br><br>";
        $view .= "</p>";



    }
}
?>

<!-- //ここから下はhtml、こうやってPHPとhtml分ける。 -->

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>フリーアンケート表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">caereer_book</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start]  下の？イコールのところは、？PHP echo の省略系-->
<div>                                   
    <div class="container jumbotron"><?= $view ?></div>
</div>
<!-- Main[End] -->

</body>
</html>