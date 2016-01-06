<<<<<<< HEAD
<?php
class Rate {

	private $connection;

	function __construct($mysqli){
        $this->connection = $mysqli;
    }


	function getProfData($profid) {
		$stmt = $this->connection->prepare("SELECT ratingpro.id, helpful, clarity, examgrade, classrate,
																				professors.firstname, lastname, schools.school FROM ratingpro
																				INNER JOIN professors ON professors.id = ratingpro.profid
																				INNER JOIN schools ON schools.id = professors.school
																				WHERE ratingpro.profid = ?");
		$stmt->bind_param("i", $profid);
		$stmt->bind_result($id, $helpful, $clarity, $exam, $class, $first, $last, $school);
		$stmt->execute();

		$array = array();

		while($stmt->fetch()) {
			$data = new StdClass();
			$personal = new StdClass();
			$data->id = $id;
			$data->help = $helpful;
			$data->clarity = $clarity;
			$data->exam = $exam;
			$data->class = $class;
			array_push($array, $data);
			$personal->first = $first;
			$personal->last = $last;
			$personal->school = $school;

		}
		return array($array, $personal);
		$stmt->close();
	}

	function ratePro($user_id, $prof_id, $help, $clarity, $exam, $class) {
		$response = new StdClass();
		$stmt = $this->connection->prepare("SELECT id FROM ratingpro WHERE userid = ?");
		$stmt->bind_param("i", $user_id);
		$stmt->bind_result($id);
		$stmt->execute();

		if($stmt->fetch()) {

			$error = new StdClass();
			$error->id = 0;
			$error->message = "Oled juba hinnangu andnud!";
			$response->error = $error;

			return $response;
		}

		$stmt->close();
		$stmt = $this->connection->prepare("INSERT INTO ratingpro (userid, profid, helpful, clarity, examgrade, classrate)
																				VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiiii", $user_id, $prof_id, $help, $clarity, $exam, $class);
    if($stmt->execute()) {
      $success = new StdClass();
      $success->message = "Uus hinnang antud!";
      $response->success = $success;
  } else {
      $error = new StdClass();
      $error->id = 1;
      $error->message = "Midagi katki!";
      $response->error = $error;
  }
		return $response;
		$stmt->close();
	}

	function allProfessors($keyword="") {
		if ($keyword == "") {
			$search = "%%";
		}else{
			$search = "%".$keyword."%";
		}

		$stmt = $this->connection->prepare("SELECT professors.id, firstname, lastname, schools.school FROM professors
																				INNER JOIN schools ON schools.id = professors.school
																				WHERE professors.firstname LIKE ? OR lastname LIKE ? OR schools.school LIKE ?");
		$stmt->bind_param("sss", $search, $search, $search);
		$stmt->bind_result($id, $first, $last, $school);
		$stmt->execute();

		$array = array();
		while($stmt->fetch()) {
			$professor = new StdClass();
			$professor->id = $id;
			$professor->first = $first;
			$professor->last = $last;
			$professor->school = $school;
			array_push($array, $professor);
		}
		return ($array);
		$stmt->close();
	}


  function newProfessor($first, $last, $school) {
    $response = new StdClass();
    $stmt = $this->connection->prepare("SELECT id FROM professors WHERE firstname = ? AND lastname = ? AND school = ?");
    $stmt->bind_param("ssi", $first, $last, $school);
    $stmt->bind_result($id);
    $stmt->execute();

    if($stmt->fetch()) {

      $error = new StdClass();
      $error->id = 0;
      $error->message = "Selline õppejõud juba eksisteerib!";
      $response->error = $error;

      return $response;
    }

    $stmt = $this->connection->prepare("INSERT INTO professors (firstname, lastname, school) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $first, $last, $school);
    if($stmt->execute()) {
      $success = new StdClass();
      $success->message = "Uus professor loodud!";
      $response->success = $success;
  } else {
      $error = new StdClass();
      $error->id = 1;
      $error->message = "Midagi katki!";
      $response->error = $error;
  }
		$stmt->close();

		$stmt = $this->connection->prepare("SELECT id FROM professors WHERE firstname = ? AND lastname = ? AND school = ?");
		$stmt->bind_param("ssi", $first, $last, $school);
		$stmt->bind_result($id);
		$stmt->execute();
		if($stmt->fetch()) {
			#Create new file
			$link_file = "../prof/".$id.".php";
			$new_file = fopen($link_file, "w");
			#Create content to new file
			$content = '<?php require_once("../prof/professor.php"); ?>';
			fwrite($new_file, $content);

		}


    return ($response);

    $stmt->close();
  }

  function schoolDropdown() {
    $html = '';
    $html .= '<select name="school" class="form-control">';
    $stmt = $this->connection->prepare("SELECT id, school FROM schools");
    $stmt->bind_result($id, $school);
    $stmt->execute();

    $html .= '<option selected>----</option>';
    while($stmt->fetch()) {
      $html .= '<option value="'.$id.'">'.$school.'</option>';
    }
    $html .= '</select>';
    return $html;
    $stmt->close();
  }

  function newComment($comment){
	$response = new StdClass();
	$stmt = $this->connection->prepare("INSERT INTO procomment (comment) VALUES (?)");
  $stmt->bind_param("s", $comment);
  if($stmt->execute()) {
      $success = new StdClass();
      $success->message = "kommentaar saadetud";
      $response->success = $success;.
  } else {
      $error = new StdClass();
      $error->id = 1;
      $error->message = "kommentaari ei saadetud";
      $response->error = $error;
  }
    return ($response);

    $stmt->close();
  }
}
