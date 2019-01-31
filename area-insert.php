<?php
//入力チェック(受信確認処理追加)
if(
  !isset($_POST["area"]) || $_POST["area"]=="" ||
  !isset($_POST["miniarea"]) || $_POST["miniarea"]=="" ||
  !isset($_POST['url']) || $_POST['url']==""||
  !isset($_POST['userid']) || $_POST['userid']==""
){
  header('location: index.php');
  exit;
}

//1. POSTデータ取得
$area = $_POST["area"];
$miniarea = $_POST["miniarea"];
$url = $_POST["url"];
$user = $_POST['userid'];

//2. DB接続します(エラー処理追加)
include('functions.php');
chk_ssid();
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare('INSERT INTO '. $area_table .'(id, area, miniarea, url, user)VALUES(NULL, :a1, :a2, :a3, :a4)');
$stmt->bindValue(':a1', $area, PDO::PARAM_STR);
$stmt->bindValue(':a2', $miniarea, PDO::PARAM_STR);
$stmt->bindValue(':a3', $url, PDO::PARAM_STR);
$stmt->bindValue(':a4', $user, PDO::PARAM_INT); //1.21編集
$status = $stmt->execute();

//４．データ登録処理後
if($status==false){
  errorMsg($stmt);
}else{
  //５．index.phpへリダイレクト
  header('Location: index.php');
  exit;
}
?>
