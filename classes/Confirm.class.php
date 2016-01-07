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
        if($stmt->execute()){
			echo "siin";
		}else {
			echo $stmt->error;
		}
		
		$stmt->close();
		
		
	}
	
	function getAllData(){
        
        //deleted IS NULL ehk kustutab ära 
        $stmt = $this->connection->prepare("SELECT confirm.id, user_sample.id, user_sample.email, contests.contest_name, confirm.result, confirm.grade, confirm.run_comment FROM confirm, contests, user_sample WHERE confirm.user_id = user_sample.id AND confirm.contest_id = contests.id AND contests.deleted IS NULL");
		
		$stmt->bind_result($id_from_db, $user_id, $user, $contest_name, $result, $grade, $run_comment);
        $stmt->execute();
  
        // iga rea kohta mis on ab'is teeme midagi
        

        $array = array(); 
        
        while($stmt->fetch()){

            
            //tühi objekt, kus hoiame väärtuseid
            $contest_array = new StdClass();
            $contest_array->id = $id_from_db;
            $contest_array->user_id = $user_id;
            $contest_array->user = $user;
            $contest_array->contest_name = $contest_name;
            $contest_array->result = $result;
            $contest_array->grade = $grade;
            $contest_array->run_comment = $run_comment;

            array_push($array, $contest_array);

            
        }
        //saadan tagasi
        return $array;
        
        $stmt->close();

    }    
	
	
	function updateConfirmData($confirm_id, $result, $grade, $run_comment){
		$stmt = $this->connection->prepare("UPDATE confirm SET result=?, grade=?, run_comment=? WHERE id = ? AND user_id=?");
        $stmt->bind_param("iisii", $result, $grade, $run_comment, $confirm_id, $_SESSION['logged_in_user_id']);
        if($stmt->execute()){
			echo "siin";
		}else {
			echo $stmt->error;
		}
	}
	
	

}
?>