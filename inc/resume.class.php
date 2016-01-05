<?php
  class Resume {

    private $connection;
    public $url;

    function __construct($mysqli, $myurl){
        $this->connection = $mysqli;
        $this->url = $myurl;
    }

    ########################
    ### Employee resumes ###
    ########################

    function getSentResumes($user) {
      $stmt = $this->connection->prepare("SELECT got_cv.id, answer_types.answer, got_cv.sent_time, job_offers.name, ntb_personal.firstname, ntb_personal.lastname FROM got_cv
                                          INNER JOIN job_offers ON job_offers.id = got_cv.job_id
                                          INNER JOIN ntb_personal ON ntb_personal.id = got_cv.sender_id
                                          INNER JOIN answer_types ON answer_types.id = got_cv.answer_type
                                          WHERE job_offers.user_id = ? ORDER BY got_cv.sent_time DESC");
      $stmt->bind_param("i", $user);
      $stmt->bind_result($id, $answer, $sent_time, $job_name, $send_first, $send_last);
      $stmt->execute();



      $array = array();
      if($stmt->fetch()) {
        $job = new StdClass();
        $job->id = $id;
        $job->job = $job_name;
        $job->first = $send_first;
        $job->last = $send_last;
        $job->answer = $answer;
        $job->time = $sent_time;
        array_push($array, $job);
      }
      return $array;
      $stmt->close();
    }

    function answerTypes() {
      $html = '';
      $html .= '<select name="answer_type" class="form-control">';

      $stmt = $this->connection->prepare("SELECT id, answer FROM answer_types");
      $stmt->bind_result($id, $type);
      $stmt->execute();

      $html .= '<option selected>----</option>';
      while($stmt->fetch()) {
        $html .= '<option value="'.$id.'">'.$type.'</option>';
      }
      $stmt->close();
      $html .= '</select>';

      return $html;
    }

    function sendAnswer($id, $type, $answer) {
      $response = new StdClass();
      $stmt = $this->connection->prepare("UPDATE got_cv SET answer_type = ?, answer = ? WHERE id = ?");
      $stmt->bind_param("isi", $type, $answer, $id);
      if($stmt->execute()) {
        $success = new StdClass();
        $success->message = "Vastus edukalt saadetud!!";
        $response->success = $success;

        #Saadab meili

      } else {
        $error = new StdClass();
        $error->message = "Midagi läks valesti! Anna teada administraatorile!";
        $response->error = $error;
      }

      return $response;
      $stmt->close();

    }


    ###################
    ### Send Resume ###
    ###################

    function sendResume($link, $user_id, $cv_id, $motivation) {
      $stmt = $this->connection->prepare("SELECT id FROM job_offers WHERE link = ?");
      $stmt->bind_param("s", $link);
      $stmt->bind_result($id);
      $stmt->execute();
      if($stmt->fetch()) {
        $job = new StdClass();
        $job->id = $id;
      }
      $stmt->close();

      $stmt = $this->connection->prepare("INSERT INTO got_cv (job_id, sender_id, cv_id, motivation, sent_time) VALUES (?,?,?,?,NOW())");
      $stmt->bind_param("iiis", $job->id, $user_id, $cv_id, $motivation);
      #var_dump ($job_id, $user_id, $cv_id, $motivation);
      $stmt->execute();

      #header("Location: ../content/jobs.php");

      $stmt->close();
    }

    ################################
    ### Default stuff in Resumes ###
    ################################

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
        $content = '<?php require_once("editresume.php"); ?>';
        fwrite($new_file, $content);
        header("Location: ".$link_file);
        exit();
      }
      $stmt->close();

    }

    function thisResume($link) {
      $stmt = $this->connection->prepare("SELECT id, name, positives, additional FROM ntb_resumes WHERE link = ?");
      $stmt->bind_param("s", $link);
      $stmt->bind_result($id, $name, $pos, $add);
      $stmt->execute();
      $thisResume = new StdClass();

      while($stmt->fetch()) {
        $thisResume = new StdClass();
        $thisResume->id = $id;
        $thisResume->name = $name;
        $thisResume->pos = $pos;
        $thisResume->add = $add;
    }
      return ($thisResume);
      $stmt->close();
    }

    #######################
    ### Resume: SCHOOLS ###
    #######################

    function newPrimary($cvid, $school, $start, $end, $info, $type, $link) {
      $stmt = $this->connection->prepare("INSERT INTO ntb_schools (resume_id, school, type, info, start, endtime) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("isisii", $cvid, $school, $type, $info, $start, $end);
      $stmt->execute();
      header("Location: ".$link);
      $stmt->close();
    }

    function getPrimary($cvid) {
      $stmt = $this->connection->prepare("SELECT ntb_schools.id, school, info, start, endtime, school_types.type FROM ntb_schools INNER JOIN school_types ON school_types.id = ntb_schools.type WHERE ntb_schools.resume_id = ? AND ntb_schools.deleted IS NULL ORDER BY endtime DESC");
      $stmt->bind_param("i", $cvid);
      $stmt->bind_result($id, $school, $info, $start, $endtime, $type);
      $stmt->execute();

      $array = array();

      while ($stmt->fetch()) {
        $primary = new StdClass();
        $primary->id = $id;
        $primary->school = $school;
        $primary->info = $info;
        $primary->start = $start;
        $primary->end = $endtime;
        $primary->type = $type;
        array_push($array, $primary);
      }

      return ($array);
      $stmt->close();
    }

    function deletePrimary($id, $user_id, $link) {
      $stmt = $this->connection->prepare("UPDATE ntb_schools INNER JOIN ntb_resumes ON ntb_resumes.id = ntb_schools.resume_id SET ntb_schools.deleted = NOW() WHERE ntb_schools.id = ? AND ntb_resumes.user_id = ?");
      $stmt->bind_param("ii", $id, $user_id);
      $stmt->execute();

      header("Location: ".$link);
      $stmt->close();
    }

    function editPrimary($id, $name, $start, $end, $info, $type, $user_id, $link) {
      $stmt = $this->connection->prepare("UPDATE ntb_schools INNER JOIN ntb_resumes ON ntb_resumes.id = ntb_schools.resume_id SET ntb_schools.school = ?, ntb_schools.info = ?, ntb_schools.type = ?, ntb_schools.start = ?, ntb_schools.endtime = ? WHERE ntb_schools.id = ? AND ntb_resumes.user_id = ?");
      $stmt->bind_param("ssiiiii", $name, $info, $type, $start, $end, $id, $user_id);
      $stmt->execute();

      header("Location: ".$link);
      $stmt->close();
    }

    function typeDropdown() {

      $html = '';
      $html .= '<select name="primary_type" class="form-control">';

      $stmt = $this->connection->prepare("SELECT id, type FROM school_types");
      $stmt->bind_result($id, $type);
      $stmt->execute();
      while($stmt->fetch()) {
        $html .= '<option value="'.$id.'">'.$type.'</option>';
      }
      $stmt->close();
      $html .= '</select>';

      return $html;

    }

    function currentTypeDropdown($primary_id) {
      $stmt = $this->connection->prepare("SELECT type FROM ntb_schools WHERE id = ?");
      $stmt->bind_param("i", $primary_id);
      $stmt->bind_result($current_type);
      $stmt->execute();
      $current = new StdClass();
      if($stmt->fetch()) {
        $current->type = $current_type;
      }
      $stmt->close();

      $html = '';
      $html .= '<select name="primary_type" class="form-control">';

      $stmt = $this->connection->prepare("SELECT id, type FROM school_types");
      $stmt->bind_result($id, $type);
      $stmt->execute();
      while($stmt->fetch()) {
        if ($current->type == $id) {
          $html .= '<option value="'.$id.'" selected>'.$type.'</option>';
        } else {
          $html .= '<option value="'.$id.'">'.$type.'</option>';
        }

      }
      $stmt->close();
      $html .= '</select>';

      return $html;

    }

    #######################
    ### Resume: COURSES ###
    #######################

    function newCourse($cvid, $name, $trainer, $duration, $info, $year, $link) {
      $stmt = $this->connection->prepare("INSERT INTO ntb_courses (resume_id, trainer, course, duration, info, year) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("issssi", $cvid, $trainer, $name, $duration, $info, $year);
      $stmt->execute();
      header("Location: ".$link);
      $stmt->close();
    }

    function getCourses($cvid) {
      $stmt = $this->connection->prepare("SELECT id, trainer, course, duration, info, year FROM ntb_courses WHERE resume_id = ? AND deleted IS NULL ORDER BY year DESC");
      $stmt->bind_param("i", $cvid);
      $stmt->bind_result($id, $trainer, $course_name, $duration, $info, $year);
      $stmt->execute();

      $array = array();

      while ($stmt->fetch()) {
        $course = new StdClass();
        $course->id = $id;
        $course->trainer = $trainer;
        $course->course = $course_name;
        $course->duration = $duration;
        $course->info = $info;
        $course->year = $year;

        array_push($array, $course);
      }
      return ($array);
      $stmt->close();

  }

  function editCourse($id, $name, $trainer, $duration, $info, $year, $user_id, $link) {
    $stmt = $this->connection->prepare("UPDATE ntb_courses INNER JOIN ntb_resumes ON ntb_resumes.id = ntb_courses.resume_id SET ntb_courses.trainer = ?, course = ?, duration = ?, info = ?, year = ? WHERE ntb_courses.id = ? AND ntb_resumes.user_id = ?");
    $stmt->bind_param("ssssiii", $trainer, $name, $duration, $info, $year, $id, $user_id);
    $stmt->execute();

    header("Location: ".$link);
    $stmt->close();
  }

  function deleteCourse($id, $user_id, $link) {
    $stmt = $this->connection->prepare("UPDATE ntb_courses INNER JOIN ntb_resumes ON ntb_resumes.id = ntb_courses.resume_id SET ntb_courses.deleted = NOW() WHERE ntb_courses.id = ? AND ntb_resumes.user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();

    header("Location: ".$link);
    $stmt->close();
  }

  ###############################
  ### Resume: Work experience ###
  ###############################

  function newWork($cvid, $company, $name, $content, $info, $start, $end, $link) {
    $stmt = $this->connection->prepare("INSERT INTO ntb_workexp (resume_id, company, name, content, info, start, endtime) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssii", $cvid, $company, $name, $content, $info, $start, $end);
    $stmt->execute();
    header("Location: ".$link);
    $stmt->close();
  }

  function getWorkexp($cvid) {
    $stmt = $this->connection->prepare("SELECT id, company, name, content, info, start, endtime FROM ntb_workexp WHERE resume_id = ? AND deleted IS NULL ORDER BY endtime DESC");
    $stmt->bind_param("i", $cvid);
    $stmt->bind_result($id, $company, $name, $content, $info, $start, $endtime);
    $stmt->execute();

    $array = array();

    while ($stmt->fetch()) {
      $work = new StdClass();
      $work->id = $id;
      $work->company = $company;
      $work->name = $name;
      $work->content = $content;
      $work->info = $info;
      $work->start = $start;
      $work->end = $endtime;

      array_push($array, $work);
    }
    return ($array);
    $stmt->close();

  }

  function deleteWork($id, $user_id, $link) {
    $stmt = $this->connection->prepare("UPDATE ntb_workexp INNER JOIN ntb_resumes ON ntb_resumes.id = ntb_workexp.resume_id SET ntb_workexp.deleted = NOW() WHERE ntb_workexp.id = ? AND ntb_resumes.user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();

    header("Location: ".$link);
    $stmt->close();
  }

  function editWork($id, $company, $name, $content, $info, $start, $end, $user_id, $link) {
    $stmt = $this->connection->prepare("UPDATE ntb_workexp INNER JOIN ntb_resumes ON ntb_resumes.id = ntb_workexp.resume_id SET ntb_workexp.company = ?, ntb_workexp.name = ?, ntb_workexp.content = ?, ntb_workexp.info = ?, ntb_workexp.start = ?, ntb_workexp.endtime = ? WHERE ntb_workexp.id = ? AND ntb_resumes.user_id = ?");
    $stmt->bind_param("ssssiiii", $company, $name, $content, $info, $start, $end, $id, $user_id);
    $stmt->execute();

    header("Location: ".$link);
    $stmt->close();
  }

  ##########################
  ### Resume: Additional ###
  ##########################

  function saveAdd($id, $user_id, $pos, $add, $link) {
    $stmt = $this->connection->prepare("UPDATE ntb_resumes SET positives = ?, additional = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssii", $pos, $add, $id, $user_id);
    $stmt->execute();

    header("Location: ".$link);
    $stmt->close();

  }
}
?>
