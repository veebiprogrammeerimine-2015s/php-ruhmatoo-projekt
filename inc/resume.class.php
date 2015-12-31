<?php
  class Resume {
  	private $connection;

      function __construct($mysqli){
          $this->connection = $mysqli;
      }

      function newResume($userid, $name, $link) {

        $stmt = $this->connection->prepare("INSERT INTO ntb_resumes (user_id, name, link, inserted) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $userid, $name, $link);
        if ($stmt->execute()) {
          #Create new file
          $link_file = "edit/".$link.".php";
          $new_file = fopen($link_file, "w");
          #Create content to new file
          $content = '<?php include("../editresume.php"); ?>';
          fwrite($new_file, $content);
          header("Location: ".$link_file);
          exit();
        }
        $stmt->close();

      }

      function thisResume($link) {
        $stmt = $this->connection->prepare("SELECT id FROM ntb_resumes WHERE link = ?");
        $stmt->bind_param("s", $link);
        $stmt->bind_result($resume_id);
        $stmt->execute();
        if ($stmt->fetch()) {
          $resume = new StdClass();
          $resume->id = $resume_id;
        }
        return ($resume);
        $stmt->close();
      }

      function newPrimary($school, $start, $end, $info) {
        $stmt = $this->connection->prepare("INSERT INTO ntb_schools (resume_id, school, type, info, start, endtime) VALUES (?, ?, 1, ?, ?, ?)");
        $stmt->bind_param("issii", $resume->id, $school, $info, $start, $end);
        $stmt->execute();
        $stmt->close();
      }



  }
?>
