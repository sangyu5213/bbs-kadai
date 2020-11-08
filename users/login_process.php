<?php
// 如果缺失账号或密码就返回初始界面
if (empty($_POST['login_id']) || empty($_POST['password'])) {
  header("HTTP/1.1 302 Found");
  header("Location: ./login.php");
  return;
}

// 创建数据库
require_once '../script/db_func.php';
$db_func = new db_func();
$dbh = $db_func->acc_db();

$select_sth = $dbh->prepare('SELECT login_id, password FROM users WHERE login_id = :login_id LIMIT 1');
$select_sth->execute([
    ':login_id' => $_POST['login_id'],
]);
$row = $select_sth->fetch();


if (!$row) {
    print('ログインIDがみつかりませんでした。<a href="./login.php">戻る</a>');
    //sleep(5);
    //header("HTTP/1.1 302 Found");
    //header("Location: ./login.php");
    return;
}

// 密码错误就提示错误
if (!password_verify($_POST['password'], $row['password'])) {
    print('パスワードが間違っています。<a href="./login.php">戻る</a>');
   // sleep(5);
    //header("HTTP/1.1 302 Found");
  //  header("Location: ./login.php");
    return;
}

setcookie('login_id', $row['login_id'], 0, '/');

header("HTTP/1.1 302 Found");
header("Location: ./login_finish.php");
return;
?>
