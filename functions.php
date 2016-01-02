<?php 
	
	require_once("../../config_global.php");
	$database = "if15_hendrik7";
	
	session_start();
	
	function getSeries($keyword=""){
		
		$search = "%%";
		
		if($keyword == ""){
			//ei otsi midagi
			echo "Ei otsi";
		}else{
			//otsin
			echo "Otsin ";
			$search= "%".$keyword."%";
		}
		
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			$stmt = $mysqli->prepare("SELECT id, title, season, description, picture from series WHERE 
			(title LIKE ?)");
			echo $mysqli->error;
			$stmt->bind_param("s", $search);
			$stmt->bind_result($id, $title, $season, $description, $picture);
			$stmt->execute();
			
			// tekitan tühja massiivi, kus edaspidi hoian objekte
			$series_array = array();
			
			//tee midagi seni, kuni saame ab'ist ühe rea andmeid
			while($stmt->fetch()){
				// seda siin sees tehakse 
				// nii mitu korda kui on ridu
				// tekitan objekti, kus hakkan hoidma väärtusi
				$series = new StdClass();
				$series->id = $id;
				$series->title = $title;
				$series->season = $season;
				$series->description = $description;
				$series->picture = $picture;
				
				
				//lisan massiivi ühe rea juurde
				array_push($series_array, $series);
				//var dump ütleb muutuja tüübi ja sisu
				//echo "<pre>";
				//var_dump($car_array);
				//echo "</pre><br>";
			}
			
			//tagastan massiivi, kus kõik read sees
			return $series_array;
			
			
			$stmt->close();
			$mysqli->close();
			}
	
	function dropdown(){
		
		$html = "";
		
		$html .= '<select name="new_dd_selection">';
		//$html .= '<option>1</option>';
		//$html .= '<option>2</option>';
		//$html .= '<option>3</option>';
		//$html .= '<option selected>3</option>';
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, name FROM user_list where user_id=?");
		
		$stmt->bind_param("i", $_SESSION["logged_in_user_id"]);
		$stmt->bind_result($id, $name);
		$stmt->execute();
		
		while($stmt->fetch()){
			$html .= '<option value="'.$id.'">'.$name.'</option>';
			
		}
		
		
		$html .= '</select>';
		
		return $html;
	}
	
?>