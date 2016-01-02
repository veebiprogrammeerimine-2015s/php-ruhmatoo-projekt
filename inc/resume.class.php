<?php
  class Resume {

    private $connection;
    public $url;

    function __construct($mysqli, $myurl){
        $this->connection = $mysqli;
        $this->url = $myurl;
    }

    function getResumes($userid) {
      $stmt = $this->connection->prepare("SELECT id, name, link, inserted FROM ntb_resumes WHERE user_id = ?");
      $stmt->bind_param("i", $userid);
  		$stmt->bind_result($id, $name, $link, $inserted);
  		$stmt->execute();

  		$array = array();

  		while($stmt->fetch()) {
  			$my_resume = new StdClass();
  			$my_resume->id = $id;
  			$my_resume->name = $name;
  			$my_resume->link = $link;
  			$my_resume->inserted = $inserted;

  			array_push($array, $my_resume);
  	}
  		return $array;
  		$stmt->close();
    }

    function newResume($userid, $name, $link) {

      $stmt = $this->connection->prepare("INSERT INTO ntb_resumes (user_id, name, link, inserted) VALUES (?, ?, ?, NOW())");
      $stmt->bind_param("iss", $userid, $name, $link);
      if ($stmt->execute()) {
        #Create new file
        $link_file = "../edit/".$link.".php";
        $new_file = fopen($link_file, "w");
        #Create content to new file
        $content = '<?php include("editresume.php"); ?>';
        fwrite($new_file, $content);
        header("Location: ".$link_file);
        exit();
      }
      $stmt->close();

    }

    function thisResume($link) {
      $stmt = $this->connection->prepare("SELECT id, name FROM ntb_resumes WHERE link = '$link'");
      #$stmt->bind_param("s", $link);
      $stmt->bind_result($id, $name);
      $stmt->execute();
      $thisResume = new StdClass();

      while($stmt->fetch()) {
        $thisResume = new StdClass();
        $thisResume->id = $id;
        $thisResume->name = $name;
    }
      return ($thisResume);
      $stmt->close();
    }


    function newPrimary($cvid, $school, $start, $end, $info) {
      $stmt = $this->connection->prepare("INSERT INTO ntb_schools (resume_id, school, type, info, start, endtime) VALUES (?, ?, 1, ?, ?, ?)");
      $stmt->bind_param("issii", $cvid, $school, $info, $start, $end);
      $stmt->execute();
      $stmt->close();
    }



  }
?>
