<?php
Class Confirm{
	
	private $connection;
	
	function __construct($mysqli){
		$this->connection=$mysqli;
	}
	
	function saveNewEntry($contest_id,$user_id){
		
		
		$stmt = $this->connection->prepare("SELECT id FROM confirm WHERE contest_id = ? AND user_id = ?");
		echo $this->connection->error;
        $stmt->bind_param("ii", $contest_id, $_SESSION['logged_in_user_id']);
        $stmt->execute();
        if($stmt->fetch()){
			
			//olemas
			return;
			
		}
		
		$stmt->close();
		
		
		$stmt = $this->connection->prepare("INSERT INTO confirm (contest_id, user_id) VALUES (?,?)");
        $stmt->bind_param("ii", $contest_id, $_SESSION['logged_in_user_id']);
        $stmt->execute();
		
		$stmt->close();
		
		
	}
	
	function getAllData($contest_id,$user_id){
        
        //deleted IS NULL ehk kustutab ära 
        $stmt = $mysqli->prepare("SELECT confirm.id, user_sample.email, contests.contest_name FROM confirm, contests, user_sample WHERE confirm.user_id = user_sample.id AND confirm.contest_id = contests.id AND contests.deleted IS NULL AND confirm.contest_id = ? AND confirm.user_id = ?");
        $stmt->bind_param("ii", $contest_id, $_SESSION['logged_in_user_id']);
		// SEDA RIDA MUUTA $stmt->bind_result($id_from_db, $contest_name_from_db, $name_from_db);
        $stmt->execute();
  
        // iga rea kohta mis on ab'is teeme midagi
        

        $array = array(); 
        
        while($stmt->fetch()){

            
            //tühi objekt, kus hoiame väärtuseid
            $contest_array = new StdClass();
            $contest_array->id = $id_from_db;
            $contest_array->contest = $contest_name_from_db;
            $contest_array->name = $name_from_db;

            

            
        }
        //saadan tagasi
        return $array;
        
        $stmt->close();

    }    
	
	
	
	
	

}
?>