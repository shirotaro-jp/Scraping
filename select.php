<?php
//入力チェック(受信確認処理追加)
if(
    !isset($_GET["id"]) || $_GET["id"]==""
  ){
    header('location: index.php');
    exit;
  }
$areaid = $_GET["id"];

//1.  DB接続します ログイン確認
session_start();
include('functions.php');
chk_ssid();
$loginname = $_SESSION['name'];
$pdo = db_conn();
$userid = $_SESSION['userid'];


//２．データ登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM '.$list_table.' WHERE area=:areaid ');
$stmt->bindValue(':areaid', $areaid, PDO::PARAM_STR);
$status = $stmt->execute();

//３．データ表示
$view='';
if($status==false){
  errorMsg($stmt);
}else{
  //Selectデータの数だけ自動でループしてくれる
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
      if($result['link']==0){
        $num = '';
      }else if($result['link']==1){
        $num = '5店舗以上10店舗未満';
      }else if($result['link']==2){
        $num = '10店舗以上';
      }
        $stmt_a = $pdo->prepare('SELECT * FROM '.$area_table.' WHERE id=:areaid ');
        $stmt_a->bindValue(':areaid', $areaid, PDO::PARAM_STR);
        $status_a = $stmt_a->execute();
        $area = $stmt_a->fetch();
    $view .= '<tr>';
    $view .= '<td>'.$result['shop'].'</td>';
    $view .= '<td>'.$area['miniarea'].'</td>';
    $view .= '<td>'.$result['tel'].'</td>';
    $view .= '<td>'.$result['adress'].'</td>';
    $view .= '<td>'.$num.'</td>'; 
    $view .= '<td>'.$result['date'].'</td>';
    $view .= '</tr>';     
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>営業リスト作成</title>
</head>
<body>

<header>

</header>
<div>
    <table  border="1" cellspacing="0">
    <tr>
        <th>店名</th>
        <th>エリア名</th>
        <th>電話番号</th>
        <th>住所</th>
        <th>多店舗</th>
        <th>情報取得日</th>
    </tr>
    <?=$view?>
    </table>
</div>


</body>
</html>
