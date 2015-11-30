<?php 

class Table{
	
	private $connection;
	
	function __construct($mysqli){
		$this->connection=$mysqli;
	}
		

	function deleteContestData($all_contest_id){
       
        //uuendan välja deleted, lisan praeguse date'i
        $stmt = $this->connection->prepare("UPDATE contests SET deleted=NOW() WHERE id=? AND user_id=?");
        $stmt->bind_param("i", $all_contest_id);
        $stmt->execute();
        
        //tühjendame aadressirea
        header("Location: table.php");
        
        $stmt->close();
  
    }
    
    function updateContestData($all_contest_id, $contest_name, $name){
       
        
        $stmt = $this->connection->prepare("UPDATE contests SET contest_name=?, name=? WHERE id=?");
        $stmt->bind_param("ssi", $contest_name, $name, $all_contest_id);
        $stmt->execute();
        header("Location: table.php");
        
        
        $stmt->close();

    }
}
?>