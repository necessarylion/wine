<?php

include "../../config.php";


class trdb{
	
	
	public $_detail = [];
	protected $debug_mode 	= false;
	protected $test_mode 	= false;
	protected $script_mode 	= false;


	public function __construct($_db){
		
		if( isset($_db->_detail) ){
			$info = [];
			$info["database_type"] 	= $_db->_detail["database_type"];
			$info["database_name"] 	= $_db->_detail["database_name"];
			$info["server"] 		= $_db->_detail["server"];
			$info["username"] 		= $_db->_detail["username"];
			$info["password"] 		= $_db->_detail["password"];
		}else{
			$info = [];
			$info["database_type"] 	= $_db["database_type"];
			$info["database_name"] 	= $_db["database_name"];
			$info["server"] 		= $_db["server"];
			$info["username"] 		= $_db["username"];
			$info["password"] 		= $_db["password"];
			$this->_detail			= $info;
		}
		
		$input = [	"database_type"	=>$info["database_type"],
					"database_name"	=>$info["database_name"],
					"server"		=>$info["server"],
					"username"		=>$info["username"],
					"password"		=>$info["password"],
				 ];
		$this->pdo  = new PDO($input["database_type"].':host='.$input["server"].';dbname='.$input["database_name"].';charset=utf8', $input["username"], $input["password"]);	
	}
	
	

	public function debug(){
		$this->debug_mode = true;
		return $this;
	}
	
	

	public function test(){
		$this->test_mode = true;
		return $this;
	}
	
	

	public function script(){
		$this->script_mode = true;
		return $this;
	}
	
	
	public function query($input){
		return $this->pdo->query($input);
	}
	
	
	public function prepare($input){
		return $this->pdo->prepare($input);
	}

	
	public function execute($input){
		return $this->pdo->execute($input);
	}

	
	
	
	public function update($table, $detail = array(), $where){
		
		$sql = " update {$table}
				 set
				";
		$i   = 0;
		$exe = array();
		foreach( $detail as $key=>$item ){
			$sql .= ($i==0)?"":",";
			$sql .= " {$key} = :{$key} ";
			$exe  = array_merge($exe,array(":{$key}"=>$item));
			$i++;
		}
		$sql.= " where {$where} ";
		
		$sth = $this->pdo->prepare($sql);
		$sth->execute($exe);
		
		return $this->pdo->query("select * from {$table} where {$where} ")->fetch(PDO::FETCH_ASSOC);
	}

	
	
	public function insert($table, $detail = array()){
		$sql = " INSERT INTO `{$table}`
				(
				";
				
		$exe = array();
		$i	 = 0;
		foreach( $detail[0] as $key=>$item ){
			$sql .= ($i == 0)?"":" , ";
			$sql .= " `{$key}` ";
			$i++;
		}	
		$sql .= " ) VALUES ";
		
		
		$i	  = 0;	
		foreach( $detail as $item ){

			$temp = array();
			
			$sql .= ($i==0)?"":" , ";
			$sql .= " ( ";
			
			$j = 0;
			foreach( $item as $key=>$it ){
				$sql 				.= ($j==0)?"":" , ";
				$sql 				.= " :{$key}{$i} ";
				$temp[":{$key}{$i}"] = empty($it)?"":$it;
				$j++;
			}
			$sql .= " ) ";
			$exe  = array_merge($exe,$temp);
			$i++;
		}
		
		if( $i > 0 ){
			
			if( $this->script_mode ){
				$this->script_mode = false;
				return ["sql"=>$sql,"exe"=>$exe];
			}
			
			if( $this->test_mode ){
				$this->test_mode = false;
				foreach( $exe as $key => $item ){
					$sql = str_replace($key, "'{$item}'", $sql);
				}
				return $sql;
			}
			
			
			$sth 	= $this->pdo->prepare($sql);
			$check 	= $sth->execute($exe);
			$last_id= $this->pdo->query("select last_insert_id();")->fetchColumn();
			$return = empty($last_id)?0:$last_id;
			
		
			if( $this->debug_mode ){
				$this->debug_mode = false;
				return $sth->errorInfo();
			}
		}else{
			$check  = 0;
			$return = 0;
		}
		
		return $return;
	}

	
	public function search_concat($columns = array(),$keywords){
		
		$ks  	= explode(" ",trim($keywords));
		$concat	= " concat(".implode(",' ',",$columns).") ";
		
		$i   = 0;
		$exe = array();
		$sql = "";
		foreach( $ks as $item ){
			$sql .= " and ";
			$sql .= " {$concat} like :keyword{$i} ";
			$exe  = array_merge($exe,array(":keyword{$i}"=>"%{$item}%"));
			$i++;
		}
		
		if( trim($keywords) != "" )
			$return = array("text"=>$sql,"array"=>$exe);
		else
			$return = array("text"=>"","array"=>array());
		
		return $return;
	}

	
	public function search_condition($columns = array(), $like = "="){

		$exe = array();
		$sql = "";
		$i   = 0;
		foreach( $columns as $key=>$item ){
			
			if( !empty($item) ){
			
				$col = $key;
				$val = $item;
				
				$sql .= " and {$col} {$like} :search_condition{$i} ";
				$exe  = array_merge($exe,array(":search_condition{$i}"=>(($like=="=")?"{$val}":"%{$val}%")));
				$i++;
			}
		}
		
		return array("text"=>$sql,"array"=>$exe,"columns"=>$columns);
	}
	
	
	
	
	public function search($table, $condition = [], $option = [] ){
		
		
		if( !empty($option["limit"]) ){
			$option["limit"] = ($option["limit"]=="no")?"no":$option["limit"]+1;
		}
		
		$option = [ "start" 	=> (empty($option["start"])?0:$option["start"]),
					"limit" 	=> (empty($option["limit"])?51:$option["limit"]),
					"order_by" 	=> (empty($option["order_by"])?"":$option["order_by"]),
					"group_by" 	=> (empty($option["group_by"])?"":$option["group_by"]),
					];
		
		$revise = [];
		foreach( $condition as $key => $item ){
			
			$skip			= 0;
			$temp 			= [];
			$temp["column"] = $key;

			if( is_array($item) ){
				
				if( !empty($item["skip"])) $skip = 1;
				
				
				if( $item["type"] == "between" ){
					$temp["type"]	= "between";
					$temp["from"]	= $item["from"];
					$temp["to"]		= $item["to"];
				}
				else if( $item["type"] == "search_concat" ){
					$temp["type"]	= "search_concat";
					$re				= $this->search_concat($item["column"],$item["keyword"]);
					$temp["sql"]	= $re["text"];
					$temp["exe"]	= $re["array"];
					
				}
				else if( $item["type"] == "in" ){
					$temp["type"]	= "in";
					$_col			= str_replace(".","_",$key);
					
					$temp["exe"]	= [];
					$j				= 0;
					$re				= "";
					foreach( $item["data"] as $it ){
						$re			 .= ($j==0)?"":",";
						$re			 .= ":{$_col}_{$j}";
						$temp["exe"] = array_merge($temp["exe"],array(":{$_col}_{$j}"=>$it));
						$j++;
					}
					$temp["sql"]	= "(".$re.")";
				}
				else{
					$temp["type"]		= "default";
					$temp["condition"]	= empty($item["condition"])?"=":$item["condition"];
					$temp["value"]		= $item["value"];
				}
			}else{
				$temp["type"]		= "default";
				$temp["condition"]	= "=";
				$temp["value"]		= $item;
			}
			
			if( $skip == 0 ) array_push($revise,$temp);
		}
		
		
		
		
		if( strtolower(substr(trim($table),0,6)) == "select" ){
			$sql 	= "{$table} where ";
		}else{
			$sql 	= "select * from {$table} where ";
		}
		
		$exe	= [];
		$i		= 0;
		foreach( $revise as $item ){
			
			$sql.= ($i==0)?"":" and ";
			
			$col	= str_replace(".","`.`",$item["column"]);
			$_col	= str_replace(".","_",$item["column"]);
			
			
			if( $item["type"] == "default" ){
				
				$sql.= " `{$col}` {$item["condition"]} :{$_col} ";
				$exe = array_merge($exe,array(
							":{$_col}" => $item["value"]
						));
						
			}
			else if( $item["type"] == "between" ){
				
				$sql.= " (`{$col}` between :{$_col}_from and :{$_col}_to) ";
				$exe = array_merge($exe,array(
							":{$_col}_from" => $item["from"],
							":{$_col}_to"   => $item["to"]
						));
			
			}
			else if( $item["type"] == "in" ){
				
				$sql.= " `{$col}` in ".$item["sql"];
				$exe = array_merge($exe,$item["exe"]);
			
			}
			else if( $item["type"] == "search_concat" ){
				
				$sql.= " 1=1 ".$item["sql"];
				$exe = array_merge($exe,$item["exe"]);
			
			}
			$i++;
		}
		
		
		$sql  .= !empty($option["group_by"])?" group by {$option["group_by"]} ":"";
		$sql  .= !empty($option["order_by"])?" order by {$option["order_by"]} ":"";

		
		if( isset($option["limit"]) && $option["limit"] == "no" ){
			$sql  .= " ";
		}else{
			$sql  .= " limit {$option["start"]},{$option["limit"]};";
		}
		
		
		if( $this->test_mode ){
			$this->test_mode = false;
			foreach( $exe as $key => $item ){
				$sql = str_replace($key, "'{$item}'", $sql);
			}
			return $sql;
		}
		
		
		if( $this->script_mode ){
			$this->script_mode = false;
			return ["sql"=>$sql,"exe"=>$exe];
		}
		
		
		$sth   = $this->pdo->prepare($sql);
		$check = $sth->execute($exe);
		
		
		if( $this->debug_mode ){
			$this->debug_mode = false;
			return $sth->errorInfo();
		}
		
		
		if( $check == 0 ){
			$return = ["success"=>0,"message"=>"Error: execution is wrong"];
		}else{
			$result = $sth->fetchAll(PDO::FETCH_ASSOC);
			$return = ["success"=>1,"message"=>"Successfully fetch the results","result"=>$result];
		}
		
		return $return;
	}
	
	
	
	
	public function all($table, $condition = []){
		
		$sql 	= "	select * from {$table} where ";
		$exe	= [];
		$i		= 0;
		foreach( $revise as $key => $item ){
			
			$sql.= ($i==0)?"":" and ";
			$sql.= " `{$key}` = :{$key} ";
			$exe = array_merge($exe,array(
						":{$key}" => $item
					));
			$i++;
		}
		
		
		if( $this->test_mode ){
			$this->test_mode = false;
			foreach( $exe as $key => $item ){
				$sql = str_replace($key, "'{$item}'", $sql);
			}
			return $sql;
		}
		
		
		if( $this->script_mode ){
			$this->script_mode = false;
			return ["sql"=>$sql,"exe"=>$exe];
		}
		
		
		$sth   = $this->pdo->prepare($sql);
		$check = $sth->execute($exe);
		
		
		if( $this->debug_mode ){
			$this->debug_mode = false;
			return $sth->errorInfo();
		}
		
		
		if( $check == 0 ){
			$return = ["success"=>0,"message"=>"Error: execution is wrong"];
		}else{
			$result = $sth->fetchAll(PDO::FETCH_ASSOC);
			$return = ["success"=>1,"message"=>"Successfully fetch the results","result"=>$result];
		}
		
		return $return;
	}
	
	
	
	public function insertLog($detail,$company_id=0){
		
		$company_id = !empty($company_id)?$company_id:$_SESSION["company_id"];
		$user_id 	= !empty($_SESSION["user_id"])?$_SESSION["user_id"]:0;
		$sth 		= $this->pdo->prepare("
						insert into log 
						( `company_id`, `user_id`, `dt`, `engine`, `detail`) values 
						( '{$company_id}', '{$user_id}', now(), :engine, :detail);
						");

		$exe = array(":engine" => $_SERVER["REQUEST_URI"],":detail" => $detail);
		return $sth->execute($exe);
	}
	
	
	
	public function array2tempTable($array,$prefix="",$company_id){

		$tableName 	= "random_".$prefix.$company_id.time();
		$array		= empty($array)?array():$array;
		//~ create temp table
		if(count($array)>0){
			$sql	= "	CREATE TEMPORARY TABLE `{$tableName}` (
						  `company_id` int NOT NULL
						";
						
			$isql 	= "INSERT INTO `{$tableName}` (`company_id` ";
			foreach( $array[0] as $key=>$item ){
			if( $key == "company_id" ) continue;
			$sql	.= ", `{$key}` varchar(255) NOT NULL ";
			$isql	.= ", `{$key}` ";
			}
			$sql	.= " ) ENGINE='MEMORY';";			
			$isql	.= " ) VALUES ";
			$this->pdo->query($sql);
		}


		//~ insert data to table
		if(count($array)>0){
			
			$i = 0; $exe = array();
			foreach( $array as $item ){
				
				$tmp   = array();
				$isql .= ($i==0)?"":",";
				$isql .= "('{$company_id}' ";
				foreach( $array[0] as $k => $it ){
				if( $k == "company_id" ) continue;
				$isql .= ", :{$k}{$i}";	
				$tmp   = array_merge($tmp,array(":{$k}{$i}"=>(empty($item[$k])?"":$item[$k])));
				}
				$isql .= ")";
				$exe  = array_merge($exe,$tmp);
				$i++;
			}
			if($i > 0){
				$sth = $this->pdo->prepare($isql);
				$sth->execute($exe);	
			}
		}
		return (count($array)>0)?$tableName:false;
	}

	public function lastId(){
		$last_id= $this->pdo->query("select last_insert_id();")->fetchColumn();
		$return = empty($last_id)?0:$last_id;
		return $return;

	}
	
	
}





$pdo2 =  new trdb([
			'database_type' => 'mysql',
			'database_name' => $db_name,
			'server' 		=> $host,
			'username' 		=> $db_user,
			'password' 		=> $db_pass,
		 ]);




// check if exist -> convert json to object -> insert into database	
function check($ok){
	return stripslashes($ok);
}
function secure($data){
    
    if(is_array($data)){
        return array_map( 'check' ,$data);
    }
    else{
        return stripslashes($data);
    }
    
}


?>
