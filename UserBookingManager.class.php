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
		
		
		// kontrollime kas on aja i-ga bookinguid mille staatus 2
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
		
		function getBookingUser($available_time_id){
			
	
			//kas selline aeg äkki juba broneeritud on juba olemas?
				$stmt = $this->connection->prepare("SELECT af_persons_id FROM af_bookings WHERE af_doctor_available_id = ?");
				$stmt->bind_param("i", $available_time_id);
				$stmt->bind_result($id_fdb);
				$stmt->execute();
				
				if($stmt->fetch()){
					$booking_user_id = $id_fdb;
				}
				$stmt->close();
				
				return $booking_user_id;
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
		
		// kinnita vormile luuakse kinnita nupp
		
		function buildConfirmButton(){
			
			$html = '<input type="submit" name="confirm-now" value="Kinnita broneering">';
			return $html;
			
		}    	
		
		// tyhista nupu loomine
		function buildCancelButton(){
			
			$html = '<input type="submit" name="cancel-booking" value="Tühista broneering">';
			return $html;
			
		}
		// broneeringu tühistamine
		function cancelBooking($booking_id){
    		var_dump($booking_id);
    		$updated = date('Y-m-d H:i:s');
			$response = new StdClass();
			
			//bron id järgi leiame bookingu ?
			$stmt = $this->connection->prepare("
			UPDATE af_bookings SET `af_booking_statuses_id` = 3, `updated` = ? WHERE id = ?
			");
			$stmt->bind_param("si", $updated, $booking_id);
			
			if($stmt->execute()){
				$error = new StdClass();
				$error->id = 0;
				$error->message = "Broneering tühistatud";
				$response->success = $error;
				
				$stmt->close();
				
				
				$stmt2 = $this->connection->prepare("
				UPDATE `af_doctor_available` SET `af_booking_statuses_id` = '1' WHERE `af_doctor_available`.`id` = (SELECT af_doctor_available_id FROM `af_bookings` WHERE id  = ?) 
				");
				$stmt2->bind_param("i",  $booking_id);
				
				if($stmt2->execute()){
					$success = new StdClass();
					$success->message2 = "Ajatabelis ka staatus vabaks";
					$response->success2 = $success;
					$stmt2->close();
				}
				
				return $response;
				
			}
		}
		
			function getMyUpComingBookings($person_id){
			
			$city = "%".$city_in."%";
			$area = "%".$area_in."%";
			$desease = "%".$desease_in."%";
			
			$table_data = array();
			$html = '';
			$stmt = $this->connection->prepare("
			select af_bookings.id, date_appoitmnt, time_start, time_end, desease, booking_status from af_bookings
			JOIN af_doctor_available ON af_doctor_available.id = af_bookings.af_doctor_available_id
			JOIN af_deseases ON af_deseases.id = af_bookings.af_doctors_deseaes_id
			JOIN af_booking_statuses ON af_booking_statuses.id = af_bookings.af_booking_statuses_id
			WHERE af_bookings.af_persons_id = ?
			");
			$stmt->bind_param("i", $person_id);
			$stmt->bind_result($id, $date_appoitmnt, $time_start, $time_end, $desease, $booking_status);
			$stmt->execute();
			
			while($stmt->fetch()){
				
				$table_row = new StdClass();
				$table_row->date_appoitmnt = $date_appoitmnt;
				$table_row->time_start = $time_start;
				$table_row->desease = $desease;
				$table_row->booking_status = $booking_status;
				$table_row->book = "<a href=my-booking-details.php?bookingid=".$id.">vaata</a>";
				array_push($table_data, $table_row);
				
				
			}
			
			$stmt->close();
			return $table_data;
		}
		
		function getBookingDetails($booking_id, $person_id){
			
			$city = "%".$city_in."%";
			$area = "%".$area_in."%";
			$desease = "%".$desease_in."%";
			
			$table_data = array();
			$html = '';
			$stmt = $this->connection->prepare("
			SELECT af_bookings.id, date_appoitmnt, time_start, time_end, desease, booking_status, problem_descr, dr_name, city, area, address FROM af_bookings
			JOIN af_doctor_available ON af_doctor_available.id = af_bookings.af_doctor_available_id
			JOIN af_deseases ON af_deseases.id = af_bookings.af_doctors_deseaes_id
			JOIN af_booking_statuses ON af_booking_statuses.id = af_bookings.af_booking_statuses_id
            JOIN af_doctors ON af_doctors.id = af_doctor_available.af_doctors_id
            JOIN af_hospidals ON af_hospidals.id = af_doctors.af_hospidals_id
			WHERE af_bookings.af_persons_id = ? AND af_bookings.id = ?
			");
			$stmt->bind_param("ii", $person_id, $booking_id);
			$stmt->bind_result($id, $date_appoitmnt, $time_start, $time_end, $desease, $booking_status, $problem_descr, $dr_name, $city_fdb, $area_fdb, $address_fdb );
			$stmt->execute();
			
			while($stmt->fetch()){
				
				$table_row = new StdClass();
				$table_row->date_appoitmnt = $date_appoitmnt;
				$table_row->time_start = $time_start;
				$table_row->time_end = $time_end;
				$table_row->desease = $desease;
				$table_row->booking_status = $booking_status;
				$table_row->problem_descr = $problem_descr;
				$table_row->city = $city_fdb;
				$table_row->area = $area_fdb;
				$table_row->address = $address_fdb;
				$table_row->dr_name = $dr_name;
				array_push($table_data, $table_row);
				
				
			}
			
			$stmt->close();
			return $table_data;
		}
		
		// üks funktsioon tabeli printimiseks
		// kood laenatud http://stackoverflow.com/questions/4746079/how-to-create-a-html-table-from-a-php-array
		function build_table($array){
			// start table
   			 $html = '<table class="table table-bordered">';
    		// header row
    		$html .= '<tr>';
    		foreach($array[0] as $key=>$value){
            	$html .= '<th>' . $key . '</th>';
        	}
    		$html .= '</tr>';

    		// data rows
    		foreach( $array as $key=>$value){
        	$html .= '<tr>';
        	foreach($value as $key2=>$value2){
            	$html .= '<td>' . $value2 . '</td>';
        	}
        	$html .= '</tr>';
    	}

    	// finish table and return it

    	$html .= '</table>';
    	return $html;
		}
		
		
}
?>