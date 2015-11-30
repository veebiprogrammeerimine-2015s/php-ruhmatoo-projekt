<?php
Class Confirm{
	
	private $connection;
	
	function __construct($mysqli){
		$this->connection=$mysqli;
	}
	
	function saveNewEntry($contest_id,$user_id){
		
		$stmt = $this->connection->prepare("INSERT INTO confirm contest_name=?, name=? WHERE contest_id=?");
        $stmt->bind_param("ii", $contest_id, $_SESSION['logged_in_user_id']);
        $stmt->execute();
		
	}

}
?>