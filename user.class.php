<?php 
class User {
	//private - klassi sees
	private $connection;
	
	//klassi loomisel (new User)
	function __construct($mysqli) {
		
		// this tähendab selle klassi muutujat
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
				$category = "Action";
			}elseif (strpos($url,'Komöödia') == true){
				$category = "Komöödia";
			}elseif (strpos($url,'Seiklus') == true){
				$category = 'Seiklus';
			}elseif (strpos($url,'Draama') == true){
				$category = 'Draama';
			}elseif (strpos($url,'Animatsioon') == true){
				$category = 'Animatsioon';
			}elseif (strpos($url,'Biograafia') == true){
				$category = 'Biograafia';
			}elseif (strpos($url,'Krimi') == true){
				$category = 'Krimi';
			}elseif (strpos($url,'Fantaasia') == true){
				$category = 'Fantaasia';
			}elseif (strpos($url,'Ajalugu') == true){
				$category = 'Ajalugu';
			}elseif (strpos($url,'Thriller') == true){
				$category = 'Thriller';
			}elseif (strpos($url,'Ulme') == true){
				$category = 'Ulme';
			}elseif (strpos($url,'Sport') == true){
				$category = 'Sport';
			}elseif (strpos($url,'War') == true){
				$category = 'War';
			}elseif (strpos($url,'Muusikal') == true){
				$category = 'Muusikal';
			}elseif (strpos($url,'Õudukad') == true){
				$category = 'Õudukad';
			}
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			//echo $category;
			$stmt = $mysqli->prepare("SELECT Name, Year, Director FROM VL_Movies WHERE Category=?");
			//var_dump($category);
			echo $mysqli->error;
			$stmt->bind_param("s", $category);
			echo $mysqli->error;
			$stmt->bind_result($Nimi, $Aasta, $Režissöör);
			$stmt->execute();
			// tekitan tühja massiivi, kus edaspidi hoian objekte
			$movie_array= array();
		
			// tee midagi seni, kuni saame ab'st ühe rea andmeid
			while($stmt->fetch()){
			// seda siin sees tehakse nii mitu korda kuni on ridu
			
			//tekitan objekti, kus hakkan hoidma väärtusi
			$movies = new StdClass();
			$movies->Name = $Nimi;
			$movies->Year = $Aasta;
			$movies->Director = $Režissöör;
			
			// lisan massiivi ühe rea juurde
			array_push($movie_array, $movies);
			// var_dump ütleb muutuja nime ja stuffi
			//echo "<pre>";
			//var_dump($car_array);
			//echo "</pre><br>";
			}
		
			// tagastan massiivi, kus kõik read sees
			return $movie_array;
			
			$stmt->close();
			$mysqli->close();
		}

}
?>