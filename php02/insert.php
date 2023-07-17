<?php


//1. POSTデータ取得
$name = $_POST['name'];
$url = $_POST['url'];
$content = $_POST['content'];

//2. DB接続します
try {
  //ID:'root', Password: xamppは 空白 ''
  $pdo = new PDO('mysql:dbname=gs_kadai;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//３．データ登録SQL作成

// 1. SQL文を用意
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(id, 書籍名, 書籍URL, 書籍コメント, 登録日時)
VALUES(NULL, :書籍名, :書籍URL, :書籍コメント, sysdate())");

$stmt->bindValue(':書籍名', $name, PDO::PARAM_STR);
$stmt->bindValue(':書籍URL', $url,  PDO::PARAM_STR);
$stmt->bindValue(':書籍コメント', $content,  PDO::PARAM_STR);


//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status === false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit('ErrorMessage:'.$error[2]);
}else{
  //５．index.phpへリダイレクト
  header('Location: index.php');
}
?>
