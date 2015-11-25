<?php

class Worker {
	
	private $connection;
	
	function __construct($mysqli){
		$this->connection = $mysqli;
	}
	
	function getDbData($keyword=""){
		
		$search = "%%";
		
		if($keyword==""){}
		
	}
}

?>