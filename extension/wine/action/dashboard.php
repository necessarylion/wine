<?php 


session_start();
$company_id = 535;
include("../framework/trdb.php");



//balance
if(isset($_POST['load'])){
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
    
    if(isset($_SESSION['wine_key'])){
        $key = $_SESSION['wine_key'];
        $k = "owner = '$key' or card= '$key'";
        $c='';
    }
    else{
        $k = '';
    }

    if(isset($_SESSION['wine_date'])){
        $date = 'and '.$_SESSION['wine_date'];
    }
    else{
        $date = '';
    }


    $result = $pdo2->query("SELECT sum(t_taste) t, sum(t_charge) c, sum(t_deposit) d, sum(t_earn) e, sum(t_refund) r ,
    if(DATEDIFF( CURDATE(), date_time) > 365, sum((t_deposit + t_charge + t_refund)- t_taste)  , sum(t_deposit) ) as tr_earn
    FROM   (
    SELECT min(date_time) as date_time,card,owner,taste,charge,deposit,earn, sum(deposit) as t_deposit ,
    sum(taste) as t_taste, sum(refund)as t_refund, sum(charge) as t_charge, sum(earn)as t_earn FROM `wine_card` where company_id = '$company_id' group by card
    ) a where $c $k $date")->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result[0]);
}

//balance













if(isset($_POST['detail']) && isset($_POST['type'])){
    unset($_SESSION['wine_key']);
    $limit = $_POST['limit'];
    $type = '';
    if(isset($_POST['type'])){
         $type = $_POST['type'];
    }

    if(isset($_SESSION['wine_date'])){
        $date = 'and '.$_SESSION['wine_date'];
    }
    else {
        $date = '';
    }
   
    if($type == 1){
      $type = $_SESSION['wine_card_type'];  
    }
    $result = '';
    $_SESSION['wine_card_type'] = $type;
    if($type == 'customer'){

        $result = $pdo2->query("SELECT date_time, card, owner,t_taste, t_charge, t_deposit, t_earn, t_refund,
        if(DATEDIFF( CURDATE(), date_time) > 365, (t_deposit + t_charge)- t_taste  , t_deposit ) as tr_earn
        FROM   (
        SELECT min(date_time) as date_time,card,owner,taste,charge,deposit,earn, sum(deposit) as t_deposit , 
        sum(taste) as t_taste, sum(charge) as t_charge, sum(earn)as t_earn,sum(refund)as t_refund FROM `wine_card` where company_id = '$company_id' group by card
        ) a where a.t_charge<>0 $date order by date_time desc limit $limit, 50")->fetchAll(PDO::FETCH_ASSOC);

    }
    if($type == 'internal'){

        $result = $pdo2->query("SELECT date_time, card, owner,t_taste, t_charge, t_deposit, t_earn, t_refund,
        if(DATEDIFF( CURDATE(), date_time) > 365, (t_deposit + t_charge)- t_taste  , t_deposit ) as tr_earn
        FROM   (
        SELECT min(date_time) as date_time,card,owner,taste,charge,deposit,earn, sum(deposit) as t_deposit , 
        sum(taste) as t_taste, sum(charge) as t_charge, sum(earn)as t_earn,sum(refund)as t_refund FROM `wine_card` where company_id = '$company_id' group by card
        ) a where a.t_charge=0 and owner NOT LIKE '%ivikorn%' $date order by date_time desc limit $limit, 50")->fetchAll(PDO::FETCH_ASSOC);


    }
    if($type == 'owner'){

        $result = $pdo2->query("SELECT date_time, card, owner,t_taste, t_charge, t_deposit, t_earn, t_refund,
        if(DATEDIFF( CURDATE(), date_time) > 365, (t_deposit + t_charge)- t_taste  , t_deposit ) as tr_earn
        FROM   (
        SELECT min(date_time) as date_time,card,owner,taste,charge,deposit,earn, sum(deposit) as t_deposit , 
        sum(taste) as t_taste, sum(charge) as t_charge, sum(earn)as t_earn,sum(refund)as t_refund FROM `wine_card` where company_id = '$company_id' group by card
        ) a where a.t_charge=0 and owner LIKE '%ivikorn%' $date order by date_time desc limit $limit, 50")->fetchAll(PDO::FETCH_ASSOC);

    }



    

    echo json_encode($result);

}


if(isset($_POST['search'])){
    $result = '';
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

    if($_POST['filter'] == 'owner'){
        $key = $_POST['search'];
        if($key == ''){
            
            $result = $pdo2->query("SELECT date_time, card, owner,t_taste, t_charge, t_deposit, t_earn, t_refund,
            if(DATEDIFF( CURDATE(), date_time) > 365, (t_deposit + t_charge)- t_taste  , t_deposit ) as tr_earn
            FROM   (
            SELECT min(date_time) as date_time,card,owner,taste,charge,deposit,earn, sum(deposit) as t_deposit , 
            sum(taste) as t_taste, sum(charge) as t_charge, sum(earn)as t_earn,sum(refund)as t_refund FROM `wine_card` where company_id = '$company_id' group by card
            ) a where $condition order by date_time desc limit 50")->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            $result = $pdo2->query("SELECT date_time, card, owner,t_taste, t_charge, t_deposit, t_earn, t_refund,
            if(DATEDIFF( CURDATE(), date_time) > 365, (t_deposit + t_charge)- t_taste  , t_deposit ) as tr_earn
            FROM   (
            SELECT min(date_time) as date_time,card,owner,taste,charge,deposit,earn, sum(deposit) as t_deposit , 
            sum(taste) as t_taste, sum(charge) as t_charge, sum(earn)as t_earn,sum(refund)as t_refund FROM `wine_card` where company_id = '$company_id' group by card
            ) a where owner = '$key'")->fetchAll(PDO::FETCH_ASSOC);
        }
        
        $_SESSION['wine_key'] = $key;
    }

    if($_POST['filter'] == 'card'){
        $key = $_POST['search'];

        if($key == ''){
            $result = $pdo2->query("SELECT date_time, card, owner,t_taste, t_charge, t_deposit, t_earn, t_refund,
            if(DATEDIFF( CURDATE(), date_time) > 365, (t_deposit + t_charge)- t_taste  , t_deposit ) as tr_earn
            FROM   (
            SELECT min(date_time) as date_time,card,owner,taste,charge,deposit,earn, sum(deposit) as t_deposit , 
            sum(taste) as t_taste, sum(charge) as t_charge, sum(earn)as t_earn,sum(refund)as t_refund FROM `wine_card` where company_id = '$company_id' group by card
            ) a where $condition order by date_time desc limit 50")->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
            $result = $pdo2->query("SELECT date_time, card, owner,t_taste, t_charge, t_deposit, t_earn, t_refund,
            if(DATEDIFF( CURDATE(), date_time) > 365, (t_deposit + t_charge)- t_taste  , t_deposit ) as tr_earn
            FROM   (
            SELECT min(date_time) as date_time,card,owner,taste,charge,deposit,earn, sum(deposit) as t_deposit , 
            sum(taste) as t_taste, sum(charge) as t_charge, sum(earn)as t_earn,sum(refund)as t_refund FROM `wine_card` where company_id = '$company_id' group by card
            ) a where card = '$key' ")->fetchAll(PDO::FETCH_ASSOC);
        }

        $_SESSION['wine_key'] = $key;

        
    }

    echo json_encode($result);

}