<?php
	class AvailableTimes{
		
		function __construct($mysqli){
		
			// selle klassi muutuja andmete saamiseks
			$this->connection = $mysqli;
			
		
		}
		
		
		function getAllFreeTimes(){
			
			
			
			$html = '';
			$stmt = $this->connection->prepare("
			SELECT date_appoitmnt, time_start, time_end FROM `af_doctor_available` WHERE af_booking_statuses_id = 1 	
			");
			$stmt->bind_result($date_appoitmnt, $time_start, $time_end);
			$stmt->execute();
		
			while($stmt->fetch()){
				$html .= $date_appoitmnt." ".$time_start." ".$time_end;
			}
			
			$stmt->close();
		
			return $html;
		}
	

}
?>