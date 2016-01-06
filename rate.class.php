<<<<<<< HEAD
<?php

class Rate {

	private $connection;

	function __construct($mysqli){
        $this->connection = $mysqli;
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
      $success->message = "Uus professor loodud";
      $response->success = $success;
  } else {
      $error = new StdClass();
      $error->id = 1;
      $error->message = "Uus professor loodud";
      $response->error = $error;
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
	
  function newComment($comment){
	$response = new StdClass();
	$stmt = $this->connection->prepare("INSERT INTO procomment (comment) VALUES (?)");
    $stmt->bind_param("s", $comment);
    if($stmt->execute()) {
      $success = new StdClass();
      $success->message = "kommentaar saadetud";
      $response->success = $success;
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
  
	
	//insert into
	$comment_error = "";
	if($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST["submit"]))}
	
      if (empty($_POST["comment"]) ) {
        $comment_error = "See väli on kohustuslik";
      }else{
        $comment = cleanInput($_POST["comment"]);
      }
	  
	  
?>
=======
<?php
class Rate {

	private $connection;

	function __construct($mysqli){
        $this->connection = $mysqli;
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



  }

  ?>
>>>>>>> 101924f09219f979828a577844c59742237cc5c3
