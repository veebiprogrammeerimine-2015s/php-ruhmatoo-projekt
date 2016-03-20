<?php
class Profile {
	private $connection;

    function __construct($mysqli){
        $this->connection = $mysqli;
    }

	/*Tööotsija*/
	function editPersonal($id, $first, $last, $born, $county, $parish, $number) {
		$response = new StdClass();
		$stmt = $this->connection->prepare("SELECT id FROM ntb_personal WHERE user_id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();

		if($stmt->fetch()) {

			$stmt->close();

			$stmt = $this->connection->prepare("UPDATE ntb_personal SET firstname = ?, lastname = ?, born = ?, county = ?, parish = ?, telnumber = ? WHERE user_id = ?");
			$stmt->bind_param("sssssii", $first, $last, $born, $county, $parish, $number, $id);
			if($stmt->execute()) {

				$success = new StdClass();
				$success->message = "Andmed muudetud!";
				$response->success = $success;

			} else {
				$error = new StdClass();
				$error->id = 0;
				$error->message = "Palun täida kõik väljad!";
				$response->error = $error;
			}
			$stmt->close();
		} else {

			$stmt = $this->connection->prepare("INSERT INTO ntb_personal (user_id, firstname, lastname, born, county, parish, telnumber) VALUES (?,?,?,?,?,?,?)");
			$stmt->bind_param("isssssi", $id, $first, $last, $born, $county, $parish, $number);
			if($stmt->execute()) {

				$success = new StdClass();
				$success->message = "Andmed muudetud!";
				$response->success = $success;

			} else {
				$error = new StdClass();
				$error->id = 1;
				$error->message = "Palun täida kõik väljad!";
				$response->error = $error;
			}
			$stmt->close();

		}
		$_SESSION['response'] = $response;
		header ("Location: profile.php#personal");
		exit();
	}

	function getPersonal($userid) {
		$stmt = $this->connection->prepare("SELECT firstname, lastname, born, county, parish, telnumber FROM ntb_personal WHERE user_id = ?");
		$stmt->bind_param("i", $userid);
		$stmt->bind_result($first, $last, $born, $county, $parish, $telnumber);
		$stmt->execute();
		$personal = new StdClass();
		if($stmt->fetch()) {
			$personal->first = $first;
			$personal->last = $last;
			$personal->born = $born;
			$personal->county = $county;
			$personal->parish = $parish;
			$personal->number = $telnumber;
		} else {
			$personal->first = "";
			$personal->last = "";
			$personal->county = "";
			$personal->parish = "";
			$personal->number = "";
		}
		return ($personal);
		$stmt->close();
	}

	/*Tööotsija lõpp*/

	/*Tööpakkuja*/
	function createCompany($create_company, $create_email, $create_number){
		$response = new StdClass();
		##VÕIMALIK, ET KUSTUTAMISELE
		$stmt = $this->connection->prepare("SELECT name FROM job_company WHERE name=?");
		$stmt->bind_param("s", $create_company);
		$stmt->bind_result($name);
		$stmt->execute();

		if($stmt->fetch()) {

			$error = new StdClass();
			$error->id = 0;
			$error->message = "Selline ettevõte on juba kasutusel!";
			$response->error = $error;

			return $response;
		}

        $stmt = $this->connection->prepare("INSERT INTO job_company (user_id, email, number, name) VALUES (?,?,?,?)");
        $stmt->bind_param("isss", $_SESSION['logged_in_user_id'], $create_email, $create_number, $create_company);
        if($stmt->execute()) {
			$success = new StdClass();
			$success->message = "Ettevõte sisestatud!";
			$response->success = $success;

		} else {
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Oh ei! Paistab, et UFO lõhkus midagi ära!";
			$response->error = $error;
		}
        $stmt->close();
        header("Location: profile.php");
		exit();
		return $response;

    }

	function editCompany($name, $email, $number, $user) {
		$stmt = $this->connection->prepare("SET foreign_key_checks = 0");
		$stmt->execute();

		$stmt = $this->connection->prepare("UPDATE job_company SET name=?, email=?, number=? WHERE name=?");
		$stmt->bind_param("ssis", $name, $email, $number, $user);
		$stmt->execute();

		$stmt = $this->connection->prepare("UPDATE job_offers SET job_offers.company=? WHERE job_offers.company = ?");
		$stmt->bind_param("ss", $name, $user);
		$stmt->execute();

		$stmt = $this->connection->prepare("SET foreign_key_checks = 1");
		$stmt->execute();

		$stmt->close();
		header ("Location: profile.php");
	}

	function companyCheck($user) {
		$stmt = $this->connection->prepare("SELECT user_id, email, number, name FROM job_company WHERE user_id = ?");
		$stmt->bind_param("i", $user);
		$stmt->bind_result($userid, $email, $number, $name);
		$stmt->execute();
		$job = new StdClass();
		if($stmt->fetch()) {
			$job->userid = $userid;
			$job->email = $email;
			$job->number = $number;
			$job->name = $name;
		} else {
			$job->userid = $userid;
			$job->email = "";
			$job->number = "";
			$job->name = "";
		}
		return ($job);
		$stmt->close();
	}



	/*Tööpakkuja lõpp*/
}
?>
