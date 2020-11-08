<?php
// 如果缺失内容就返回
if (empty($_POST['body'])) {
  header("HTTP/1.1 302 Found");
  header("Location: ./read.php");
  return;
}

//如果登录失败就返回
if (empty($_COOKIE["login_id"])) {
  header("HTTP/1.1 302 Found");
  header("Location: ./read.php");
  return;
}

// 创建数据库
require_once '../script/db_func.php'; 
$db_func = new db_func(); 
$dbh = $db_func ->acc_db();
// 保存投稿
$insert_sth = $dbh->prepare("INSERT INTO bbs_entries (name, body,textcolor) VALUES (:name, :body,:textcolor)");
$insert_sth->execute([
    ':name' => $_COOKIE['name'],
    ':body' => $_POST['body'],
    ':textcolor' => $_POST['textcolor']
]);
//cookie保存
require_once '../script/cookies';


header("HTTP/1.1 302 Found");
header("Location: ./read.php");
return;
?>
