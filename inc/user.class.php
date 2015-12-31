<?php
class User {

    private $connection;
    public $url;

    function __construct($mysqli, $myurl){
        $this->connection = $mysqli;
        $this->url = $myurl;
    }

	###############
	#####LOGIN#####
	###############

  #If cookie exists then this fn checks this
  function checkCookie($cookie){
    $stmt = $this->connection->prepare("SELECT user_id FROM user_cookies WHERE random_hash = ?");
    $stmt->bind_param("s", $cookie);
    $stmt->bind_result($user_id);
    $stmt->execute();

    #Everything is fine, user id to object
    if($stmt->fetch()) {
      $user = new Stdclass();
      $user->id = $user_id;
		}

    $stmt->close();
    #Gets userdata from users and creates session
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
		$response = new StdClass();
    #Checks if user and password are correct
		$stmt = $this->connection->prepare("SELECT id FROM ntb_users WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id);
		$stmt->execute();
    #False
		if(!$stmt->fetch()) {

			$error = new StdClass();
			$error->id = 0;
			$error->message = "Vale email/parool!";
			$response->error = $error;

			return $response;
		}
		$stmt->close();
		#True, creates new session
    $stmt = $this->connection->prepare("SELECT id, email, password, usergroup FROM ntb_users WHERE email=? AND password=?");
    $stmt->bind_param("ss", $email, $hash);
    $stmt->bind_result($id_from_db, $email_from_db, $password, $usergroup_from_db);
    $stmt->execute();

    if($stmt->fetch()){
      $_SESSION['logged_in_user_id'] = $id_from_db;
      $_SESSION['logged_in_user_email'] = $email_from_db;
      $_SESSION['logged_in_user_group'] = $usergroup_from_db;
      #Creating cookie exp. date and random hash to authenticate user if user returns
      $expCookie = time()+60*60*24*30;
      $random_id = time() + $id_from_db;
      $hash_id = hash("md5", $random_id);
			// sessioon salvestatakse serveris
      setcookie(authUser, $hash_id, $expCookie);

    }

    $stmt->close();
    #Checks database if cookie with the same user id exists
    $stmt = $this->connection->prepare("SELECT id FROM user_cookies WHERE user_id=?");
    $stmt->bind_param("i", $id_from_db);
    $stmt->bind_result($cookie_id);
    $stmt->execute();
    #If exists, then overwrites it
    if($stmt->fetch()){
      $stmt->close();
      $stmt = $this->connection->prepare("UPDATE user_cookies SET random_hash = ? WHERE user_id = ?");
      $stmt->bind_param("si", $hash_id, $id_from_db);
      $stmt->execute();
    #Else inserts new cookie to database
      } else {
        $stmt->close();
        $stmt = $this->connection->prepare("INSERT INTO user_cookies (user_id, random_hash) VALUES (?, ?)");
        $stmt->bind_param("is", $id_from_db, $hash_id);
        $stmt->execute();
      }
    $stmt->close();
    header("Location: ".$this->url."content/profile.php");
    exit();
    }


	function logInUser($email, $hash){
		$response = new StdClass();
    #Checks if user and password are correct
		$stmt = $this->connection->prepare("SELECT id FROM ntb_users WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id);
		$stmt->execute();
    #False
		if(!$stmt->fetch()) {

			$error = new StdClass();
			$error->id = 0;
			$error->message = "Vale email/parool!";
			$response->error = $error;

			return $response;
		}
		$stmt->close();
		#Creating new session
    $stmt = $this->connection->prepare("SELECT id, email, usergroup FROM ntb_users WHERE email=? AND password=?");
    $stmt->bind_param("ss", $email, $hash);
    $stmt->bind_result($id_from_db, $email_from_db, $usergroup_from_db);
    $stmt->execute();
    if($stmt->fetch()){

  		$_SESSION['logged_in_user_id'] = $id_from_db;
  		$_SESSION['logged_in_user_email'] = $email_from_db;
  		$_SESSION['logged_in_user_group'] = $usergroup_from_db;

  		header("Location: ".$this->url."content/profile.php");
  		exit();
      }

      $stmt->close();

    }

	##################
	#####REGISTER#####
	##################

    function createUser($create_email, $hash){
		#Checks email
		$response = new StdClass();

		$stmt = $this->connection->prepare("SELECT id FROM ntb_users WHERE email=?");
		$stmt->bind_param("s", $create_email);
		$stmt->bind_result($id);
		$stmt->execute();
    #If email exists, returns error
		if($stmt->fetch()) {

			$error = new StdClass();
			$error->id = 0;
			$error->message = "Selline email on juba kasutusel!";
			$response->error = $error;

			return $response;
		}
    #Creates new user
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
		#Checks email
		$response = new StdClass();

		$stmt = $this->connection->prepare("SELECT id FROM ntb_users WHERE email=?");
		$stmt->bind_param("s", $create_email);
		$stmt->bind_result($id);
		$stmt->execute();
    #Exists, give error
		if($stmt->fetch()) {

			$error = new StdClass();
			$error->id = 0;
			$error->message = "Selline email on juba kasutusel!";
			$response->error = $error;

			return $response;
		}
    #New employer
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
    #Checks old password
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
    #If everything is OK, changes password
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
    #Checks if email exists
		$stmt = $this->connection->prepare("SELECT id FROM ntb_users WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id);
		$stmt->execute();
    #Doesn't exist, gives error
		if(!$stmt->fetch()) {
			$error = new StdClass();
			$error->message = "Sellist emaili meil ei eksisteeri!";
			$checkresponse->error = $error;
			return $checkresponse;
    #Exists, gives success msg, which is used to send email
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
