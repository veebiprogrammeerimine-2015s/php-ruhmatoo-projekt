<?php 

class Table{
	
	private $connection;
	
	function __construct($mysqli){
		$this->connection=$mysqli;
	}
		

    function getAllData(){
        
        //deleted IS NULL ehk kustutab ära 
        $stmt = $mysqli->prepare("SELECT id, user_id, contest_name, name FROM contests WHERE deleted IS NULL");
        $stmt->bind_result($id_from_db, $contest_name_from_db, $name_from_db);
        $stmt->execute();
  
        // iga rea kohta mis on ab'is teeme midagi
        

        $array = array(); 
        
        while($stmt->fetch()){
            //suvaline muutuja, kus hoida auto andmeid, hetkeni kuni lisame massiivi
            
            //tühi objekt, kus hoiame väärtuseid
            $contest_array = new StdClass();
            $contest_array->id = $id_from_db;
            $contest_array->contest = $contest_name_from_db;
            $contest_array->name = $name_from_db;

            
            //lisan massiivi - auto lisan massiivi
            array_push($array, $all_contest);
            //echo "<pre>";
            //var_dump($array); 
            //echo "</pre>";
            
        }
        //saadan tagasi
        return $array;
        
        $stmt->close();

    }    
        
	function deleteContestData($all_contest_id){
       
        //uuendan välja deleted, lisan praeguse date'i
        $stmt = $this->connection->prepare("UPDATE contests SET deleted=NOW() WHERE id=? AND user_id=?");
        $stmt->bind_param("ii", $all_contest_id, $_SESSION['logged_in_user_id']);
        $stmt->execute();
        
        //tühjendame aadressirea
        //header("Location: table.php");
        
        $stmt->close();
  
    }
    
    function updateContestData($all_contest_id, $contest_name, $name){
       
        
        $stmt = $this->connection->prepare("UPDATE contests SET contest_name=?, name=? WHERE id=?");
        $stmt->bind_param("ssi", $contest_name, $name, $all_contest_id, $_SESSION['logged_in_user_id']);
        $stmt->execute();
        header("Location: table.php");
        
        
        $stmt->close();

    }
	
	
}
?>