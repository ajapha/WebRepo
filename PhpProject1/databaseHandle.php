<?php 

class dbManage {
//This class has a function to connect to a database as well as functions to insert, select and 
//update data on the database
	protected $DBH;
	protected $STH;
  
  function dbConnect($db, $usr, $pw) {
  //connects to mysql on the local host with the specified database, user and password   
  	$host = 'localhost';
    $dbname = $db;
    $user = $usr;
    $pass = $pw;
    try {
	  $this->DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    }  catch (PDOException $e) {

	     echo $e->getMessage();
       }
       
  }
    
  /*function insert($table, $columns, $values) { 
  //executes an SQL INSERT INTO statement with the given columns and values  	  
  	$query = "INSERT INTO $table($columns) VALUES($values)";
    $insert_ct = $this->DBH->exec($query);
    return $insert_ct;
  }*/
  
  function select($column, $table, $where='1=1', $params=NULL, $group= ' ') {
  //executes an SQL SELECT statement with the given columns, table and information for the WHERE and GROUP BY clauses.  
  //The $params paramater can be used for queries where prepared statements with ?s are required.  
  //$params should be set as an array to fill in the ?s in the prepared statement.  If no ? are enetred in the $where parameter, it is not needed.	
    $g = ' ';
  	if($group != ' ') {$g = 'GROUP BY';}
  	$this->STH=$this->DBH->prepare("SELECT $column FROM $table WHERE $where $g $group");
    $this->STH->execute($params);
      return $this->STH;
  }
  function insert($table, $values) {
  	//executes an SQL INSERT INTO statement inserting the $values array into the given table.  
  	//The column names are filled with a combination of functions.
  	$info = $this->getColumnNames($table);
  	$columns = $this->setInsertColumns($info);
  	$params = $this->setInsertParams($info);
  	$this->STH = $this->DBH->prepare("INSERT INTO $table($columns) VALUES($params)");
  	$insert_ct = $this->STH->execute($values);
  	return $insert_ct;
  }
  function getColumnNames($table) {
  	//Gets the column names (except the first auto_incremented one(and active column for table user)) from a table in order to insert values for those columns into the table.  
  	//Called in function 'insert'
  	$this->STH = $this->DBH->query('show columns from users');
  	$columns = $this->STH->fetchAll(PDO::FETCH_COLUMN);
  	array_shift($columns);
  	if($table === 'users') {
  		array_pop($columns);
  	}
  	return $columns;
  }
  function setInsertColumns($info) {
  	//takes an array (in practicefrom the getColumnNames function) and makes it into a comma separated string
  	//Called in function 'insert'
  	$columns = implode(',', $info);
  	return $columns;
  }
  function setInsertParams($info) {
  	//counts the amount of elements in an array (in practicefrom the getColumnNames function) 
  	//and creates a string of ? to be used in a PDO prepare statment. 
  	//Called in function 'insert'
  	$params = ' ';
  	$count = count($info);
  	for ($i=1; $i<$count; $i++) {
  		$params .= '? ,'; 
  	}
  	$params .= '?';
  	return $params; 
  }

  function update($table, $column, $userinfo, $where='1=1') {
  //executes an SQL update statement and returns the count of rows effected.
    $query = "UPDATE $table SET $column = '$userinfo' WHERE $where";
    $updateCount = $this->DBH->exec($query);
    echo $query;
    return $updateCount; 
  }
}
?>
