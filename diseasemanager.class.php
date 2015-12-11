<?php
class DiseaseManager{
	private $connection;
	function __construct($mysqli){
		$this->connection=$mysqli;
	}
	function addDisease($new_Disease){
		$response=new StdClass();
		$stmt=$this->connection->prepare("SELECT id FROM af_deseases WHERE desease = ?;");
		$stmt->bind_param("s", $new_Disease);
		$stmt->execute();
		if($stmt->fetch()){
			$error=new StdClass();
			$error->id=0;
			$error->message="Haigus listis olemas";
			$response->error=$error;
			return $response;
		}
		$stmt->close();
		$stmt=$this->connection->prepare("INSERT INTO af_deseases (name) VALUES (?)");
		$stmt->bind_param("s", $new_Disease);
		if($stmt->execute()){
			$success=new StdClass();
			$success->message="Edukalt uus haigus lisatud";
			$response->success=$success;
		}else{
			$error=new StdClass();
			$error->id=1;
			$error->message="Midagi läks katki";
			$response->error=$error;
		}
		$stmt->close();
		return $response;
	}
	function createDropdown(){
		$html = '';
		$html.='<select name="dropdownselect">';
		$stmt=$this->connection->prepare("SELECT id, desease from af_deseases");
		$stmt->bind_result($id, $name);
		$stmt->execute();
		while($stmt->fetch()){
			$html.='<option value="'.$id.'">'.$name.'</option>';
		}
		$stmt->close();
		$html.='</select>';
		return $html;
	}
	function addUserDisease($new_Disease_id, $user_id){
		$response=new StdClass();
		$stmt=$this->connection->prepare("SELECT af_doctors_id FROM af_doctors_deseaes WHERE af_deseases_id = ? AND af_doctors_id= ?;");
		$stmt->bind_param("ii", $new_Disease_id, $user_id);
		$stmt->execute();
		if($stmt->fetch()){
			$error=new StdClass();
			$error->id=0;
			$error->message="Haigus juba listis olemas";
			$response->error=$error;
			return $response;
		}
		$stmt->close();
		$stmt=$this->connection->prepare("INSERT INTO af_doctors_deseaes (af_doctors_id, af_deseases_id) VALUES (?, ?)");
		$stmt->bind_param("ii", $user_id, $new_Disease_id);
		if($stmt->execute()){
			$success=new StdClass();
			$success->message="Uus haigus edukalt lisatud";
			$response->success=$success;
		}else{
			$error=new StdClass();
			$error->id=1;
			$error->message="Midagi läks katki".$stmt->error;
			$response->error=$error;
		}
		$stmt->close();
		return $response;
	}
	function getUserDiseases($user_id){
		$table_data = array();
		$stmt=$this->connection->prepare("SELECT af_doctors_deseaes.id, desease FROM af_doctors_deseaes JOIN af_deseases ON af_deseases.id = af_doctors_deseaes.af_deseases_id JOIN af_doctors ON af_doctors.id = af_doctors_deseaes.af_doctors_id WHERE af_doctors.af_persons_id = ?");
		$stmt->bind_param("i", $user_id);
		$stmt->bind_result($id_to_delete, $desease_name);
		$stmt->execute();
		while($stmt->fetch()){
				echo "<pre>";
				$table_row = new StdClass();
				$table_row->id = $id_to_delete;
				$table_row->Haigus = $desease_name;
				$table_row->Eemalda = "<a href='?delete=".$id_to_delete.">Eemalda</a>";
				array_push($table_data, $table_row);
				var_dump($table_data);
				echo "</pre>";
		}
		$stmt->close();
		return $table_data;
	}
	// üks funktsioon tabeli printimiseks
	// kood laenatud http://stackoverflow.com/questions/4746079/how-to-create-a-html-table-from-a-php-array
	function build_table($array){
			// start table
   			 $html = '<table class="table table-bordered">';
    		// header row
    		$html .= '<tr>';
    		foreach($array[0] as $key=>$value){
            	$html .= '<th>' . $key . '</th>';
        	}
    		$html .= '</tr>';

    		// data rows
    		foreach( $array as $key=>$value){
        	$html .= '<tr>';
        	foreach($value as $key2=>$value2){
            	$html .= '<td>' . $value2 . '</td>';
        	}
        	$html .= '</tr>';
    	}

    	// finish table and return it

    	$html .= '</table>';
    	return $html;
	}
	function deleteDisease($id_to_be_deleted){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE af_doctors_deseases SET deleted=NOW() WHERE af_deseases_id=? AND af_doctors_id_id=?");
		$stmt->bind_param("ii", $id_to_be_deleted, $_SESSION["id_from_db"]);
		if($stmt->execute()){
			//kui on edukas
			header("Location: drtimemanager.php");
		}
		$stmt->close();
		$mysqli->close();
	}
}?>