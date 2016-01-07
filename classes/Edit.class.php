<?php
Class Edit{
		
	private $connection;
	
	function __construct($mysqli){
		$this->connection=$mysqli;
	}
	
	function getSingleContestData($id){
        
        $stmt = $this->connection->prepare("SELECT contest_name, name FROM contests WHERE id=? AND deleted IS NULL");
        $stmt->bind_param("i", $id);
        $stmt->bind_result($contest_name, $name);
        $stmt->execute();
        
        $all_contest = new StdClass();
        
        if($stmt->fetch()){
            $all_contest->contest_name = $contest_name;
            $all_contest->name = $name;
        //kas sain rea andmed    
        }else{
            //ei tulnud, kui id ei olnud, v�i on kustutatud
            header("Location: table.php");
        }       
        $stmt->close();
             
        
        return $all_contest;
    }
    function updateContestData($contest_id, $contest_name, $name){
        
        
        $stmt = $this->connection->prepare("UPDATE contests SET contest_name=?, name=? WHERE id=?");
        $stmt->bind_param("ssi", $contest_name, $name, $contest_id);
        $stmt->execute();
        header("Location: table.php");
        
        
        $stmt->close();
       
    }	
		
		
	}
?>