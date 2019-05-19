<?php 
include('../../include/dbquery.php');
$dbquery = new DbQuery();
$dbquery->htmlDecode($_POST);
$posts = $dbquery->posts;

if(isset($posts['load'])){
	$dbquery->findCondition('order by id desc LIMIT 20','note');
	while($row = $dbquery->result->fetch_assoc()){

	$data[] = array(
			'id'   => $row["id"],
			'title'=> htmlspecialchars_decode($row['title']),
			'body'=> htmlspecialchars_decode($row['body']),
			'date_time'=> $row['date_time']
		);
	}

	echo json_encode($data);
}
//die();
if(isset($posts['del_id'])){
	$id = $posts['del_id'];
	$dbquery->destroy($id,'note');
    echo $dbquery->result;
}


if(isset($posts['note_id']) && $posts['note_id'] == ''){
	
	$data = [
		'title' => htmlentities($posts['title']),
		'body' => htmlentities($posts['body']),
		'date_time' => date("Y-m-d")
		];
	$tableName = 'note';
	$dbquery->save($data,$tableName);

    
	$a = $dbquery->last_id;
	$daaa = [];

	$dbquery->findCondition("Where id = '$a'",$tableName);
	while($row = $dbquery->result->fetch_assoc()){

	$daaa['result'] = array(
			'id'   => $row["id"],
			'title'=> htmlspecialchars_decode($row['title']),
			'body'=> htmlspecialchars_decode($row['body']),
			'date_time'=> $row['date_time']
		);
	}
	$daaa['type'] = 'new';

	echo json_encode($daaa);

}


if(isset($posts['note_id']) && $posts['note_id'] != ''){
	$id = $posts['note_id'];
	$daaa = [];
	$data = [
		'title' => htmlentities($posts['title']),
		'body' => htmlentities($posts['body']),
		'date_time' => date("Y-m-d")
		];
	$tableName = 'note';
	$dbquery->update($id,$data,$tableName);
	$daaa['type'] = 'edit';

	echo json_encode($daaa);


}

if(isset($posts['from']) && $posts['to']){
	$from = $posts['from'];
	$to = $posts['to'];
	$condition = "Where date_time between '$from' and '$to'";

	$dbquery->findCondition($condition,'note');
	while($row = $dbquery->result->fetch_assoc()){

	$data[] = array(
			'id'   => $row["id"],
			'title'=> htmlspecialchars_decode($row['title']),
			'body'=> htmlspecialchars_decode($row['body']),
			'date_time'=> $row['date_time']
		);
	}

	echo json_encode($data);
}



if(isset($posts['key'])){
	$key = $posts['key'];
	$condition = "Where title Like '%$key%' ";

	$dbquery->findCondition($condition,'note');
	while($row = $dbquery->result->fetch_assoc()){

	$data[] = array(
			'id'   => $row["id"],
			'title'=> htmlspecialchars_decode($row['title']),
			'body'=> htmlspecialchars_decode($row['body']),
			'date_time'=> $row['date_time']
		);
	}

	echo json_encode($data);
}


if(isset($posts['limit'])){
	$limit = $posts['limit'];
	$condition = "Limit $limit, 20";

	$dbquery->findCondition($condition,'note');
	while($row = $dbquery->result->fetch_assoc()){

	$data[] = array(
			'id'   => $row["id"],
			'title'=> htmlspecialchars_decode($row['title']),
			'body'=> htmlspecialchars_decode($row['body']),
			'date_time'=> $row['date_time']
		);
	}

	echo json_encode($data);
}

if(isset($posts['get'])){
	$a = $posts['get'];
	$dbquery->findCondition("Where id = '$a'",'note');
	while($row = $dbquery->result->fetch_assoc()){

	$daaa[] = array(
			'id'   => $row["id"],
			'title'=> htmlspecialchars_decode($row['title']),
			'body'=> htmlspecialchars_decode($row['body']),
			'date_time'=> $row['date_time']
		);
	}

	echo json_encode($daaa);

}
?>