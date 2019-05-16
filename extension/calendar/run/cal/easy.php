<?php 
include('../../include/dbquery.php');
$dbquery = new DbQuery();
$dbquery->htmlDecode($_POST);

$data = $dbquery->getall('easy_events');

$dbdata = [];

//Fetch into associative array
  while ( $row = $data->fetch_assoc())  {
	$dbdata[]=$row;
	
  }

//Print array in JSON format
 echo json_encode($dbdata)
?>