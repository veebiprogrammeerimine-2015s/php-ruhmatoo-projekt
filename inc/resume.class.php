<?php
  class Resume {

    private $connection;
    public $url;

    function __construct($mysqli, $myurl){
        $this->connection = $mysqli;
        $this->url = $myurl;
    }

    ##################
    ### Resume PDF ###
    ##################

    function getPersonal($id) {
      $stmt = $this->connection->prepare("SELECT ntb_personal.firstname, lastname, born, county, parish, telnumber, ntb_users.email FROM ntb_personal
                                          INNER JOIN ntb_users ON ntb_users.id = ntb_personal.user_id
                                          INNER JOIN ntb_resumes ON ntb_resumes.user_id = ntb_personal.user_id
                                          INNER JOIN got_cv ON got_cv.cv_id = ntb_resumes.id
                                          WHERE got_cv.id = ?");
      $stmt->bind_param("i", $id);
      $stmt->bind_result($first, $last, $born, $county, $parish, $number, $email);
      $stmt->execute();

      if($stmt->fetch()) {
        $personal = new StdClass();
        $personal->first = $first;
        $personal->last = $last;
        $personal->born = $born;
        $personal->county = $county;
        $personal->parish = $parish;
        $personal->number = $number;
        $personal->email = $email;

      }
      return ($personal);

      $stmt->close();
    }

    function getEducation($id) {
      $stmt = $this->connection->prepare("SELECT school_types.type, ntb_schools.school, info, start, endtime FROM ntb_schools
                                          INNER JOIN school_types ON school_types.id = ntb_schools.type
                                          INNER JOIN ntb_resumes ON ntb_resumes.id = ntb_schools.resume_id
                                          INNER JOIN got_cv ON got_cv.cv_id = ntb_resumes.id
                                          WHERE got_cv.id = ? AND ntb_schools.deleted IS NULL ORDER BY ntb_schools.endtime DESC");
      $stmt->bind_param("i", $id);
      $stmt->bind_result($type, $name, $info, $start, $end);
      $stmt->execute();

      $array = array();
      while($stmt->fetch()) {
        $school = new StdClass();
        $school->name = $name;
        $school->type = $type;
        $school->info = $info;
        $school->start = $start;
        $school->end = $end;

        array_push($array, $school);

      }
      return ($array);

      $stmt->close();
    }

    function getSentWork($id) {
      $stmt = $this->connection->prepare("SELECT ntb_workexp.id, ntb_workexp.company, ntb_workexp.name, ntb_workexp.content,
                                          ntb_workexp.info, ntb_workexp.start, ntb_workexp.endtime FROM ntb_workexp
                                          INNER JOIN ntb_resumes ON ntb_resumes.id = ntb_workexp.resume_id
                                          INNER JOIN got_cv ON got_cv.cv_id = ntb_resumes.id
                                          WHERE got_cv.id = ? AND ntb_workexp.deleted IS NULL ORDER BY ntb_workexp.endtime");
      $stmt->bind_param("i", $id);
      $stmt->bind_result($id, $company, $name, $content, $infos, $start, $end);
      $stmt->execute();

      $array = array();

      while ($stmt->fetch()) {
        $work = new StdClass();
        $work->id = $id;
        $work->company = $company;
        $work->name = $name;
        $work->content = $content;
        $work->info = $infos;
        $work->start = $start;
        $work->end = $end;

        array_push($array, $work);
      }
      return ($array);
      $stmt->close();

  }

  function getSentCourses($id) {
    $stmt = $this->connection->prepare("SELECT ntb_courses.id, trainer, course, duration, info, year FROM ntb_courses
                                        INNER JOIN ntb_resumes ON ntb_resumes.id = ntb_courses.resume_id
                                        INNER JOIN got_cv ON got_cv.cv_id = ntb_resumes.id
                                        WHERE got_cv.id = ? ORDER BY ntb_courses.year");
    $stmt->bind_param("i", $id);
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

  function getSentLanguages($id) {
    $stmt = $this->connection->prepare("SELECT ntb_languages.id, language, writing, speaking, reading, info FROM ntb_languages
                                        INNER JOIN ntb_resumes ON ntb_resumes.id = ntb_languages.resume_id
                                        INNER JOIN got_cv ON got_cv.cv_id = ntb_resumes.id
                                        WHERE got_cv.id = ? ORDER BY ntb_languages.language");
    $stmt->bind_param("i", $id);
    $stmt->bind_result($id, $language, $writing, $speaking, $reading, $info);
    $stmt->execute();

    $array = array();

    while ($stmt->fetch()) {
      $languages = new StdClass();
      $languages->id = $id;
      $languages->language = $language;
      $languages->writing = $writing;
      $languages->speaking = $speaking;
      $languages->reading = $reading;
      $languages->info = $info;

      array_push($array, $languages);
    }
    return ($array);
    $stmt->close();

  }

  function getSentOther($id) {
    $stmt = $this->connection->prepare("SELECT ntb_resumes.id, positives, additional FROM ntb_resumes
                                        INNER JOIN got_cv ON got_cv.cv_id = ntb_resumes.id
                                        WHERE got_cv.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->bind_result($id, $positives, $additional);
    $stmt->execute();

    $array = array();

    while ($stmt->fetch()) {
      $other = new StdClass();
      $other->id = $id;
      $other->positives = $positives;
      $other->additional = $additional;


      array_push($array, $other);
    }
    return ($array);
    $stmt->close();

  }


    ########################
    ### Employee resumes ###
    ########################

    function getSentResumes($user) {
      $stmt = $this->connection->prepare("SELECT got_cv.id, got_cv.sent_time, job_offers.name, ntb_personal.firstname, ntb_personal.lastname FROM got_cv
                                          INNER JOIN job_offers ON job_offers.id = got_cv.job_id
                                          INNER JOIN ntb_users ON ntb_users.id = got_cv.sender_id
                                          INNER JOIN ntb_personal ON ntb_personal.user_id = ntb_users.id
                                          WHERE job_offers.user_id = ? AND got_cv.answer_type IS NULL ORDER BY got_cv.sent_time DESC");
      $stmt->bind_param("i", $user);
      $stmt->bind_result($id, $sent_time, $job_name, $send_first, $send_last);
      $stmt->execute();

      $array = array();
      while($stmt->fetch()) {
        $oDate = new DateTime($sent_time);
        $sDate = $oDate->format("d.m.Y H:i:s");

        $job = new StdClass();
        $job->id = $id;
        $job->job = $job_name;
        $job->first = $send_first;
        $job->last = $send_last;
        $job->time = $sDate;
        array_push($array, $job);
      }
      return $array;
      $stmt->close();
    }

    function getAnsweredResumes($user) {
      $stmt = $this->connection->prepare("SELECT got_cv.id, answer_types.answer, got_cv.answer, got_cv.sent_time, answer_time, job_offers.name, ntb_personal.firstname, ntb_personal.lastname FROM got_cv
                                          INNER JOIN job_offers ON job_offers.id = got_cv.job_id
                                          INNER JOIN ntb_users ON ntb_users.id = got_cv.sender_id
                                          INNER JOIN ntb_personal ON ntb_personal.user_id = ntb_users.id
                                          INNER JOIN answer_types ON answer_types.id = got_cv.answer_type
                                          WHERE job_offers.user_id = ? AND got_cv.answer_type IS NOT NULL ORDER BY got_cv.answer_time DESC");
      $stmt->bind_param("i", $user);
      $stmt->bind_result($id, $answer_type, $answer, $sent_time, $answer_time, $job_name, $send_first, $send_last);
      $stmt->execute();

      $array = array();
      while($stmt->fetch()) {
        $oDate = new DateTime($answer_time);
        $sDate = $oDate->format("d.m.Y H:i:s");

        $job = new StdClass();
        $job->id = $id;
        $job->job = $job_name;
        $job->first = $send_first;
        $job->last = $send_last;
        $job->answer_type = $answer_type;
        $job->answer = $answer;
        $job->time = $sent_time;
        $job->answer_time = $sDate;
        array_push($array, $job);
      }
      return $array;
      $stmt->close();
    }

    function resumeToPDF() {
        $stmt = $this->connection->prepare("SELECT
                                            ntb_schools.school, school_types.type, ntb_schools.info, ntb_schools.start, ntb_schools.endtime,
                                            ntb_workexp.company, ntb_workexp.name, ntb_workexp.content, ntb_workexp.info, ntb_workexp.start, ntb_workexp.endtime,
                                            ntb_courses.trainer, ntb_courses.course, ntb_courses.duration, ntb_courses.info, ntb_courses.year,
                                            ntb_personal.firstname, ntb_personal.lastname, ntb_personal.county, ntb_personal.parish, ntb_personal.telnumber,
                                            ntb_users.email, ntb_resumes.positives, ntb_resumes.additional FROM ntb_resumes
                                            INNER JOIN ntb_schools ON ntb_schools.resume_id = ntb_resumes.id
                                            INNER JOIN school_types ON school_types.id = ntb_schools.type
                                            INNER JOIN ntb_workexp ON ntb_workexp.resume_id = ntb_resumes.id
                                            INNER JOIN ntb_courses ON ntb_courses.resume_id = ntb_resumes.id
                                            INNER JOIN ntb_personal ON ntb_personal.user_id = ntb_resumes.user_id
                                            INNER JOIN ntb_users ON ntb_users.id = ntb_resumes.user_id
                                            WHERE ntb_schools.deleted IS NULL AND ntb_resumes.deleted IS NULL AND ntb_courses.deleted IS NULL
                                            AND ntb_workexp.deleted IS NULL AND ntb_resumes.id = 21");


        $stmt->bind_result($school_name, $school_type, $school_info, $school_start, $school_end,
                           $work_company, $work_name, $work_content, $work_info, $work_start, $work_end,
                           $course_trainer, $course_name, $course_duration, $course_info, $course_year,
                           $personal_first, $personal_last, $personal_county, $personal_parish, $personal_number,
                           $personal_email, $resume_positives, $resume_additional);
        $stmt->execute();


        #$stmt->bind_param("i", $id);


        $array = array();
        while($stmt->fetch()) {

          $school = new StdClass();
          $school->sch_name = $school_name;
          $school->sch_type = $school_type;
          $school->sch_info = $school_info;
          $school->sch_start = $school_start;
          $school->sch_end = $school_end;
          array_push($array, $school);

          $work = new StdClass();
          $work->work_company = $work_company;
          $work->work_name = $work_name;
          $work->work_content = $work_content;
          $work->work_info = $work_info;
          $work->work_start = $work_start;
          $work->work_end = $work_end;
          array_push($array, $work);

          $course = new StdClass();
          $course->cor_trainer = $course_trainer;
          $course->cor_name = $course_name;
          $course->cor_duration = $course_duration;
          $course->cor_info = $course_info;
          $course->cor_year = $course_year;
          array_push($array, $course);

          $personal = new StdClass();
          $personal->per_first = $personal_first;
          $personal->per_last = $personal_last;
          $personal->per_county = $personal_county;
          $personal->per_parish = $personal_parish;
          $personal->per_number = $personal_number;
          $personal->per_email = $personal_email;
          array_push($array, $personal);

          $resume = new StdClass();
          $resume->res_positives = $resume_positives;
          $resume->res_additional = $resume_additional;
          array_push($array, $resume);
        }

        return ($array);
        #var_dump ($resume->school_name);

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


    function sendAnswer($id, $type, $answers) {
      $response = new StdClass();

      $stmt = $this->connection->prepare("SELECT company, name, email FROM job_offers
                                          INNER JOIN got_cv ON got_cv.job_id = job_offers.id
										                      INNER JOIN ntb_users ON ntb_users.id = got_cv.sender_id
                                          WHERE got_cv.id = ?");
      $stmt->bind_param("i", $id);
      $stmt->bind_result($company, $name, $email);
      $stmt->execute();
      if($stmt->fetch()) {
        $answer = new StdClass();
        $answer->company = $company;
        $answer->name = $name;
        $answer->email = $email;
      }
      $stmt->close();

      $stmt = $this->connection->prepare("UPDATE got_cv SET answer_type = ?, answer = ?, answer_time = NOW() WHERE id = ?");
      $stmt->bind_param("isi", $type, $answers, $id);
      if($stmt->execute()) {
        $success = new StdClass();
        $success->message = "Vastus edukalt saadetud!";
        $response->success = $success;

        $stmt->close();
        $stmt = $this->connection->prepare("SELECT answer_types.answer FROM got_cv
                                            INNER JOIN answer_types ON answer_types.id = got_cv.answer_type
                                            WHERE got_cv.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->bind_result($answer_name);
        $stmt->execute();
        $stmt->fetch();

        $to      = $answer->email; // Searcher email
        $subject = '[NTB] Vastus ettevõttelt '.$answer->company; // Company name
        $message = '
Tere,

Teie kandideerimine ettevõttesse '.$answer->company.', töökohale '.$answer->name.' on '.$answer_name.'!
Ettevõtja poolne tagasiside:
'.$answers.'

Lugupidamisega,
Noorte Tööbörs
www.ntb.ee
                   '; // Formal letter
        $headers = 'From: info@ntb.ee' . "\r\n" . // info@ntb.ee mail
            'Reply-To: rauno@ntb.ee' . "\r\n" . // This is going to be webmaster mail
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

      } else {
        $error = new StdClass();
        $error->message = "Midagi läks valesti! Anna teada administraatorile!";
        $response->error = $error;
      }
      $_SESSION['response'] = $response;
      header("Location: sentresumes.php");
      exit();
      $stmt->close();

    }


    ###################
    ### Send Resume ###
    ###################

    function sendResume($link, $user_id, $cv_id, $motivation) {
      $response = new StdClass();
      $stmt = $this->connection->prepare("SELECT job_offers.id, job_offers.name, job_company.email FROM job_offers
                                          INNER JOIN job_company ON job_company.name = job_offers.company
                                          WHERE job_offers.link = ?");
      $stmt->bind_param("s", $link);
      $stmt->bind_result($id, $name, $email);
      $stmt->execute();
      if($stmt->fetch()) {
        $job = new StdClass();
        $job->id = $id;
        $job->name = $name;
        $job->email = $email;
      }
      $stmt->close();

      $stmt = $this->connection->prepare("SELECT id FROM got_cv WHERE job_id = ? AND sender_id = ? AND NOW() < DATE_ADD(sent_time, INTERVAL +3 day)");
      $stmt->bind_param("ii", $job->id, $user_id);
      $stmt->bind_result($id);
      $stmt->execute();
      if($stmt->fetch()) {
        $error = new StdClass();
        $error->id = 0;
        $error->message = "Oled sellele tööle CV esitanud 3 päeva jooksul!";
        $response->error = $error;
        $_SESSION['response'] = $response;
        header("Location: ../content/jobs.php");
        exit();
      }
      $stmt->close();

      $stmt = $this->connection->prepare("INSERT INTO got_cv (job_id, sender_id, cv_id, motivation, sent_time) VALUES (?,?,?,?,NOW())");
      $stmt->bind_param("iiis", $job->id, $user_id, $cv_id, $motivation);

      if($stmt->execute()) {
        $success = new StdClass();
        $success->message = "CV on edukalt <strong>saadetud!</strong> Nüüd jääb üle ainult vastust oodata!";
        $response->success = $success;

        $to      = $job->email; // Employee mail from job_company
        $subject = '[NTB] Kandideerimine ametile '.$job->name; // ... means job_offers.name
        $message = '
Tere,

Teie pakutud töökohale '.$job->name.' on saadetud uus CV!
CV nägemiseks tuleb suunduda aadressile:
http://devweb.eu/php-ruhmatoo-projekt/content/sentresumes.php
Seal saate vaadata Teie pakutud töökohtadele kandideerijate CVsi ning kirjutada neile vastus!

Lugupidamisega,
Noorte Tööbörs
www.ntb.ee
                   '; // Formal letter
        $headers = 'From: info@ntb.ee' . "\r\n" . // info@ntb.ee mail
            'Reply-To: rauno@ntb.ee' . "\r\n" . // This is going to be webmaster mail
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

      } else {
        $error = new StdClass();
        $error->id = 1;
        $error->message = "Paistab, et ahvikene ei saanud banaani ning otsustas, et tema ei ole nõus koostööd tegema!<br>Teavita administraatorit!";
        $response->error = $error;
      }

      $_SESSION['response'] = $response;
      header("Location: ../content/jobs.php");
      exit();
      $stmt->close();
    }

    ################################
    ### Default stuff in Resumes ###
    ################################

    function getResumes($userid) {
      $stmt = $this->connection->prepare("SELECT id, name, link, inserted FROM ntb_resumes WHERE user_id = ? AND deleted IS NULL");
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

    function deleteResume($id, $user_id) {
      $stmt = $this->connection->prepare("UPDATE ntb_resumes SET deleted = NOW() WHERE id = ? AND user_id = ?");
      $stmt->bind_param("ii", $id, $user_id);
      $stmt->execute();

      header("Location: profile.php#resumes");
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
      header("Location: ".$link."#education");
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

      header("Location: ".$link."#education");
      $stmt->close();
    }

    function editPrimary($id, $name, $start, $end, $info, $type, $user_id, $link) {
      $stmt = $this->connection->prepare("UPDATE ntb_schools INNER JOIN ntb_resumes ON ntb_resumes.id = ntb_schools.resume_id SET ntb_schools.school = ?, ntb_schools.info = ?, ntb_schools.type = ?, ntb_schools.start = ?, ntb_schools.endtime = ? WHERE ntb_schools.id = ? AND ntb_resumes.user_id = ?");
      $stmt->bind_param("ssiiiii", $name, $info, $type, $start, $end, $id, $user_id);
      $stmt->execute();

      header("Location: ".$link."#education");
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

    #########################
    ### Resume: Languages ###
    #########################

    function newLanguage($cvid, $language, $writing, $speaking, $reading, $info, $link) {
      $stmt = $this->connection->prepare("INSERT INTO ntb_languages (resume_id, language, writing, speaking, reading, info) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("isiiis", $cvid, $language, $writing, $speaking, $reading, $info);
      $stmt->execute();
      header("Location: ".$link."#languages");
      $stmt->close();
    }

    function getLanguages($cvid) {
      $stmt1 = $this->connection->prepare("SELECT ntb_languages.id, language, writing, speaking, reading, info FROM ntb_languages
                                          INNER JOIN language_skills ON language_skills.id = ntb_languages.writing
                                          WHERE resume_id = ? AND deleted IS NULL");

      $stmt2 = $this->connection->prepare("SELECT id, skill FROM language_skills");

      $stmt1->bind_param("i", $cvid);

      $stmt1->bind_result($id, $language, $writing, $speaking, $reading, $info);
      $stmt2->bind_result($skillid, $skill);

      $stmt2->execute();

      $array2 = array();
      while($stmt2->fetch()) {
        $skills = new StdClass();
        $skills->id = $skillid;
        $skills->skill = $skill;
        array_push($array2, $skills);
      }

      $stmt2->close();

      $stmt1->execute();

      $array = array();
      while ($stmt1->fetch()) {
        $languages = new StdClass();
        $languages->id = $id;
        $languages->language = $language;

        foreach ($array2 as $value) {

          if($writing == $value->id) {
            $languages->writing = $value->skill;
          }
          if($speaking == $value->id) {
            $languages->speaking = $value->skill;
          }
          if($reading == $value->id) {
            $languages->reading = $value->skill;
          }

        }

        $languages->info = $info;

        array_push($array, $languages);
      }
      return ($array);
      $stmt1->close();

    }

    function languageSkills() {
      $html = '';

      $stmt = $this->connection->prepare("SELECT id, skill FROM language_skills");
      $stmt->bind_result($id, $skill);
      $stmt->execute();

      $html .= '<option selected>----</option>';
      while($stmt->fetch()) {
        $html .= '<option value="'.$id.'">'.$skill.'</option>';
      }
      $stmt->close();

      return $html;
    }

    function currentWritingSkill($language_id) {
      $stmt = $this->connection->prepare("SELECT writing FROM ntb_languages WHERE id = ?");
      $stmt->bind_param("i", $language_id);
      $stmt->bind_result($writing);
      $stmt->execute();
      $current = new StdClass();
      if($stmt->fetch()) {
        $current->writing = $writing;
      }
      $stmt->close();

      $html = '';

      $stmt = $this->connection->prepare("SELECT id, skill FROM language_skills");
      $stmt->bind_result($id, $skill);
      $stmt->execute();
      while($stmt->fetch()) {
        if ($current->writing == $id) {
          $html .= '<option value="'.$id.'" selected>'.$skill.'</option>';
        } else {
          $html .= '<option value="'.$id.'">'.$skill.'</option>';
        }

      }
      $stmt->close();

      return $html;

    }

    function currentSpeakingSkill($language_id) {
      $stmt = $this->connection->prepare("SELECT speaking FROM ntb_languages WHERE id = ?");
      $stmt->bind_param("i", $language_id);
      $stmt->bind_result($speaking);
      $stmt->execute();
      $current = new StdClass();
      if($stmt->fetch()) {
        $current->speaking = $speaking;
      }
      $stmt->close();

      $html = '';

      $stmt = $this->connection->prepare("SELECT id, skill FROM language_skills");
      $stmt->bind_result($id, $skill);
      $stmt->execute();
      while($stmt->fetch()) {
        if ($current->speaking == $id) {
          $html .= '<option value="'.$id.'" selected>'.$skill.'</option>';
        } else {
          $html .= '<option value="'.$id.'">'.$skill.'</option>';
        }

      }
      $stmt->close();

      return $html;

    }

    function currentReadingSkill($language_id) {
      $stmt = $this->connection->prepare("SELECT reading FROM ntb_languages WHERE id = ?");
      $stmt->bind_param("i", $language_id);
      $stmt->bind_result($reading);
      $stmt->execute();
      $current = new StdClass();
      if($stmt->fetch()) {
        $current->reading = $reading;
      }
      $stmt->close();

      $html = '';

      $stmt = $this->connection->prepare("SELECT id, skill FROM language_skills");
      $stmt->bind_result($id, $skill);
      $stmt->execute();
      while($stmt->fetch()) {
        if ($current->reading == $id) {
          $html .= '<option value="'.$id.'" selected>'.$skill.'</option>';
        } else {
          $html .= '<option value="'.$id.'">'.$skill.'</option>';
        }

      }
      $stmt->close();

      return $html;

    }

    function editLanguage($id, $language, $writing, $speaking, $reading, $info, $link) {
      $stmt = $this->connection->prepare("UPDATE ntb_languages SET language = ?, writing = ?, speaking = ?, reading = ?, info = ? WHERE id = ?");
      $stmt->bind_param("siiisi", $language, $writing, $speaking, $reading, $info, $id);
      $stmt->execute();

      header("Location: ".$link."#languages");
      $stmt->close();
    }

    function deleteLanguage($id, $user_id, $link) {
      $stmt = $this->connection->prepare("UPDATE ntb_languages INNER JOIN ntb_resumes ON ntb_resumes.id = ntb_languages.resume_id SET ntb_languages.deleted = NOW() WHERE ntb_languages.id = ? AND ntb_resumes.user_id = ?");
      $stmt->bind_param("ii", $id, $user_id);
      $stmt->execute();

      header("Location: ".$link."#languages");
      $stmt->close();
    }



    #######################
    ### Resume: COURSES ###
    #######################

    function newCourse($cvid, $name, $trainer, $duration, $info, $year, $link) {
      $stmt = $this->connection->prepare("INSERT INTO ntb_courses (resume_id, trainer, course, duration, info, year) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("issssi", $cvid, $trainer, $name, $duration, $info, $year);
      $stmt->execute();
      header("Location: ".$link."#courses");
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

    header("Location: ".$link."#courses");
    $stmt->close();
  }

  function deleteCourse($id, $user_id, $link) {
    $stmt = $this->connection->prepare("UPDATE ntb_courses INNER JOIN ntb_resumes ON ntb_resumes.id = ntb_courses.resume_id SET ntb_courses.deleted = NOW() WHERE ntb_courses.id = ? AND ntb_resumes.user_id = ?");
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();

    header("Location: ".$link."#courses");
    $stmt->close();
  }

  ###############################
  ### Resume: Work experience ###
  ###############################

  function newWork($cvid, $company, $name, $content, $info, $start, $end, $link) {
    $stmt = $this->connection->prepare("INSERT INTO ntb_workexp (resume_id, company, name, content, info, start, endtime) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssii", $cvid, $company, $name, $content, $info, $start, $end);
    $stmt->execute();
    header("Location: ".$link."#workexp");
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

    header("Location: ".$link."#workexp");
    $stmt->close();
  }

  function editWork($id, $company, $name, $content, $info, $start, $end, $user_id, $link) {
    $stmt = $this->connection->prepare("UPDATE ntb_workexp INNER JOIN ntb_resumes ON ntb_resumes.id = ntb_workexp.resume_id SET ntb_workexp.company = ?, ntb_workexp.name = ?, ntb_workexp.content = ?, ntb_workexp.info = ?, ntb_workexp.start = ?, ntb_workexp.endtime = ? WHERE ntb_workexp.id = ? AND ntb_resumes.user_id = ?");
    $stmt->bind_param("ssssiiii", $company, $name, $content, $info, $start, $end, $id, $user_id);
    $stmt->execute();

    header("Location: ".$link."#workexp");
    $stmt->close();
  }

  ##########################
  ### Resume: Additional ###
  ##########################

  function saveAdd($id, $user_id, $pos, $add, $link) {
    $stmt = $this->connection->prepare("UPDATE ntb_resumes SET positives = ?, additional = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssii", $pos, $add, $id, $user_id);
    $stmt->execute();

    header("Location: ".$link."#additional");
    $stmt->close();

  }
}
?>
