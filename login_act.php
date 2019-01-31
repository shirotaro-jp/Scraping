<?php
//最初にSESSIONを開始！！
session_start();

// 入力チェック
if(
    !isset($_POST["name"]) || $_POST["name"]=="" || 
    !isset($_POST["pass"]) || $_POST["pass"]==""
  ){
    header('location: login.php');
    exit;
  }

//0.外部ファイル読み込み
include('functions.php');

//1.  DB接続します
$pdo = db_conn();
$name = $_POST['name'];
$pass = $_POST['pass'];

//2. データ登録SQL作成
// 入力したユーザー名とパスワードで一致するデータを探す
$stmt = $pdo->prepare('SELECT * FROM '.$user_table.' WHERE name=:name AND pass=:pass');
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
$res = $stmt->execute();

//3. SQL実行時にエラーがある場合
if($res==false){
  queryError($stmt);
}

//4. 抽出データ数を取得
//$count = $stmt->fetchColumn(); //SELECT COUNT(*)で使用可能()
$val = $stmt->fetch(); //1レコードだけ取得する方法

//5. 該当レコードがあればSESSIONに値を代入
if( $val['id'] != "" ){
  $_SESSION['chk_ssid']  = session_id();
  $_SESSION['name']      = $val['name'];
  $_SESSION['userid']      = $val['id'];
  header('location: index.php');
}else{
  // ログイン画面へ戻る
  header('location: login.php');
}

exit();
?>

