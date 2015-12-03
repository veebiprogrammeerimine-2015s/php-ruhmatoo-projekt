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
		
		
		function buildMainError($message){
			
   			
    		
    		$html = '<div class="alert alert-warning">';
    		$html .= '<strong>Warning!</strong>'.$message;
    		$html .= '</div>';
    		
    		return $html;
    	}

    	
		
}
?>