<?php
class User {

    private $connection;

    function __construct($mysqli){
        $this->connection = $mysqli;
    }

	###############
	#####LOGIN#####
	###############

  function checkCookie($cookie){
    $stmt = $this->connection->prepare("SELECT user_id FROM user_cookies WHERE random_hash = ?");
    $stmt->bind_param("s", $cookie);
    $stmt->bind_result($user_id);
    $stmt->execute();

    if($stmt->fetch()) {
      $user = new Stdclass();
      $user->id = $user_id;
		}

    $stmt->close();
    $stmt = $this->connection->prepare("SELECT id, email, usergroup FROM ntb_users WHERE id = ?");
    $stmt->bind_param("i", $user->id);
    $stmt->bind_result($user_id, $user_email, $user_group);
    $stmt->execute();
    if($stmt->fetch()) {
      $_SESSION['logged_in_user_id'] = $user_id;
      $_SESSION['logged_in_user_email'] = $user_email;
      $_SESSION['logged_in_user_group'] = $user_group;
    }
  }


		function logInCookie($email, $hash){
		//Emaili ja parooli kontroll
		$response = new StdClass();

		$stmt = $this->connection->prepare("SELECT id FROM ntb_users WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id);
		$stmt->execute();

		if(!$stmt->fetch()) {

			$error = new StdClass();
			$error->id = 0;
			$error->message = "Vale email/parool!";
			$response->error = $error;

			return $response;
		}
		$stmt->close();
		//Kontroll kinni
		//Kasutaja sisse logimine
        $stmt = $this->connection->prepare("SELECT id, email, password, usergroup FROM ntb_users WHERE email=? AND password=?");
        $stmt->bind_param("ss", $email, $hash);
        $stmt->bind_result($id_from_db, $email_from_db, $password, $usergroup_from_db);
        $stmt->execute();
        if($stmt->fetch()){

          $_SESSION['logged_in_user_id'] = $id_from_db;
          $_SESSION['logged_in_user_email'] = $email_from_db;
          $_SESSION['logged_in_user_group'] = $usergroup_from_db;

          $expCookie = time()+60*60*24*30;
          $random_id = time() + $id_from_db;
          $hash_id = hash("md5", $random_id);
    			// sessioon salvestatakse serveris
          setcookie(authUser, $hash_id, $expCookie);

          #$stmt->close();


    			#header("Location: profile.php");
    			#exit();

        }
        $stmt->close();
        $stmt = $this->connection->prepare("INSERT INTO user_cookies (user_id, random_hash) VALUES ('$id_from_db', '$hash_id')");
        $stmt->execute();
        $stmt->close();
        header("Location: profile.php");
        exit();
    }


	function logInUser($email, $hash){
		//Emaili ja parooli kontroll
		$response = new StdClass();

		$stmt = $this->connection->prepare("SELECT id FROM ntb_users WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id);
		$stmt->execute();

		if(!$stmt->fetch()) {

			$error = new StdClass();
			$error->id = 0;
			$error->message = "Vale email/parool!";
			$response->error = $error;

			return $response;
		}
		$stmt->close();
		//Kontroll kinni
		//Kasutaja sisse logimine
        $stmt = $this->connection->prepare("SELECT id, email, usergroup FROM ntb_users WHERE email=? AND password=?");
        $stmt->bind_param("ss", $email, $hash);
        $stmt->bind_result($id_from_db, $email_from_db, $usergroup_from_db);
        $stmt->execute();
        if($stmt->fetch()){

			// sessioon salvestatakse serveris
			$_SESSION['logged_in_user_id'] = $id_from_db;
			$_SESSION['logged_in_user_email'] = $email_from_db;
			$_SESSION['logged_in_user_group'] = $usergroup_from_db;
			//Suuname kasutaja teisele lehele
			header("Location: profile.php");
			exit();

        }
        $stmt->close();

    }

	##################
	#####REGISTER#####
	##################

    function createUser($create_email, $hash){
		//Emaili kontroll
		$response = new StdClass();

		$stmt = $this->connection->prepare("SELECT id FROM ntb_users WHERE email=?");
		$stmt->bind_param("s", $create_email);
		$stmt->bind_result($id);
		$stmt->execute();

		if($stmt->fetch()) {

			$error = new StdClass();
			$error->id = 0;
			$error->message = "Selline email on juba kasutusel!";
			$response->error = $error;

			return $response;
		}
        //Emaili kontroll kinni

		//Konto loomine
        $stmt = $this->connection->prepare("INSERT INTO ntb_users (email, password, usergroup, created) VALUES (?,?,1,NOW())");
        $stmt->bind_param("ss", $create_email, $hash);
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


	function createEmployer($create_email, $hash){
		//Emaili kontroll
		$response = new StdClass();

		$stmt = $this->connection->prepare("SELECT id FROM ntb_users WHERE email=?");
		$stmt->bind_param("s", $create_email);
		$stmt->bind_result($id);
		$stmt->execute();

		if($stmt->fetch()) {

			$error = new StdClass();
			$error->id = 0;
			$error->message = "Selline email on juba kasutusel!";
			$response->error = $error;

			return $response;
		}
        //Emaili kontroll kinni

		//Konto loomine
        $stmt = $this->connection->prepare("INSERT INTO ntb_users (email, password, usergroup, created) VALUES (?,?,2,NOW())");
        $stmt->bind_param("ss", $create_email, $hash);
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

  #######################
	#####EDIT PASSWORD#####
	#######################

  function checkPassword($userid, $oldpass) {
    $checkresponse = new StdClass();

    $stmt = $this->connection->prepare("SELECT id FROM ntb_users WHERE id = ? AND password = ?");
		$stmt->bind_param("is", $userid, $oldpass);
		$stmt->bind_result($id);
		$stmt->execute();
		if(!$stmt->fetch()) {
			$error = new StdClass();
			$error->message = "Sisestatud vana parool oli vale!";
			$checkresponse->error = $error;
			return $checkresponse;

		} else {
      $success = new StdClass();
			$checkresponse->success = $success;
    }

    $stmt->close();
    return $checkresponse;
  }

  function changePassword($userid, $password) {
    $response = new StdClass();

    $stmt = $this->connection->prepare("UPDATE ntb_users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $password, $userid);
    if($stmt->execute()) {
      $success = new StdClass();
			$success->message = "Parool vahetatud!";
			$response->success = $success;

    } else {
      $error = new StdClass();
			$error->message = "Väike ahvike pätsas midagi ära! Võta meiega ühendust!";
			$response->error = $error;
    }

    $stmt->close();
    return $response;
  }


	##########################
	#####RECOVER PASSWORD#####
	##########################

	function checkEmail($email) {
		$checkresponse = new StdClass();

		$stmt = $this->connection->prepare("SELECT id FROM ntb_users WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id);
		$stmt->execute();
		if(!$stmt->fetch()) {
			$error = new StdClass();
			$error->message = "Sellist emaili meil ei eksisteeri!";
			$checkresponse->error = $error;
			return $checkresponse;
		} else {
			$success = new StdClass();
			$success->message = "Email saadetud!";
			$checkresponse->success = $success;

		}
		$stmt->close();
        return $checkresponse;


	}


	function forgotPassword($email, $link, $hash, $ip) {
		$response = new StdClass();

		$stmt = $this->connection->prepare("SELECT id FROM recover_password WHERE email = ? AND (used IS NULL OR used = '0000-00-00 00:00:00') AND end > NOW()");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id);
		$stmt->execute();

		if($stmt->fetch()) {

			$error = new StdClass();
			$error->id = 0;
			$error->message = "Olete juba palunud uut parooli!";
			$response->error = $error;

			return $response;
		}

		$stmt = $this->connection->prepare("INSERT INTO recover_password (sendIP, email, newpw, link, used, date, end) VALUES (?, ?, ?, ?, 0, NOW(), NOW() + INTERVAL 7 DAY)");
		$stmt->bind_param("ssss", $ip, $email, $hash, $link);
		if($stmt->execute()) {
			$success = new StdClass();
			$success->message = "Email saadetud!";
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

	function checkKey($email, $key) {
		$response = new StdClass();
		$stmt = $this->connection->prepare("SELECT id FROM recover_password WHERE email = ? AND link = ?");
		$stmt->bind_param("ss", $email, $key);
		$stmt->bind_result($id);
		$stmt->execute();
		if (!$stmt->fetch()) {
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Miskit läks valesti!";
			$response->error = $error;

			return $response;

		} else {
			$stmt->close();
			$stmt = $this->connection->prepare("SELECT id FROM recover_password WHERE email = ? AND link = ? AND end > NOW()");
			$stmt->bind_param("ss", $email, $key);
			$stmt->bind_result($id);
			$stmt->execute();
			if (!$stmt->fetch()) {
				$error = new StdClass();
				$error->id = 1;
				$error->message = "Link on aegunud!";
				$response->error = $error;

				return $response;

			} else {
				$stmt->close();
				$stmt = $this->connection->prepare("SELECT id FROM recover_password WHERE email = ? AND link = ? AND used IS NULL OR used = '0000-00-00 00:00:00'");
				$stmt->bind_param("ss", $email, $key);
				$stmt->bind_result($id);
				$stmt->execute();
				if ($stmt->fetch()) {
					$success = new StdClass();
					$response->success = $success;

					return $response;

				} else {
					$error = new StdClass();
					$error->id = 2;
					$error->message = "Olete juba parooli taastanud!";
					$response->error = $error;

					return $response;

				}
			}
		}
		#return $response;
		$stmt->close();
	}

	function getPass($email, $key, $ip) {
		$stmt = $this->connection->prepare("SELECT newpw FROM recover_password WHERE email = ? AND link = ?");
		$stmt->bind_param("ss", $email, $key);
		$stmt->bind_result($newpass);
		$stmt->execute();
		if($stmt->fetch()) {
			$pass = new Stdclass();
			$pass->newpass = $newpass;
		}
		$stmt->close();

		$stmt = $this->connection->prepare("UPDATE recover_password SET userIP = ?, used = NOW() WHERE email = ?");
		$stmt->bind_param("ss", $ip, $email);
		$stmt->execute();

		$stmt = $this->connection->prepare("UPDATE ntb_users SET password = ? WHERE email = ?");
		$stmt->bind_param("ss", $pass->newpass, $email);

		if($stmt->execute()) {
			$success = new StdClass();
			$success->message = "Parool taastatud!";
			$response->success = $success;

			return $response;
		} else {
			$error = new StdClass();
			$error->message = "Miskit läks valesti!";
			$response->error = $error;
		}
		return $response;



		$stmt->close();
	}

}



?>
