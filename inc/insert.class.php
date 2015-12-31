<?php
class Insert {
	private $connection;
	
	function __construct($mysqli){
        $this->connection = ($mysqli);
    }
	
	function insertCounty($job_county) {
		
		$response = new StdClass();
		
        $stmt = $this->connection->prepare("SELECT county FROM job_county WHERE county = ?");
        $stmt->bind_param("s", $job_county);
		$stmt->bind_result($county);
		$stmt->execute();
		
		if($stmt->fetch()) {
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Maakond on juba olemas!";
			$response->error = $error;
			
			return $response;
		}
		$stmt->close();
		
        $stmt = $this->connection->prepare("INSERT INTO job_county (county) VALUES (?)");
        $stmt->bind_param("s", $job_county);
        
		if($stmt->execute()) {
			$success = new StdClass();
			$success->id = 0;
			$success->message = "Maakond on edukalt sisestatud!";
			$response->success = $success;
			
			return $response;
		}

        $stmt->close();
		
    }
	
	function insertParish($job_county, $job_parish) {
		
		$response = new StdClass();
		
		$stmt = $this->connection->prepare("SELECT county, parish FROM job_parish WHERE county = ? AND parish = ?");
        $stmt->bind_param("ss", $job_county, $job_parish);
		$stmt->bind_result($county, $parish);
		$stmt->execute();
		
		if($stmt->fetch()) {
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Vald on juba olemas!";
			$response->error = $error;
			
			return $response;
		}
		$stmt->close();
	
        $stmt = $this->connection->prepare("INSERT INTO job_parish (county, parish) VALUES (?,?)");
        $stmt->bind_param("ss", $job_county, $job_parish);
        
		if($stmt->execute()) {
			$success = new StdClass();
			$success->id = 0;
			$success->message = "Vald on edukalt sisestatud!";
			$response->success = $success;
			
			return $response;
		} else {
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Vald on unikaalne ning on juba olemas!";
			$response->error = $error;
			
			return $response;
		}

        $stmt->close();
		
    }
	
	function insertLocation($job_county, $job_parish, $job_location) {
		
		$response = new StdClass();
		
		$stmt = $this->connection->prepare("SELECT county, parish, location FROM job_location WHERE county = ? AND parish = ? AND location = ?");
        $stmt->bind_param("sss", $job_county, $job_parish, $job_location);
		$stmt->bind_result($county, $parish, $location);
		$stmt->execute();
		
		if($stmt->fetch()) {
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Asula on juba olemas!";
			$response->error = $error;
			
			return $response;
		}
		$stmt->close();
	
        $stmt = $this->connection->prepare("INSERT INTO job_location (county, parish, location) VALUES (?,?,?)");
        $stmt->bind_param("sss", $job_county, $job_parish, $job_location);
        
		if($stmt->execute()) {
			$success = new StdClass();
			$success->id = 0;
			$success->message = "Asula on edukalt sisestatud!";
			$response->success = $success;
			
			return $response;
		} else {
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Asula on unikaalne ning on juba olemas!<br>Sisesta sulgudesse vald!";
			$response->error = $error;
			
			return $response;
		}

        $stmt->close();
		
    }
	

	
}
?>