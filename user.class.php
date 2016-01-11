<?php
class User {
	//private - klassi sees
	private $connection;

	//klassi loomisel (new User)
	function __construct($mysqli) {

		// this t�hendab selle klassi muutujat
		$this->connection = $mysqli;
	}
	  function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	  }
	  function loginUser($email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email FROM VL_Login WHERE email=? AND hash=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
		  $_SESSION["logged_in_user_id"] = $id_from_db;
		  $_SESSION["logged_in_user_email"] = $email_from_db;
		  $user = new StdClass();
		  $user->email = $email_from_db;
		  header("Location: main.php");
		}
		else{
		  echo "Valed andmed";
		}
	  }
	  function createUser($email_reg, $hash){
		//echo $email_reg;
		//echo $hash;
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO VL_Login (email, hash) VALUES (?,?)");
		$stmt->bind_param("ss", $email_reg, $hash);
		$stmt->execute();
		$stmt->close();

		}
		function getCategory($url){
			if (strpos($url,'Action') == true) {
				$category = "action";
				echo "action";
			}
		}
		function getSearchData($keyword=""){
			$search= "%%";
			if($keyword == ""){
			}
			else{
				$search= "%".$keyword."%";
			}
		  $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		  $stmt= $mysqli->prepare("SELECT id, Name, Category, Year, Director FROM VL_Movies WHERE (Name LIKE ? OR Category LIKE ? OR Year LIKE ? OR Director LIKE ?)");
		  $stmt->bind_param("ssss", $search, $search, $search, $search);
		  $stmt->bind_result($id, $name, $category, $year, $director);
		  $stmt->execute();

		  // tekitan t�hja massiivi, kus edaspidi hoian objekte
		  $search_array = array();

		  //tee midagi seni, kuni saame ab'ist �he rea andmeid
			while($stmt->fetch()){
			// seda siin sees tehakse
			// nii mitu korda kui on ridu
			// tekitan objekti, kus hakkan hoidma v��rtusi
			$result = new StdClass();
			$result->id = $id;
			$result->name = $name;
			$result->category = $category;
			$result->year = $year;
			$result->director = $director;

			//lisan massiivi �he rea juurde
			array_push($search_array, $result);
			//var dump �tleb muutuja t��bi ja sisu
			//echo "<pre>";
			//var_dump($car_array);
			//echo "</pre><br>";
		  }

		  //tagastan massiivi, kus k�ik read sees
		  return $search_array;


		  $stmt->close();
		  $mysqli->close();
		}










































































		function getAccess($movie_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, l�pu_kuup�ev FROM VL_Payment WHERE kasutaja_id=? AND filmi_id=?");
		$stmt->bind_param("ss", $user_id, $movie_id);
		$stmt->bind_result($payment, $end_date);
		$stmt->execute();
		if($stmt->fetch()){
		  $user = new StdClass();
		  $user->payment = $payment;
		  header("Location: https://www.youtube.com/results?search_query=.$");
		}
		else{
		  echo "Puudub juurdep��s";
		}
	  }

}
?>
