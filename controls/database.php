<?php require_once('config.ini');

class Database {

	public $connect;

	function __construct(){
		$this->connect();
		}

	private function connect(){
		$this->connect = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
		if($this->connect){
			mysql_select_db(DB_NAME);
			}else {echo DB_NAME;
				$this->passError($this->connect,NULL);
				}
		}

	
	public function disconnect(){

		if($this->connect){

			mysql_close($this->connect);

			unset($this->connect);

			}

		}

	

	function query($sql){
		$res = mysql_query($sql);
		if($res) {return $res;} else { $this->passError($res,$sql); return false;}
		}

	function countRows($pass){

		if(is_resource($pass)){

			return mysql_num_rows($pass);

			}else if(is_string($pass)){

				return mysql_num_rows($this->query($pass));

				}

		}

	

	function del($table,$field,$value){

		$value = is_string($value) ? "'$value'" : $value;

		$sql = "DELETE FROM `$table` WHERE `$field` = $value";

		return $this->query($sql);

		}

	

	function getRecords($table,$fields,$values,$block=20,$page=1,$order_by='id',$order_type='DESC'){
		$page--;
		$offset = $block*$page;
		$limit = $block;
		$sql = "SELECT * FROM `$table` WHERE ";
		$order = $this->tableOrder($table,$order_by,$order_type);
		$where = NULL;

		$max = count($fields);
		
		for($i=0;$i<$max;$i++){
			$where .= ($i < ($max-1)) ?" `{$fields[$i]}` = '{$values[$i]}' AND " : "`{$fields[$i]}` = '{$values[$i]}' ";}
		  $parg = ($limit != 0) ?  " LIMIT $limit OFFSET $offset " : NULL;
		return $this->resArray($this->query($sql.$where.$order.$parg));

		}

		

	function getRecordsLikeOr($table,$fields,$values){

		$sql = "SELECT * FROM `$table` WHERE ";

		$where = NULL;

		$max = count($fields);

		for($i=0;$i<$max;$i++){
			$where .= ($i < ($max-1)) ?" `{$fields[$i]}` LIKE '%{$values[$i]}%' AND " : "`{$fields[$i]}` LIKE '%{$values[$i]}%' ";}
		return $this->resArray($this->query($sql.$where));

		}

	

	function fetchArray($res){

		return mysql_fetch_array($res);

		}
	
	function tableOrder($table,$field,$type){
		$fields = $this->get_table_fields($table);
		if(in_array($field,$fields) and ($type == 'ASC' or $type == 'DESC')){
			return " ORDER BY `$table`.`$field` $type ";
			}
		}
	
	function getTable($table,$limit=20,$page=1,$order_by='id',$type = 'DESC'){
		$page--;
		$offset = $page*$limit;
		$order = $this->tableOrder($table,$order_by,$type);
		$parg = ($limit != 0) ? " LIMIT $limit OFFSET $offset" : NULL;
		$sql = "SELECT * FROM `$table` $order $parg";
		$res = $this->query($sql);
		return $this->resArray($res);
		}

	function resArray($res){
		$res = (!is_resource($res)) ? $this->query($res) : $res; 
		$array = array();

		while($row = $this->fetchArray($res)){
			$array[count($array)] = $row;
			}

		return $array;

		}
	

	function update($table,$key,$keyValue,$fields,$values){

		$set = 'SET ';

		$max = count($fields);

		if(count($fields) != count($values)){ return 'COLUMN COUNT != FIELD COUNT';}

		for($i=0;$i<$max;$i++){
			//$values[$i] = is_string($values[$i]) && !is_array($values[$i]) ? addslashes($values[$i]) : $values[$i];
			$set .= ($i < ($max-1)) ? "`{$fields[$i]}` = '".addslashes($values[$i])."', " :"`{$fields[$i]}` ='".addslashes($values[$i])."' "  ;
			}

		$sql = "UPDATE `$table` $set WHERE `$key` = '$keyValue'";
		
		return $this->query($sql);
		
		}

	

	function insert($table,$fields,$values){
		$field = NULL;
		$value = NULL;
		$max = count($fields);
		if(count($fields) != count($values)){ return "FIELDS TO COLUMN COUNT DOES NOT MATCH <br> Fields : " . count($fields) . '<br> Values : ' . count($values);}
		for($i=0;$i<$max;$i++){
			$values[$i] = is_string($values[$i]) && !is_array($values[$i]) ? addslashes($values[$i]) : $values[$i];
			$field .= ($i < ($max-1)) ? "`{$fields[$i]}`, " :"`{$fields[$i]}` "  ;
			$value .= ($i < ($max-1)) ? "'{$values[$i]}', " :"'".($values[$i])."' "  ;
			}
		$sql = "INSERT INTO `$table` ($field) VALUES ($value)";
		
		return $this->query($sql);
		}
	
	function new_insert($table,$values){
		$field = NULL;
		$value = NULL;
		$max = count($fields);
		//	if(count($fields) != count($values)){ return "FIELDS TO COLUMN COUNT DOES NOT MATCH <br> Fields : " . count($fields) . '<br> Values : ' . count($values);}
		$i=0;
		foreach($values as $label => $v){
			
			$field .=  ($i < ($max-1)) ? "`{$label}`, " :"`{$label}` " ;
			$value .= ($i < ($max-1)) ? "'{$v}', " :"'".($v)."' "  ;
			
			
			$i++;
			}
		$sql = "INSERT INTO `$table` ($field) VALUES ($value)";
		
		echo $sql;
		return false;
		
		for($i=0;$i<$max;$i++){
			$values[$field[$i]] = is_string($values[$i]) && !is_array($values[$i]) ? addslashes($values[$i]) : $values[$i];
			$field .= ($i < ($max-1)) ? "`{$fields[$i]}`, " :"`{$fields[$i]}` "  ;
			$value .= ($i < ($max-1)) ? "'{$values[$i]}', " :"'".($values[$i])."' "  ;
			}
		$sql = "INSERT INTO `$table` ($field) VALUES ($value)";
		
		return $this->query($sql);
		}
		
	function make_where($table,$fields_values,$or_and='AND',$equals_like='='){
		
		
		$where = NULL;
		$max = count($fields_values);
		$i = 0;
		foreach($fields_values as $label => $value){
			$value = is_string($value) && !is_array($value) ? addslashes($value) : $value;
			$where .= ($i < ($max-1)) ?" `$table`.`{$label}` $equals_like '".($value)."' $or_and " : "`$table`.`{$label}` = '".($value)."' ";
			$i++;
			}
			return $where;
			
		}

	function countTableRows($table){
		$sql = "SELECT * FROM `$table`";
		return $this->countRows($sql);
		}

	function fetchOneArray($sql){

		return mysql_fetch_array($this->query($sql));

		}

	

	function getRecord($table,$key,$value){
		$fields = $this->get_table_fields($table);
		$sql = "SELECT * FROM `$table` WHERE `$key` = '$value'";

		$data = $this->fetchOneArray($sql);
		return $data;
		}

	function tableParg($block,$page){
		if($page > 0) $page--;
		$sql = ($block != 0) ? ' LIMIT ' . $block . ' OFFSET ' . ($page*$block) : NULL;
		
		return $sql;
		}
	
	function getLast($table,$order_by='id',$order_type='DESC'){

		return $this->fetchOneArray("SELECT * FROM `$table` ORDER BY `$order_by` $order_type LIMIT 1" );

		}

	

	function checkUnique($table,$field,$value){

		$sql = "SELECT * FROM `$table` WHERE `$field` = '".($value)."'";

		$total = $this->countRows($sql);

		return $total == 0 ? TRUE : FALSE;

		}

	 

	function checkMatch($table,$fields,$values){

		$sql = "SELECT * FROM `$table` WHERE ";

		$where = NULL;

		$max = count($fields);

		for($i=0;$i<$max;$i++){

			$values[$i] = is_string($values[$i]) && !is_array($values[$i]) ? addslashes($values[$i]) : $values[$i];

			$where .= ($i < ($max-1)) ?

			" `{$fields[$i]}` LIKE '".$values[$i]."' AND " : 

			"`{$fields[$i]}` LIKE '".$values[$i]."' ";

			}
		$sql = $sql.$where;
		return $this->countRows($sql) == 0 ? FALSE : TRUE;

		}

	 

	function getOneMatch($table,$fields,$values,$order_by='id',$type='DESC'){
		$sql = "SELECT * FROM `$table` WHERE ";
		$order = $this->tableOrder($table,$order_by,$type);
		$where = NULL;
		$max = count($fields);
		for($i=0;$i<$max;$i++){
			$values[$i] = is_string($values[$i]) && !is_array($values[$i]) ? addslashes($values[$i]) : $values[$i];
			$where .= ($i < ($max-1)) ?" `{$fields[$i]}` = '".($values[$i])."' AND " : "`{$fields[$i]}` = '".($values[$i])."' ";}
		$sql = $sql.$where.$order.' LIMIT 1';
		$array =  $this->fetchOneArray($sql);
		return $array;
		}

	 

	function getMatch($table,$fields,$values,$limit=20,$page=1,$order_by='id',$type='DESC'){
		$page--;
		$offset = $page*$limit;
		$parg = ($limit != 0 ) ? 'LIMIT '.$limit.' OFFSET '.$offset : NULL;
		$sql = "SELECT * FROM `$table` WHERE ";
		$where = NULL;
		$max = count($fields);
		for($i=0;$i<$max;$i++){
			$values[$i] = is_string($values[$i]) && !is_array($values[$i]) ? addslashes($values[$i]) : $values[$i];
			$where .= ($i < ($max-1)) ?" `{$fields[$i]}` = '".($values[$i])."' AND " : "`{$fields[$i]}` = '".($values[$i])."' ";}
		$order = $this->tableOrder($table,$order_by,$type);
		$sql = $sql.$where.$order.$parg;
		
		return $this->resArray($this->query($sql));
		}



	
	function getColumnSum($table,$fields,$values,$sum_column){
		$sql = "SELECT SUM(`$sum_column`) AS `$sum_column` FROM `$table` WHERE ";
		$where = NULL;
		$max = count($fields);
		for($i=0;$i<$max;$i++){
			$values[$i] = is_string($values[$i]) && !is_array($values[$i]) ? addslashes($values[$i]) : $values[$i];
			$where .= ($i < ($max-1)) ?" `{$fields[$i]}` = '".($values[$i])."' AND " : "`{$fields[$i]}` = '".($values[$i])."' ";}
		
		$sql = $sql.$where;
		$scores = $this->resArray($this->query($sql));
		return  $scores[0][0];
		
		}
	 

	function countMatch($table,$fields,$values){

		$sql = "SELECT * FROM `$table` WHERE ";

		$where = NULL;

		$max = count($fields);

		for($i=0;$i<$max;$i++){

				$values[$i] = is_string($values[$i]) && !is_array($values[$i]) ? addslashes($values[$i]) : $values[$i];

				$where .= ($i < ($max-1)) ?" `{$fields[$i]}` = '".($values[$i])."' AND " : "`{$fields[$i]}` ='".($values[$i])."' ";}

		return $this->countRows($sql.$where);

		}

	

	function delete($table,$fields,$values){

		$sql = "DELETE FROM `$table` WHERE ";

		$where = NULL;

		$max = count($fields);

		for($i=0;$i<$max;$i++){

			$values[$i] = is_string($values[$i]) && !is_array($values[$i]) ? addslashes($values[$i]) : $values[$i];

			$where .= ($i < ($max-1)) ? " `{$fields[$i]}` = '".($values[$i])."' AND " : "`{$fields[$i]}` = '".($values[$i])."' ";

			}

		return $this->query($sql.$where);

		}

	

	function search($table,$fields,$values,$block=10,$page=1,$order_by='id',$type='DESC'){
		$order = $this->tableOrder($table,$order_by,$type);
		$parg = $this->tableParg($block,$page);
		$sql = "SELECT * FROM `$table` WHERE ";

		$where = NULL;

		$max = count($fields);

		for($i=0;$i<$max;$i++){

			$values[$i] = is_string($values[$i]) && !is_array($values[$i]) ? addslashes($values[$i]) : $values[$i];

			$where .= ($i < ($max-1)) ?" `{$fields[$i]}` LIKE '%{$values[$i]}%' OR " : "`{$fields[$i]}` LIKE '%{$values[$i]}%' ";

			}
			$sql = $sql.$where.$order.$parg;
			
		return $this->resArray($this->query($sql));
		}

	
	function getLikeOr($table,$fields,$values,$block=10,$page=1,$order_by='id',$type='DESC'){
		$order = $this->tableOrder($table,$order_by,$type);
		$parg = $this->tableParg($block,$page);
		$sql = "SELECT * FROM `$table` WHERE ";

		$where = NULL;

		$max = count($fields);

		for($i=0;$i<$max;$i++){

			$values[$i] = is_string($values[$i]) && !is_array($values[$i]) ? addslashes($values[$i]) : $values[$i];

			$where .= ($i < ($max-1)) ?" `{$fields[$i]}` = '{$values[$i]}' OR " : "`{$fields[$i]}` = '{$values[$i]}' ";

			}
		return $this->resArray($sql.$where.$order.$parg);
		}

	

	function getAvg($table,$fields,$values,$target){

		$sql = "SELECT AVG(`$target`) AS `ave` FROM `$table` WHERE ";

		$where = NULL;

		$max = count($fields);

		for($i=0;$i<$max;$i++){

			$values[$i] = is_string($values[$i]) && !is_array($values[$i]) ? addslashes($values[$i]) : $values[$i];

			$where .= ($i < ($max-1)) ? " `{$fields[$i]}` = '".($values[$i])."' AND " : "`{$fields[$i]}` = '{$values[$i]}' ";}

		$array = $this->fetchOneArray($sql.$where);

		//echo pre; echo $sql.$where;

		return $array['ave'] ? $array['ave'] : 0;

		}

	
	function get_table_fields($table){
		$sql = "SELECT * FROM `$table` LIMIT 1";
		$res = $this->query($sql);
		$array = $this->fetchOneArray($sql);
		$fields = array();
		for($i=0; $i<count($array)/2; $i++){
			$fields[$i] = mysql_field_name($res,$i);;
			}
		return $fields;
		}
	
	function get_join_tables($tables, $get_table = false, $get_key = false,$get_value = false, $page = 1,  $block = 10){
		if(!is_array($tables)){
			return $this->search_all($tables,$search,$page,$block);
			}
		if(count($tables) == 1) {
			return $this->search_all($tables[0],$search,$page,$block);
			}			
		$page--;
		$offset = $page*$block;
		$limit = $block;
		$sql_last = ($limit != 0 ) ?  "
		 LIMIT $limit OFFSET $offset" : NULL;
		$fields = array();
		$sql = "SELECT 
		";
		$sql_fields = NULL;
		$sql_join = ' INNER 
		';
		 $where = ' WHERE `$get_table`.`$get_key` LIKE '.$get_value.'
		 ';
		for($i=0; $i<count($tables); $i++){
			$fields[$i] = $this->get_table_fields($tables[$i]);	
			foreach($fields[$i] as $field){
				$sql_fields .= '
				 `'.$tables[$i].'`.`'.$field.'` AS `'.$tables[$i].'-'.$field.'`, ';
				}	
			}
		
		$sql_fields = substr($sql_fields,0,strlen($sql_fields)-2);
		$sql .= $sql_fields . "
		 FROM `{$tables[0]}` " ;
		for($i=0; $i<count($tables); $i++){
			foreach($fields[$i] as $field){
				if(in_array($field,$tables)){
					$sql_join .= '
					 JOIN `'. $tables[$i].'` ON `'.$field.'`.`id` = `' . $tables[$i].'`.`'.$field.'` ' ;
					}
				}
			}
		
		$where = substr($where,0,strlen($where)-4);
		$where = (!$get_table || !$get_key || !$get_value) == NULL ? NULL : $where;
		$sql .= $sql_join .$where. $sql_last;
		return $limit > 1 ? ($this->resArray($sql)) : $this->fetchOneArray($sql);
		}
		
	
		
	function update_log($message=NULL){
		$log = NULL;
		if(file_exists('log')){$log = file_get_contents('log');}
			$text = strftime('%c',time());
			$text .= '	'.$_SERVER['REMOTE_ADDR'];
			$text .= '	'.$message;
			$text .= '
			'.$log;
		//	file_put_contents('log',$text);
		}
	

	public function passError($res,$sql){
		$error = mysql_error($res);
		$error_no = mysql_errno($res);
		$message = $error_no . '	' . $error;
		$this->update_log($message); 
		echo '<pre>';
		echo $sql.'<br>';
		echo mysql_error();
		exit;
		}

	}

$db = new Database();
