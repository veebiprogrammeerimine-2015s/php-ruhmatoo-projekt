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
				$stmt = $this->connection->prepare("SELECT af_booking_statuses_id FROM `af_doctor_available` WHERE id = ?");
				$stmt->bind_param("i", $available_time_id);
				$stmt->bind_result($staatus_id);
				$stmt->execute();
				if($staatus_id !=1){
					$error = new StdClass();
					$error->id = 0;
					$error->message = "Teie valitud aeg broneeriti ära vahepeal";
					$response->error = $error;
					return $response;
				}
				$stmt->close();
				return $response;
		}
		
		
		function buildMainError($message){
			
   			
    		
    		$html = '<div class="alert alert-warning">';
    		$html .= '<strong>Warning!</strong>'.$message;
    		$html .= '</div>';
    		
    		return $html;
    	}

    	
		
}
?>