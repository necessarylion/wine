<?php 
include('../../include/dbquery.php');
$dbquery = new DbQuery();
$dbquery->htmlDecode($_POST);
$posts = $dbquery->posts;
$user_id = $_COOKIE['user_id'];


if(isset($posts['load'])){
	$dbquery->findCondition("where user_id ='$user_id'",'problems');
	while($row = $dbquery->result->fetch_assoc()){

	$data[] = array(
			'id'   => $row["id"],
			'title'=> $row['title']
		);
	}

	echo json_encode($data);
}

if(isset($posts['del'])){
	$id = $posts['del'];
	$dbquery->destroy($id,'problems');
    echo $dbquery->result;
}
if(isset($posts['edit'])){
	$id = $posts['edit'];
	$data = [
		'title' => $posts['title']
		];
	$tableName = 'problems';
	$dbquery->update($id,$data,$tableName);
	echo $dbquery->result;   
}

if(isset($posts['new'])){
	$title = $posts['title'];
	$data = [
		'title' => $title,
		'user_id'=> $user_id
		];
	$tableName = 'problems';
	$dbquery->save($data,$tableName);
    $output['message'] = $dbquery->result;
	$output['id'] = $dbquery->last_id;
	
	echo json_encode($output);
}
?>