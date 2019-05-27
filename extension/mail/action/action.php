
<?php
session_start();
mb_internal_encoding('UTF-8');
if(!isset($_POST['load'])){

$skip_verification = true;
include("../framework/trdb.php");
include "Imap.php";


$host = 'imap.gmail.com';
$user = 'aj.kumarsharno@gmail.com';
$pass = '2529google';
$port = 993;
$ssl = true;
$folder = 'INBOX';
$mailbox = new Imap($host, $user, $pass, $port, $ssl, $folder);

$row = $pdo2->query("SELECT * FROM email where user_id = '{$_COOKIE['user_id']}' ")->fetchAll(PDO::FETCH_ASSOC);


if(count($row) > 1){


	
	$r = $mailbox->getMessage(33);
	$mailbox->disconnect();
	


	$result = [];
	foreach($r as $key => $value){
	
		$data['m_id'] = $key;
		$data['user_id'] = $_COOKIE['user_id'];
		$data['subject'] = mb_decode_mimeheader($value) ;
	
		array_push($result, $data);
	
	}
	
	$pdo2->insert('email', $result);
	$result = $pdo2->query("SELECT * FROM email where user_id = '{$_COOKIE['user_id']}' ")->fetchAll(PDO::FETCH_ASSOC);
	$output['message'] = 1;
	$output['result'] = $result;
	echo "<pre>";
	print_r($r);
}
else
{
	$r = $mailbox->search('UNSEEN');
	$mailbox->disconnect();
	$result = [];
	foreach($r as $key => $value){
	
		$data['m_id'] = $key;
		$data['user_id'] = $_COOKIE['user_id'];
		$data['subject'] = mb_decode_mimeheader($value);
	
		array_push($result, $data);
	
	}
	
	$pdo2->insert('email', $result);
	$result = $pdo2->query("SELECT * FROM email where user_id = '{$_COOKIE['user_id']}' ")->fetchAll(PDO::FETCH_ASSOC);
	$output['message'] = 1;
	$output['result'] = $result;
	echo json_encode($output);

}
}
else{
	$output['message'] = 1;
	$output['result'] = "NO DATA RECEIVE";
	echo json_encode($output);
	die();
}




