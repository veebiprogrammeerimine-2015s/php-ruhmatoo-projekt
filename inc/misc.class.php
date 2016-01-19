<?php
  class Misc {

    private $connection;

    function __construct($mysqli){
        $this->connection = $mysqli;
    }

    ################
    ### HOMEPAGE ###
    ################

    function getJobs() {

      $stmt = $this->connection->prepare("SELECT name, company, parish FROM job_offers WHERE active IS NOT NULL AND deleted IS NULL ORDER BY active DESC");
      $stmt->bind_result($name_from_db, $company_from_db, $parish_from_db);
      $stmt->execute();

      $array = array();

      while($stmt->fetch()) {
        $job = new StdClass();
        $job->name = $name_from_db;
        $job->company = $company_from_db;
        $job->parish = $parish_from_db;
        array_push($array, $job);
      }
      return $array;

      $stmt->close();

    }

    function getNews($cat="") {
      if ($cat == "") {
        $search = "%%";
      }else{
        $search = $cat;
      }

      $stmt = $this->connection->prepare("SELECT news.id, news_categories.name, subject, text, posted FROM news
                                          INNER JOIN news_categories ON news_categories.id = news.category
                                          WHERE deleted IS NULL AND category LIKE ? ORDER BY posted DESC");
      $stmt->bind_param("s", $search);
      $stmt->bind_result($id, $category, $subject, $text, $posted);
      $stmt->execute();

      $array = array();

      while($stmt->fetch()) {
        $news = new StdClass();
        $news->id = $id;
        $news->category = $category;
        $news->subject = $subject;
        $news->text = $text;
        $news->posted = $posted;
        array_push($array, $news);
      }
      return $array;

      $stmt->close();

    }

    ############
    ### NEWS ###
    ############

    function getCategories() {

      $stmt = $this->connection->prepare("SELECT news_categories.id, name, count(news.id) FROM news_categories
                                          INNER JOIN news ON news.category = news_categories.id
                                          GROUP BY news_categories.id");
      $stmt->bind_result($id, $category, $count);
      $stmt->execute();

      $array = array();

      while($stmt->fetch()) {
        $categories = new StdClass();
        $categories->id = $id;
        $categories->name = $category;
        $categories->count = $count;
        array_push($array, $categories);
      }
      return $array;

      $stmt->close();

    }

    function addNews($user, $sub, $cat, $text) {
      $response = new StdClass();

      $stmt = $this->connection->prepare("INSERT INTO news (user_id, subject, category, text, posted) VALUES (?, ?, ?, ?, NOW())");
      $stmt->bind_param("isis", $user, $sub, $cat, $text);

      if($stmt->execute()) {
        $success = new StdClass();
  			$success->message = "Uudis edukalt sisestatud!";
  			$response->success = $success;
      } else {
        $error = new StdClass();
  			$error->message = "Midagi läks valesti! Anna teada administraatorile!";
  			$response->error = $error;
      }

      $_SESSION['response'] = $response;
      header("Location: news.php");
      exit();

      $stmt->close();
    }

    function getCategoriesSelect() {
      $html = '';
  		$html .= '<select name="category" class="form-control">';
      $html .= '<option selected>----</option>';
      
  		$stmt = $this->connection->prepare("SELECT id, name FROM news_categories");
  		$stmt->bind_result($id, $name);
  		$stmt->execute();
  		while($stmt->fetch()) {
  			$html .= '<option value="'.$id.'">'.$name.'</option>';
  		}
  		$stmt->close();
  		$html .= '</select>';

  		return $html;
    }


    ##########################
    ### STATS FOR HOMEPAGE ###
    ##########################

    function getDeleted() {

      $stmt = $this->connection->prepare("SELECT id FROM job_offers");
      $stmt->bind_result($id);
      $stmt->execute();

      $array = array();

      while($stmt->fetch()) {
        $job = new StdClass();
        $job->id = $id;
        array_push($array, $job);
      }
      return $array;

      $stmt->close();

    }

    function countNews() {

      $stmt = $this->connection->prepare("SELECT id FROM news");
      $stmt->bind_result($id);
      $stmt->execute();

      $array = array();

      while($stmt->fetch()) {
        $news = new StdClass();
        $news->id = $id;
        array_push($array, $news);
      }
      return $array;

      $stmt->close();

    }

    function getResumes() {

      $stmt = $this->connection->prepare("SELECT id FROM ntb_resumes");
      $stmt->bind_result($id);
      $stmt->execute();

      $array = array();

      while($stmt->fetch()) {
        $resume = new StdClass();
        $resume->id = $id;
        array_push($array, $resume);
      }
      return $array;

      $stmt->close();

    }

    function getSentResumes() {

      $stmt = $this->connection->prepare("SELECT id FROM got_cv");
      $stmt->bind_result($id);
      $stmt->execute();

      $array = array();

      while($stmt->fetch()) {
        $resume = new StdClass();
        $resume->id = $id;
        array_push($array, $resume);
      }
      return $array;

      $stmt->close();

    }





  }
?>
