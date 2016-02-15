<?php
class User {

	private $connection;

	function __construct($mysqli){
        $this->connection = $mysqli;
    }

	function logInUser($email, $hash){

        $response = new StdClass();

        $stmt = $this->connection->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->bind_result($id);
        $stmt->execute();

        // kas selline email on
        if(!$stmt->fetch()){

            // ei ole
            $error = new StdClass();
            $error->id = 0;
            $error->message = "Sellist emaili ei ole";

            $response->error = $error;

            //lõpetan
            return $response;

        }

        //****************************
        //******* OLULINE ************
        //****************************
        // paneme eelmise käsu kinni
        $stmt->close();

        $stmt = $this->connection->prepare("SELECT id, email FROM users WHERE email=? AND password=?");
        //echo $this->connection->error;
        $stmt->bind_param("ss", $email, $hash);
        $stmt->bind_result($id_from_db, $email_from_db);
        $stmt->execute();
        if($stmt->fetch()){

						$_SESSION['logged_in_user_id'] = $id_from_db;
			  		$_SESSION['logged_in_user_email'] = $email_from_db;

						header("Location: profile.php");
						exit();

        }else{
            // vale parool
            $error = new StdClass();
            $error->id = 1;
            $error->message = "Vale parool";

            $response->error = $error;
        }
        $stmt->close();

        return $response;

    }

	function createUser($email, $hash, $code, $firstname, $lastname, $school){
		$response = new StdClass();
		#Emaili kontroll
		$stmt = $this->connection->prepare("SELECT id FROM users WHERE email=?");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id);
		$stmt->execute();

		if($stmt->fetch()) {

			$error = new StdClass();
			$error->id = 0;
			$error->message = "Selline email on juba kasutusel!";
			$response->error = $error;

			return $response;
		}
		#Kontroll kinni
		#Konto sisestamine
        $stmt = $this->connection->prepare("INSERT INTO users (code, email, password, firstname, lastname, school, usergroup, inserted) VALUES (?,?,?,?,?,?,1,NOW())");
        $stmt->bind_param("ssssss", $code, $email, $hash, $firstname, $lastname, $school);
        if($stmt->execute()) {
			$success = new StdClass();
			$success->message = "Kasutaja loodud!";
			$response->success = $success;
		} else {
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Oh ei! Paistab, et UFO lõhkus midagi ära!";
			$response->error = $error;
		}
        $stmt->close();

		return $response;

    }
	//Konto sisestamine kinni



}

?>
