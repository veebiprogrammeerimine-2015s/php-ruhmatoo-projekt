<?php
class Admin {
	private $connection;

    function __construct($mysqli){
        $this->connection = $mysqli;
    }

	function getCompanies() {
		$stmt = $this->connection->prepare("SELECT ntb_users.email, job_company.name, job_company.email, job_company.number FROM job_company JOIN ntb_users ON ntb_users.id = job_company.user_id");
		$stmt->bind_result($user, $name, $email, $number);
		$stmt->execute();

		$array = array();
		while($stmt->fetch()) {
			$company = new StdClass();
			$company->user = $user;
			$company->company = $name;
			$company->email = $email;
			$company->number = $number;
			array_push($array, $company);
		}
		return $array;

		$stmt->close();
	}

	function updateCompany($company, $email, $number, $old_company) {
		$stmt = $this->connection->prepare("SET foreign_key_checks = 0");
		$stmt->execute();

		$stmt = $this->connection->prepare("UPDATE job_company SET name=?, email=?, number=? WHERE name=?");
		$stmt->bind_param("ssis", $company, $email, $number, $old_company);
		$stmt->execute();

		$stmt = $this->connection->prepare("UPDATE job_offers SET company=? WHERE company=?");
		$stmt->bind_param("ss", $company, $old_company);
		$stmt->execute();

		$stmt = $this->connection->prepare("SET foreign_key_checks = 1");
		$stmt->execute();

		header("Location: companies.php");
		$stmt->close();

	}

	function getUsers() {
		$stmt = $this->connection->prepare("SELECT id, email, usergroup, resume, created FROM ntb_users");
		$stmt->bind_result($id, $email, $usergroup, $resume, $created);
		$stmt->execute();

		$array = array();
		while($stmt->fetch()) {
			$user = new StdClass();
			$user->id = $id;
			$user->email = $email;
			$user->usergroup = $usergroup;
			$user->cv = $resume;
			$user->created = $created;
			array_push($array, $user);
		 }
		return $array;

	}

	function updateUser($id, $email, $usergroup) {
		$stmt = $this->connection->prepare("UPDATE ntb_users SET email = ?, usergroup = ? WHERE id = ?");
		$stmt->bind_param("sii", $email, $usergroup, $id);
		$stmt->execute();

		header("Location: users.php");
		$stmt->close();

	}


}
?>
