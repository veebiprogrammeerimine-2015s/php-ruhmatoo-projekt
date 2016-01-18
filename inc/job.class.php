<?php
class Job {
	private $connection;


    function __construct($mysqli){
        $this->connection = ($mysqli);
    }

	function getAllData($keyword="") {
		if ($keyword == "") {
			$search = "%%";
		}else{
			$search = "%".$keyword."%";
		}

			$stmt = $this->connection->prepare("SELECT id, job_offers.name, description, company, county, parish, location, address, link, inserted, active, job_company.email, job_company.number FROM job_offers INNER JOIN job_company ON job_company.name = job_offers.company WHERE active IS NOT NULL AND deleted IS NULL AND (job_offers.name LIKE ? OR description LIKE ? OR company LIKE ? OR county LIKE ? OR parish LIKE ? OR location LIKE ? OR address LIKE ? OR job_company.email LIKE ?) ORDER BY id");
			#echo $this->connection->error;
			$stmt->bind_param("ssssssss", $search, $search, $search, $search, $search, $search, $search, $search);
			$stmt->bind_result($id_from_db, $name_from_db, $desc_from_db, $company_from_db, $county_from_db, $parish_from_db, $location_from_db, $address_from_db, $link, $inserted_from_db, $active_from_db, $email_from_db, $number_from_db);
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
				$job->link = $link;
				$job->inserted = $inserted_from_db;
				$job->active = $active_from_db;
				$job->email = $email_from_db;
				$job->number = $number_from_db;
				array_push($array, $job);
		}
			return $array;
			//Saime andmed katte
			echo($name_from_db);


		$stmt->close();

	}

	function singleJobData($link) {
		$stmt = $this->connection->prepare("SELECT name, description, company, county, parish, location, address FROM job_offers WHERE link = ? ");
		$stmt->bind_param("s", $link);
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

	function countyDropdown() {

		$html = '';
		$html .= '<select id="countyid" name="job_county" class="form-control">';

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

		$stmt = $this->connection->prepare("SELECT county, parish FROM job_parish");
		$stmt->bind_result($county, $parish);
		$stmt->execute();
		while($stmt->fetch()) {
			$html .= '<option value="'.$parish.'">'.$parish.'</option>';
		}

		$stmt->close();
		$html .= '</select>';

		return $html;

	}

	function companyDropdown() {

		$html = '';
		$html .= '<select name="job_company" class="form-control">';

		$stmt = $this->connection->prepare("SELECT name FROM job_company");
		$stmt->bind_result($company);
		$stmt->execute();
		while($stmt->fetch()) {
			$html .= '<option value="'.$company.'">'.$company.'</option>';
		}

		$stmt->close();
		$html .= '</select>';

		return $html;

	}

	function locationDropdown() {
		$html = '';
		$html .= '<select name="job_location" class="form-control">';

		$stmt = $this->connection->prepare("SELECT parish, location FROM job_location");
		$stmt->bind_result($parish, $location);
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
	####################
	###EMPLOYER START###
	####################

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

				$link = time() + $_SESSION['logged_in_user_id'];
        $stmt = $this->connection->prepare("INSERT INTO job_offers (user_id, company, name, description, county, parish, location, address, link, inserted, active) VALUES (?,?,?,?,?,?,?,?,'$link',NOW(),NOW())");
        $stmt->bind_param("isssssss", $_SESSION['logged_in_user_id'], $job_company, $job_name, $job_desc, $job_county, $job_parish, $job_location, $job_address);

		if($stmt->execute()) {
			$success = new StdClass();
			$success->id = 0;
			$success->message = "Töö on edukalt sisestatud!";
			$response->success = $success;

			#Create new file
			$link_file = "../job/".$link.".php";
			$new_file = fopen($link_file, "w");
			#Create content to new file
			$content = '<?php require_once("../job/sendresume.php"); ?>';
			fwrite($new_file, $content);

			return $response;
		}

        $stmt->close();

    }

	function getMyData($id) {
		$stmt = $this->connection->prepare("SELECT id, job_offers.name, description, company, county, parish, location, address, inserted, active, job_company.email, job_company.number FROM job_offers INNER JOIN job_company ON job_company.name = job_offers.company WHERE job_company.user_id = ? AND deleted IS NULL ORDER BY id");
		#echo $this->connection->error;
		$stmt->bind_param("i", $id);
		$stmt->bind_result($id_from_db, $name_from_db, $desc_from_db, $company_from_db, $county_from_db, $parish_from_db, $location_from_db, $address_from_db, $inserted_from_db, $active_from_db, $email_from_db, $number_from_db);
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
			$job->active = $active_from_db;
			$job->email = $email_from_db;
			$job->number = $number_from_db;
			array_push($array, $job);
	}
		return $array;
		//Saime andmed katte
		echo($name_from_db);


	$stmt->close();

	}

	function updateMyData($job_id, $job_name, $job_company, $job_desc, $job_county, $job_parish, $job_location, $job_address, $user_id) {
		$response = new StdClass();
		$stmt = $this->connection->prepare("UPDATE job_offers INNER JOIN job_company ON job_company.name = job_offers.company SET job_offers.name=?, description=?, company=?, county=?, parish=?, location=?, address=? WHERE id=? AND job_company.user_id=?");
		$stmt->bind_param("sssssssii", $job_name, $job_desc, $job_company, $job_county, $job_parish, $job_location, $job_address, $job_id, $user_id);

		if($stmt->execute()) {
			$success = new StdClass();
			$success->message = "Töökohta edukalt muudetud!";
			$response->success = $success;
		} else {
			$error = new StdClass();
			$error->message = "Midagi läks valesti! Anna teada administraatorile!";
			$response->error = $error;
		}

		$_SESSION['response'] = $response;
		header("Location: myjobs.php");
		exit();

		$stmt->close();

	}

	function deleteMyData($job_id, $user_id) {

		$stmt = $this->connection->prepare("UPDATE job_offers INNER JOIN job_company ON job_company.name = job_offers.company SET job_offers.deleted=NOW() WHERE id=? AND job_company.user_id=?");
		$stmt->bind_param("ii", $job_id, $user_id);
		if($stmt->execute()) {
			$success = new StdClass();
			$success->message = "Töökohta edukalt kustutatud!";
			$response->success = $success;
		} else {
			$error = new StdClass();
			$error->message = "Midagi läks valesti! Anna teada administraatorile!";
			$response->error = $error;
		}

		$_SESSION['response'] = $response;
		header("Location: myjobs.php");
		exit();

		$stmt->close();

	}

	function activateMyData($job_id, $user_id) {

		$stmt = $this->connection->prepare("UPDATE job_offers INNER JOIN job_company ON job_company.name = job_offers.company SET job_offers.active=NOW() WHERE job_offers.id=? AND job_company.user_id=?");
		$stmt->bind_param("ii", $job_id, $user_id);

		if($stmt->execute()) {
			$success = new StdClass();
			$success->message = "Töökohta muudetud aktiivseks!";
			$response->success = $success;
		} else {
			$error = new StdClass();
			$error->message = "Midagi läks valesti! Anna teada administraatorile!";
			$response->error = $error;
		}

		$_SESSION['response'] = $response;
		header("Location: myjobs.php");
		exit();

		$stmt->close();

	}

	function deactivateMyData($job_id, $user_id) {

		$stmt = $this->connection->prepare("UPDATE job_offers INNER JOIN job_company ON job_company.name = job_offers.company SET job_offers.active=NULL WHERE job_offers.id=? AND job_company.user_id=?");
		$stmt->bind_param("ii", $job_id, $user_id);

		if($stmt->execute()) {
			$success = new StdClass();
			$success->message = "Töökohta muudetud ebaaktiivseks!";
			$response->success = $success;
		} else {
			$error = new StdClass();
			$error->message = "Midagi läks valesti! Anna teada administraatorile!";
			$response->error = $error;
		}

		$_SESSION['response'] = $response;
		header("Location: myjobs.php");
		exit();

		$stmt->close();

	}

	####################
	####EMPLOYER END####
	####################

	#####################
	####EDITJOBS START###
	#####################

	function getAdminData() {
		$stmt = $this->connection->prepare("SELECT id, job_offers.name, description, company, county, parish, location, address, inserted, active, job_company.email, job_company.number FROM job_offers INNER JOIN job_company ON job_company.name = job_offers.company WHERE deleted IS NULL ORDER BY id");
		#echo $this->connection->error;
		$stmt->bind_result($id_from_db, $name_from_db, $desc_from_db, $company_from_db, $county_from_db, $parish_from_db, $location_from_db, $address_from_db, $inserted_from_db, $active_from_db, $email_from_db, $number_from_db);
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
			$job->active = $active_from_db;
			$job->email = $email_from_db;
			$job->number = $number_from_db;
			array_push($array, $job);
	}
		return $array;
		//Saime andmed katte
		echo($name_from_db);


	$stmt->close();

	}

	function deleteJobData($job_id) {

		$stmt = $this->connection->prepare("UPDATE job_offers SET deleted=NOW() WHERE id=? ");
		$stmt->bind_param("i", $job_id);
		$stmt->execute();
		//Tühjendame aadressirea
		header("Location: editjobs.php");

		$stmt->close();

	}

	function updateJobData($job_id, $job_name, $job_company, $job_desc, $job_county, $job_parish, $job_location, $job_address) {

		$stmt = $this->connection->prepare("UPDATE job_offers SET name=?, description=?, company=?, county=?, parish=?, location=?, address=? WHERE id=?");
		$stmt->bind_param("sssssssi", $job_name, $job_desc, $job_company, $job_county, $job_parish, $job_location, $job_address, $job_id);

		$stmt->execute();
		//Tühjendame aadressirea
		header("Location: editjobs.php");

		$stmt->close();

	}

	function activateData($job_id) {

		$stmt = $this->connection->prepare("UPDATE job_offers INNER JOIN job_company ON job_company.name = job_offers.company SET job_offers.active=NOW() WHERE job_offers.id=?");
		$stmt->bind_param("i", $job_id);

		$stmt->execute();
		header("Location: editjobs.php");

		$stmt->close();

	}

	function deactivateData($job_id) {

		$stmt = $this->connection->prepare("UPDATE job_offers INNER JOIN job_company ON job_company.name = job_offers.company SET job_offers.active=NULL WHERE job_offers.id=?");
		$stmt->bind_param("i", $job_id);

		$stmt->execute();
		header("Location: editjobs.php");

		$stmt->close();

	}

	function editCompanyDropdown($id) {
		$html = '';
		$html .= '<select name="job_company" class="form-control">';
		$stmt = $this->connection->prepare("(SELECT company FROM job_offers WHERE id=?) UNION (SELECT name FROM job_company)");
		$stmt->bind_param("i", $id);
		$stmt->bind_result($company);
		$stmt->execute();
		while($stmt->fetch()) {
			$html .= '<option value="'.$company.'">'.$company.'</option>';
		}

		$stmt->close();
		$html .= '</select>';

		return $html;
	}

	function editCountyDropdown($id) {
		$html = '';
		$html .= '<select id="countyid" name="job_county" class="form-control">';
		$stmt = $this->connection->prepare("(SELECT county FROM job_offers WHERE id=?) UNION (SELECT county FROM job_county)");
		$stmt->bind_param("i", $id);
		$stmt->bind_result($county);
		$stmt->execute();
		while($stmt->fetch()) {
			$html .= '<option value="'.$county.'">'.$county.'</option>';
		}

		$stmt->close();
		$html .= '</select>';

		return $html;
	}

	function editParishDropdown($id) {
		$html = '';
		$html .= '<select name="job_parish" class="form-control">';
		$stmt = $this->connection->prepare("(SELECT parish FROM job_offers WHERE id=?) UNION (SELECT parish FROM job_parish)");
		$stmt->bind_param("i", $id);
		$stmt->bind_result($parish);
		$stmt->execute();
		while($stmt->fetch()) {
			$html .= '<option value="'.$parish.'">'.$parish.'</option>';
		}

		$stmt->close();
		$html .= '</select>';

		return $html;
	}

	function editLocationDropdown($id) {
		$html = '';
		$html .= '<select name="job_location" class="form-control">';
		$stmt = $this->connection->prepare("(SELECT location FROM job_offers WHERE id=?) UNION (SELECT location FROM job_location)");
		$stmt->bind_param("i", $id);
		$stmt->bind_result($location);
		$stmt->execute();
		while($stmt->fetch()) {
			$html .= '<option value="'.$location.'">'.$location.'</option>';
		}

		$stmt->close();
		$html .= '</select>';

		return $html;
	}


	#####################
	#####EDITJOBS END####
	#####################

	################
	###TEST START###
	################



	function countyDropdown2() {

		$html = '';
		$html .= '<select id="countyid2" name="job_county" class="form-control">';

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

	function parishDrop() {
		$stmt = $this->connection->prepare("SELECT county, parish FROM job_parish");
		$stmt->bind_result($county, $parish);
		$stmt->execute();

		if($stmt->fetch()) {
			echo $county;
		}

		$stmt->close();
	}


	function parishDrop2() {
		$stmt = $this->connection->prepare("SELECT county, parish FROM job_parish");
		$stmt->bind_result($county, $parish);
		$stmt->execute();

		$return_array = array();

		$array = array();
		//Iga rea kohta teeme midagi
		while($stmt->fetch()) {

				//if(count($array))

				$county_exists = false;

				for($i = 0; $i < count($array); $i++){

					if($array[$i]->county == $county){

						array_push($array[$i]->parish, $parish);
						$county_exists = true;

						//end;
					}

				}

				if($county_exists == false){
					$dropdown = new StdClass();
					$dropdown->county = $county;
					$dropdown->parish = [];
					array_push($dropdown->parish, $parish);
					array_push($array, $dropdown);
				}


		}

		$return_array[0] = $array;
			//return

		$stmt->close();

		$stmt = $this->connection->prepare("SELECT county, parish, location FROM job_location");
		$stmt->bind_result($county, $parish, $location);
		$stmt->execute();

		$array_loc = array();
		//Iga rea kohta teeme midagi
		while($stmt->fetch()) {

				//if(count($array))

				$location_exists = false;

				for($i = 0; $i < count($array_loc); $i++){

					if($array_loc[$i]->parish == $parish){

						array_push($array_loc[$i]->location, $location);
						$location_exists = true;

						//end;
					}

				}

				if($location_exists == false){
					$dropdown = new StdClass();
					$dropdown->parish = $parish;
					$dropdown->location = [];
					array_push($dropdown->location, $location);
					array_push($array_loc, $dropdown);
				}


		}

		$return_array[1] = $array_loc;

		return $return_array ;

	}


	function jobLocation($id) {
		$stmt = $this->connection->prepare("SELECT county, parish, location FROM job_offers WHERE id = ?");
		$stmt->bind_param("i", $id);
		$stmt->bind_result($county, $parish, $location);
		$stmt->execute();



		$array = array();
		//Iga rea kohta teeme midagi
		while($stmt->fetch()) {

				$dropdown = new StdClass();
				$dropdown->county = $county;
				$dropdown->parish = $parish;
				$dropdown->location = $location;
				array_push($array, $dropdown);

		}



		return $array ;
	}

	#################
	####TEST END####
	#################
}
?>
