<?php
session_start();
$company_id = 535;
$data = [];
$_POST['json'] = json_encode($data);

$skip_verification = true;
include("../framework/trdb.php");
$json = [];




if(isset($_POST['card'])){

    $search = $_POST['card'];

    $sql = "SELECT *
    FROM wine_card where card= '$search' and company_id = '$company_id'";
    $result = $pdo2->query($sql)->fetchAll(PDO::FETCH_ASSOC);;

   


   echo json_encode($result);

}


