<?php


session_start();
$company_id = 535;
include("../framework/trdb.php");

function format_date($d){
    $date = str_replace('/', '-', $d );
    $newDate = date("Y-m-d", strtotime($date));
    return $newDate;
}


if(isset($_SESSION['wine_card_type'])){
    $type = $_SESSION['wine_card_type'];
    if($type =='owner'){
        $c ="a.t_charge=0 and owner LIKE '%ivikorn%'";
    }
    if($type == 'internal'){
        $c= 'a.t_charge=0';
    }
    if($type == 'customer'){
        $c='a.t_charge<>0';
    }
}
else{
    $c= 'a.t_charge<>0';
}

$date_from = format_date($_POST['date_from']);
$date_to = format_date($_POST['date_to']);

$condition = "date_time between '$date_from' and '$date_to'";

$_SESSION['wine_date'] = $condition;

$result = $pdo2->query("SELECT date_time, card, owner,t_taste, t_charge, t_deposit, t_earn, t_refund,
            if(DATEDIFF( CURDATE(), date_time) > 365, (t_deposit + t_charge)- t_taste  , t_deposit ) as tr_earn
            FROM   (
            SELECT min(date_time) as date_time,card,owner,taste,charge,deposit,earn, sum(deposit) as t_deposit , 
            sum(taste) as t_taste, sum(charge) as t_charge, sum(earn)as t_earn,sum(refund)as t_refund FROM `wine_card` where company_id = '$company_id' group by card
            ) a where $condition and $c order by date_time desc limit 50")->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);