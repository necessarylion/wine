<?php
include '../framework/trdb.php';

$username = $_POST['username'];
$password = md5($_POST['password']);



$r = $pdo2->query("SELECT * from user where username='$username'  and password = '$password'")->fetchAll(PDO::FETCH_ASSOC);


if(count($r) < 1){
	echo "Username and Password Do Not Match";
}
else{

	$user_id = $r[0]['id'];
	echo "success";
	setcookie('admin', '12345878', time() + (86400 * 30), "/");
	setcookie('username', $username, time() + (86400 * 30), "/");
	setcookie('user_id', $user_id, time() + (86400 * 30), "/");
}