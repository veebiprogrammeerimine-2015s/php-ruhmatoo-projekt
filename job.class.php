<?php
class Job {
	private $connection;
    
    function __construct($mysqli){
        $this->connection = ($mysqli);
    }
	
    function createJob($job_company, $job_name, $job_desc, $job_county, $job_parish, $job_location, $job_address) {
		
		$response = new StdClass();
	
		$stmt = $this->connection->prepare("SELECT id FROM job_offers WHERE name=? AND description=? AND company=? AND address=? AND deleted IS NULL");
		$stmt->bind_param("ssss", $job_name, $job_desc, $job_company, $job_address);
		$stmt->bind_result($id);
		$stmt->execute();
		
		if($stmt->fetch()) {
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Olete juba täpselt samade andmetega töö sisestanud!";
			$response->error = $error;
			
			return $response;
		}
		$stmt->close();
        
        $stmt = $this->connection->prepare("INSERT INTO job_offers (user_id, company, name, description, county, parish, location, address, inserted) VALUES (?,?,?,?,?,?,?,?,NOW())");
        $stmt->bind_param("isssssss", $_SESSION['logged_in_user_id'], $job_company, $job_name, $job_desc, $job_county, $job_parish, $job_location, $job_address);
        
		if($stmt->execute()) {
			$success = new StdClass();
			$success->id = 0;
			$success->message = "Töö on edukalt sisestatud!";
			$response->success = $success;
			
			return $response;
		}
		
        $stmt->close();
        
        

    }
	
	function getAllData($keyword="") {
		if ($keyword == "") {
			$search = "%%";
		}else{
			$search = "%".$keyword."%";
		}

			$stmt = $this->connection->prepare("SELECT id, job_offers.name, description, company, county, parish, location, address, inserted, job_company.email, job_company.number FROM job_offers INNER JOIN job_company ON job_company.name = job_offers.company WHERE deleted IS NULL AND (job_offers.name LIKE ? OR description LIKE ? OR company LIKE ? OR county LIKE ? OR parish LIKE ? OR location LIKE ? OR address LIKE ? OR job_company.email LIKE ?)");
			#echo $this->connection->error;
			$stmt->bind_param("ssssssss", $search, $search, $search, $search, $search, $search, $search, $search);
			$stmt->bind_result($id_from_db, $name_from_db, $desc_from_db, $company_from_db, $county_from_db, $parish_from_db, $location_from_db, $address_from_db, $inserted_from_db, $email_from_db, $number_from_db);
			$stmt->execute();
	
			$array = array();
		//Iga rea kohta teeme midagi
			while($stmt->fetch()) {
				$job = new StdClass();
				$job->id = $id_from_db;
				$job->name = $name_from_db;
				$job->description = $desc_from_db;
				$job->company = $company_from_db;
				$job->county = $county_from_db;
				$job->parish = $parish_from_db;
				$job->location = $location_from_db;
				$job->address = $address_from_db;
				$job->inserted = $inserted_from_db;
				$job->email = $email_from_db;
				$job->number = $number_from_db;
				array_push($array, $job);
		}
			return $array;
			//Saime andmed katte
			echo($name_from_db);
			
		
		$stmt->close();

	}
	
	function getHomeData() {

		$stmt = $this->connection->prepare("SELECT name, company, parish FROM job_offers WHERE deleted IS NULL ORDER BY inserted DESC");
		$stmt->bind_result($name_from_db, $company_from_db, $parish_from_db);
		$stmt->execute();

		$array = array();
		//Iga rea kohta teeme midagi
		while($stmt->fetch()) {
			$job = new StdClass();
			$job->name = $name_from_db;
			$job->company = $company_from_db;
			$job->parish = $parish_from_db;
			array_push($array, $job);
		}
		return $array;
		//Saime andmed katte
		echo($name_from_db);
				
			
		$stmt->close();

	}
	
	function singleJobData($view_id) {
		$stmt = $this->connection->prepare("SELECT name, description, company, county, parish, location, address FROM job_offers WHERE id=? ");
		$stmt->bind_param("i", $view_id);
		$stmt->bind_result($job_name, $job_desc, $job_company, $job_county, $job_parish, $job_location, $job_address);
		$stmt->execute();
		
		if($stmt->fetch()) {
			$job = new StdClass();
			$job->name = $job_name;
			$job->description = $job_desc;
			$job->company = $job_company;
			$job->county = $job_county;
			$job->parish = $job_parish;
			$job->location = $job_location;
			$job->address = $job_address;
		}
		return ($job);
		header("Location: jobs.php");
		$stmt->close();
		
	}
	 
	function deleteJobData($job_id) {

		$stmt = $this->connection->prepare("UPDATE job_offers SET deleted=NOW() WHERE id=? ");
		$stmt->bind_param("i", $job_id);
		$stmt->execute();
		//Tühjendame aadressirea
		header("Location: jobs.php");
		
		$stmt->close();

	}
	
	
	function updateJobData($job_id, $job_name, $job_desc, $job_company, $job_county, $job_parish, $job_location, $job_address) {

		$stmt = $this->connection->prepare("UPDATE job_offers SET name=?, description=?, company=?, county=?, parish=?, location=?, address=? WHERE id=?");
		$stmt->bind_param("sssssssi", $job_name, $job_desc, $job_company, $job_county, $job_parish, $job_location, $job_address, $job_id);
		
		$stmt->execute();
		//Tühjendame aadressirea
		header("Location: jobs.php");
		
		$stmt->close();

	}
	
	function countyDropdown() {
		
		$html = '';
		$html .= '<select name="job_county" class="form-control"">';

		$stmt = $this->connection->prepare("SELECT county FROM job_county");
		$stmt->bind_result($county);
		$stmt->execute();
		while($stmt->fetch()) {
			$html .= '<option value="'.$county.'">'.$county.'</option>';
		}
		
		$stmt->close();
		$html .= '</select>';
		
		return $html;
		
	}
	
	function parishDropdown() {
		
		$html = '';
		$html .= '<select name="job_parish" class="form-control">';

		$stmt = $this->connection->prepare("SELECT parish FROM job_parish");
		$stmt->bind_result($parish);
		$stmt->execute();
		while($stmt->fetch()) {
			$html .= '<option value="'.$parish.'">'.$parish.'</option>';
		}
		
		$stmt->close();
		$html .= '</select>';
		
		return $html;
		
	}
	
	function locationDropdown() {
		$html = '';
		$html .= '<select name="job_location" class="form-control">';

		$stmt = $this->connection->prepare("SELECT location FROM job_location");
		$stmt->bind_result($location);
		$stmt->execute();
		while($stmt->fetch()) {
			$html .= '<option value="'.$location.'">'.$location.'</option>';
		}
		
		$stmt->close();
		$html .= '</select>';
		
		return $html;
		
	}
	
	function companyReadOnly($user) {
		$html = '';
		$stmt = $this->connection->prepare("SELECT name FROM job_company WHERE user_id = ?");
		$stmt->bind_param("i", $user);
		$stmt->bind_result($name);
		$stmt->execute();
		while($stmt->fetch()) {
			$html .= '<input name="job_company" class="form-control" type="text" value="'.$name.'" readonly>';
		}
		
		$stmt->close();
		
		return $html;
		
	}
	
}
?>
