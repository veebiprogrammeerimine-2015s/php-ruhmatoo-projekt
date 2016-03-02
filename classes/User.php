<?php
class User {

	private $_db;

	function __construct(PDO $db){

		$this->_db = $db;

	}

	function createUser($create_email, $password_hash) {

		$response = new StdClass();
		$stmt = $this->_db->prepare("SELECT email FROM user WHERE email = ?");
		$stmt->bindParam(1, $create_email, PDO::PARAM_STR);
		$stmt->execute();

		if($stmt->fetch()) {

			$error = new StdClass();
			$error->message = "Sellise e-postiga kasutaja juba olemas!";

			$response->error = $error;

			return $response;

		}

		$stmt = $this->_db->prepare("INSERT INTO user (email, password) VALUES (?, ?)");
		$stmt->bindParam(1, $create_email, PDO::PARAM_STR, 64);
		$stmt->bindParam(2, $password_hash, PDO::PARAM_STR, 512);

		if($stmt->execute()) {

			$success = new StdClass();
			$success->message = "Kasutaja edukalt salvestatud";

			$response->success = $success;

		} else {

			$error = new StdClass();
			$error->message = "Ei saanud kasutajat sisestada";

			$response->error = $error;

		}

		return $response;

	}

	function loginUser($email, $password_hash) {

		$response = new StdClass();
		$stmt = $this->_db->prepare("SELECT email FROM user WHERE email = ?");
		$stmt->bindParam(1, $email, PDO::PARAM_STR, 64);
		$stmt->execute();

		if(!$stmt->fetch()) {

			$error = new StdClass();
			$error->message = "Sellise e-postiga kasutajat ei ole olemas!";

			$response->error = $error;

			return $response;

		}

		$stmt = $this->_db->prepare("SELECT id, email, admin FROM user WHERE email=? AND password=?");
		$stmt->bindParam(1, $email, PDO::PARAM_STR, 64);
		$stmt->bindParam(2, $password_hash, PDO::PARAM_STR, 512);
		$stmt->bindColumn('id', $id_from_db);
		$stmt->bindColumn('email', $email_from_db);
		$stmt->bindColumn('admin', $isAdmin);
		$stmt->execute();

		if($stmt->fetch()) {

			$success = new StdClass();
			$success->message = "Kasutaja edukalt sisse logitud";

			$user = new StdClass();
			$user->id = $id_from_db;
			$user->email = $email_from_db;
			$user->admin = $isAdmin;

			$success->user = $user;

			$response->success = $success;

		} else {

			$error = new StdClass();
			$error->message = "Vale parool!";

			$response->error = $error;

		}

		return $response;
	}

} ?>
