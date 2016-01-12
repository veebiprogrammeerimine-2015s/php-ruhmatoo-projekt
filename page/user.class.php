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

		function updateUser($new_hash){
			$email=$_SESSION["logged_in_user_email"];
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			$stmt = $mysqli->prepare("UPDATE VL_Login SET hash=? WHERE email=? ");
			echo "tere";
			$stmt->bind_param("ss", $new_hash, $email);
			$stmt->execute();
			$stmt->close();
			$mysqli->close();
		}
		function getCategory($url){
			if (strpos($url,'Action') == true) {
				$category = "Action";
			}elseif (strpos($url,'Comedy') == true){
				$category = "Comedy";
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
			}elseif (strpos($url,'Horror') == true){
				$category = 'Horror';
			}
			$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
			//echo $category;
			$stmt = $mysqli->prepare("SELECT id, Name, Year, Director FROM VL_Movies WHERE Category=?");
			//var_dump($category);
			echo $mysqli->error;
			$stmt->bind_param("s", $category);
			echo $mysqli->error;
			$stmt->bind_result($id, $Nimi, $Aasta, $Režissöör);
			$stmt->execute();
			// tekitan tühja massiivi, kus edaspidi hoian objekte
			$movie_array= array();

			// tee midagi seni, kuni saame ab'st ühe rea andmeid
			while($stmt->fetch()){
			// seda siin sees tehakse nii mitu korda kuni on ridu
				$sql = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
				$stmt2= $sql->prepare("SELECT link FROM VL_Links WHERE VL_Movies_id=?");
				$stmt2->bind_param("i", $id);
				$stmt2->bind_result($movie_link);
				$stmt2->execute();
				$stmt2->fetch();
			//tekitan objekti, kus hakkan hoidma väärtusi
				$movies = new StdClass();
				$movies->Name = $Nimi;
				$movies->Year = $Aasta;
				$movies->Director = $Režissöör;



				$movies->Link = $movie_link;

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
		function getSearchData($keyword=""){

			$user_id = $_SESSION["logged_in_user_id"];
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
					$sql = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
					$stmt2= $sql->prepare("SELECT link FROM VL_Links WHERE VL_Movies_id=?");
					$stmt2->bind_param("i", $id);
					$stmt2->bind_result($link);
					$stmt2->execute();
					$stmt2->fetch();
					$result = new StdClass();
					$result->id = $id;
					$result->name = $name;
					$result->category = $category;
					$result->year = $year;
					$result->director = $director;
						//$sqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
						//$stmt3= $sqli->prepare("SELECT * FROM VL_Payment WHERE (kasutaja_id = ? AND filmi_id= ? AND end_date >= DATE(now()))");
						//$stmt3->bind_param("ii", $user_id, $id);
						//$stmt3->execute();
						//if($stmt->fetch()){
						//	var_dump($link);
						//	$result->link = $link;
					//	}
					//	else{
					//		$link = "http://localhost:5555/~robigin/vebprog/php-ruhmatoo-projekt/katki.php";
							$result->link = $link;
					//	}

					array_push($search_array, $result);
		  }

		  //tagastan massiivi, kus k�ik read sees
		  return $search_array;
			$_SESSION["logged_in_user_id"] = $user_id;
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
