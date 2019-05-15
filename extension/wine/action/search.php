<?php
session_start();
$company_id = 535;
$data = [];
$_POST['json'] = json_encode($data);

$skip_verification = true;
include("../framework/trdb.php");
$json = [];

$condition = '';
$z = $_SESSION['wine_card_type'];
if($z == 'customer'){
    $condition = 'a.t_charge<>0';
}
if($z == 'internal'){
    $condition = 'a.t_charge=0';
}
if($z == 'owner'){
    $condition = "a.t_charge=0 and owner LIKE '%ivikorn%'";
}



if(isset($_GET['search'])){

    $search = $_GET['search'];

    $sql = "SELECT card, owner
    FROM (
    SELECT  card, owner ,sum(charge) as t_charge FROM `wine_card` where company_id = '$company_id'  group by card
    ) a where owner LIKE '%$search%' and $condition limit 50";

    $result = $pdo2->query($sql);

    $rows = $result->fetchAll();

    foreach($rows as $row){
        $json[] = ['id'=>$row['owner'], 'text'=>$row['owner']];
    }


}

if(isset($_GET['card'])){

    $search = $_GET['card'];

    $sql = "SELECT card, owner
    FROM (
    SELECT  card, owner ,sum(charge) as t_charge FROM `wine_card` where company_id = '$company_id' group by card
    ) a where card LIKE '%$search%' and $condition limit 50";
    $result = $pdo2->query($sql);

    $rows = $result->fetchAll();


    foreach($rows as $row){
        $json[] = ['id'=>$row['card'], 'text'=>$row['card']];
    }


}


echo json_encode($json);
