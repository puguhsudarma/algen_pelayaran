<?php
//fetch the data
function fetch_data($table, $where = array(), $limit = 0, $select = '*'){
//Open Connection	
	$connection = MysqlConnectionOpen();
	$data = array();
//Begin the query...
	//select
	$query = 'SELECT ';
	//* or input the attributes
	if($select != '*'){
		$attr = implode($select, ' ,');
	} else {
		$attr = '*';
	}
	//from table
	$query .= $attr.' FROM '.$table.' ';
	//is there clause where ?
	if(!empty($where)){
		$klausa = ' WHERE ';
		foreach($where as $kelompok){
			foreach($kelompok as $individu){
				$klausa .= $individu.' ';
			}
		}
		$query .= $klausa;
	}
	//is there limitation data ?
	if($limit != 0){
		$query .= 'LIMIT '.$limit;
	}
	//delimiter
	$query .= ';';
//exec
	$exec = mysqli_query($connection, $query);
	if(!$exec){
		return $exec;
	}
	while($row = mysqli_fetch_array($exec, MYSQLI_ASSOC)){
		$data[] = $row;
	}
	mysqli_free_result($exec);
//close connection
	MysqlConnectionClose($connection);
//return
	return $data;
}

//fetch the data with custom query
function fetch_data_custom_query($query){
//Open Connection
	$connection = MysqlConnectionOpen();
	$data = array();
//exec
	$exec = mysqli_query($connection, $query);
	if(!$exec){
		return mysqli_error($connection);
	}
	while($row = mysqli_fetch_array($exec, MYSQLI_ASSOC)){
		$data[] = $row;
	}
	mysqli_free_result($exec);
//Close Connection
	MysqlConnectionClose($connection);
//return
	return $data;
}

function insert($table, $data){
//query
	$connection = MysqlConnectionOpen();	
	$val = array();
	$col = array();
	foreach($data as $attr => $value){
		$val[] = $value;
		$col[] = $attr;
	}
	$value = implode($val, ',');
	$attr = implode($col, ',');
	$query = 'INSERT INTO '.$table.'('.$attr.')'.' VALUES('.$value.');';
//exec
	$exec = mysqli_query($connection, $query);
//close connection
	MysqlConnectionClose($connection);
	return $exec;
}

function update($table, $data, $clause, $limit = 1){
	//open connection database	
	$connection = MysqlConnectionOpen();
	//extract all set update
	foreach($data as $attr => $val){
		$updates[] = $attr.' = '.$val;
	}
	$set = implode($updates, ',');
	//extract all clause where
	$where = ' WHERE ';
	foreach($clause as $attr => $val){
		$where .= $attr.' = '.$val;
	}
	//limit
	$limit = ' LIMIT '.$limit;
	//combine all query
	$query = 'UPDATE '.$table.' SET '.$set.$where.$limit.';';
	//exec the query
	$exec = mysqli_query($connection, $query);
	//close connection
	MysqlConnectionClose($connection);
	return $exec;
}

function delete($table, $clause, $limit = 1){
	//open connection database
	$connection = MysqlConnectionOpen();
	//extract all clause where
	$where = ' WHERE ';
	foreach($clause as $attr => $val){
		$where .= $attr.' = '.$val;
	}
	//limit
	$limit = ' LIMIT '.$limit;
	//combine query
	$query = 'DELETE FROM '.$table.$where.$limit.';';
	//exec
	$exec = mysqli_query($connection, $query);
	//close connection
	MysqlConnectionClose($connection);
	return $exec;
}