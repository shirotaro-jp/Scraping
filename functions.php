<?php
//共通で使うものを別ファイルにしておきましょう。

//DB接続関数（PDO）
function db_conn(){
  $dbname = 'gs_f01_db13_10';
  try {
    return new PDO('mysql:dbname='.$dbname.';charset=utf8;host=localhost','root','');
  } catch (PDOException $e) {
    exit('DbConnectError:'.$e->getMessage());
  }
}

// テーブル名
$area_table = 'area_table';
$user_table = 'user_table';
$list_table = 'list_table';

//SQL処理エラー
function errorMsg($stmt){
  $error = $stmt->errorInfo();
  exit('ErrorQuery:'.$error[2]);
}

/**
* XSS
* @Param:  $str(string) 表示する文字列
* @Return: (string)     サニタイジングした文字列
*/
function h($str){
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

//SESSIONチェック＆リジェネレイト
function chk_ssid(){
    if(!isset($_SESSION['chk_ssid']) || $_SESSION['chk_ssid']!=session_id()){
        header('location: login.php');
        exit;  
    }else{
      session_regenerate_id(true);
      $_SESSION['chk_ssid'] = session_id();
    }
  }


//メニューバー
function menu(){
  $menu='';
  if($_SESSION['kanri_flg'] == 1){
    $menu = '<a class="navbar-brand" href="index.php">ブックマーク登録</a><a class="navbar-brand" href="select.php">ブックマーク一覧</a><a class="navbar-brand" href="user_index.php">ユーザー登録</a><a class="navbar-brand" href="user_select.php">ユーザー一覧</a><a class="navbar-brand" href="logout.php">ログアウト</a>';
  }else if($_SESSION['kanri_flg'] == 0){
    $menu = '<a class="navbar-brand" href="index.php">ブックマーク登録</a><a class="navbar-brand" href="select.php">ブックマーク一覧</a><a class="navbar-brand" href="logout.php">ログアウト</a>';
  }else{
    $menu = '<a class="navbar-brand" href="login.php">ログイン</a><a class="navbar-brand" href="select.php">ブックマーク一覧</a>';
  }
  return $menu;
}
?>
