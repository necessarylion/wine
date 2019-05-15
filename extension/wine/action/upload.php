<?php

$json = $_POST['json'];


function jsonToCsv ($json) {
    
    // See if the string contains something
    if (empty($json)) { 
      die("The JSON string is empty!");
    }
    
    // If passed a string, turn it into an array
    if (is_array($json) === false) {
      $json = json_decode($json, true);
    }
    
    $strTempFile = 'temp/csvOutput' . date("U") . ".csv";
    $f = fopen($strTempFile,"w+");
    
    $firstLineKeys = false;
    foreach ($json as $line) {
      if (empty($firstLineKeys)) {
        $firstLineKeys = array_keys($line);
        fputcsv($f, $firstLineKeys);
        $firstLineKeys = array_flip($firstLineKeys);
      }
      // Using array_merge is important to maintain the order of keys acording to the first element
      fputcsv($f, array_merge($firstLineKeys, $line));
    }
    fclose($f);
    
    return $strTempFile;
    
  }


$data = jsonToCsv($json);





include "../../../config.php";
$company_id = 535;

$db = new mysqli($host, $db_user,$db_pass, $db_name);

$upload_time = DATE('Y-m-d H:i:s');
$a = "SET GLOBAL local_infile = true;";

$db->query($a);

$query = 
<<<eof
        LOAD DATA LOCAL INFILE '$data'
        INTO TABLE wine_card
        FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
        LINES TERMINATED BY '\n'
        IGNORE 1 ROWS
        (temp_date,action,card,owner,taste,charge,deposit,refund,earn)
        SET date_time = STR_TO_DATE(temp_date,'%m/%d/%Y %H:%i:%s'),
        temp_date = '', upload_time = '$upload_time', company_id = '535'
eof;

if($db->query($query)){
    $del = "DELETE FROM wine_card where date_time ='0000-00-00 00:00:00' and upload_time = '$upload_time' ";
    $db->query($del);

    $upd = "UPDATE  wine_card a
    join wine_card b on
    a.date_time = b.date_time and
    a.action = b.action and
    a.card = b.card and
    a.owner = b.owner and
    a.taste = b.taste and
    a.charge = b.charge and
    a.deposit = b.deposit and
    a.refund = b.refund and
    a.earn = b.earn and
    a.company_id = b.company_id
    set
    a.temp_date = 'tbd'
    where
    a.upload_time > b.upload_time";

    $db->query($upd);
    $dup_del = "DELETE FROM `wine_card` WHERE temp_date='tbd' and company_id = '$company_id'";
    
    $db->query($dup_del);
    $output['message'] = 'success';


}
else{
    $output['message'] =  $db->error;
}

unlink($data);

echo json_encode($output);
?>


