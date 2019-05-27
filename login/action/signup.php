<?php
include '../framework/trdb.php';

$username = $_POST['username'];
$password = $_POST['password'];
$confirm = $_POST['confirm'];



if($password != $confirm){
	echo "Password Do Not Match";
}
elseif(strlen($username) < 4){
	echo "Username Must be at least 4";
}
elseif(strlen($password) < 4){
	echo "Password Must be at least 4";
}
else{

	$r = $pdo2->insert("user", [
		[ 'username'=> $username,
		  'password'=> md5($password)
		]
	]);


	echo "success";
	setcookie('admin', '12345878', time() + (86400 * 30), "/");
	setcookie('username', $username, time() + (86400 * 30), "/");
	setcookie('user_id', $r, time() + (86400 * 30), "/");

}