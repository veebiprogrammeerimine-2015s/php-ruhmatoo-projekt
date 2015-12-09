<?php
	class UserBookingManager{
		
		function __construct($mysqli){
		
			// selle klassi muutuja andmete saamiseks
			$this->connection = $mysqli;
			
		
		}
		
		// kasutaja sisselogimise kontroll, enne bookingu tegemist
		function checkUserLogedIn(){
			$response = new StdClass();
			
			if(!isset($_SESSION["id_from_db"])){
				//var_dump($_SESSION["id_from_db"]);
				$error = new StdClass();
				$error->id =1;
				$error->message = "Broneerimiseks, tuleb enne sisse logida!";
				$response->error = $error;		
				
			}
			return $response;
		}
		
		function checkTimeStatus($available_time_id){
			$response = new StdClass();
			
			//kas selline aeg äkki juba broneeritud on juba olemas?
				$stmt = $this->connection->prepare("SELECT af_booking_statuses_id FROM af_doctor_available WHERE id  = ?");
				$stmt->bind_param("s", $available_time_id);
				$stmt->bind_result($status_id);
				$stmt->execute();
				
				if($stmt->fetch()){
					if($status_id !=1){
						$error = new StdClass();
						$error->id = 0;
						$error->message = "Teie valitud aeg broneeriti ära vahepeal";
						$response->error = $error;
						return $response;
					}
				}
				$stmt->close();
				
				return $response;
		}
		
    	
    	function insertBooking($avialable_time_id, $person_id_in, $desease_id_in, $problem_in = "----"){
    	
    		$created = $updated = date('Y-m-d H:i:s');
			$response = new StdClass();
			
			//kas selline selline broneering juba olemas äkki ?
			$stmt = $this->connection->prepare("
			SELECT id FROM `af_bookings` WHERE af_doctor_available_id = ? AND (af_booking_statuses_id = 2 OR af_booking_statuses_id = 4)
			");
			$stmt->bind_param("i", $avialable_time_id);
			$stmt->execute();
			if($stmt->fetch()){
				$error = new StdClass();
				$error->id = 0;
				$error->message = "Sellele ajale on tehtud vahepeal broneering";
				$response->error = $error;
				$stmt->close();
				
				
				$stmt2 = $this->connection->prepare("
				UPDATE `af_doctor_available` SET `af_booking_statuses_id` = '2' WHERE `af_doctor_available`.`id` = ?
				");
				$stmt2->bind_param("i",  $avialable_time_id);
			
				if($stmt2->execute()){
					$success = new StdClass();
					$success->message2 = "Ajatabelis ka staatus muudetd";
					$response->success2 = $success;
					$stmt2->close();
				}
				
				return $response;
				
			}
			
			
			
			
			
			
			$stmt = $this->connection->prepare("
			INSERT INTO `af_bookings` 
			( `af_persons_id`, `af_doctor_available_id`, `af_doctors_deseaes_id`, `af_booking_statuses_id`, `problem_descr`, `created`, `updated`) 
			VALUES (? , ? ,  ?, 2, ?, ?, ?)
			");
			$stmt->bind_param("iiisss", $person_id_in, $avialable_time_id, $desease_id_in, $problem_in, $created, $updated);
			
			if($stmt->execute()){
				$success = new StdClass();
				$success->message = "Broneering edukalt salvestatud";
				$response->success = $success;
			}else{
				$error = new StdClass();
				$error->id =1;
				$error->message = "Midagi broneeringu lisamisel katki!";
				$response->error = $error;
			}
			
			$stmt->close();
			
			//märgime availabe time staatuse broneerituks staatus tuleb 2
			if($response->success){
				
				$stmt = $this->connection->prepare("
				UPDATE `af_doctor_available` SET `af_booking_statuses_id` = '2' WHERE `af_doctor_available`.`id` = ?
				");
				$stmt->bind_param("i",  $avialable_time_id);
			
				if($stmt->execute()){
					$success = new StdClass();
					$success->message2 = "aja staatus edukalt broneeritud";
					$response->success2 = $success;
					$stmt->close();
				}
				else{
					$error = new StdClass();
					$error->id =2;
					$error->message = "Aja staatust ei uuendatud";
					$response->error2 = $error;
					$stmt->close();
						
				}
				

			
			}
			
			
			return $response;
    	
    	
    	
    	}

    	
		
}
?>