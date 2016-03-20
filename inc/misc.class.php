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

      $stmt = $this->connection->prepare("SELECT id, job_offers.name, description, company, county, parish, location, address, link, inserted, active, job_company.email, job_company.number FROM job_offers INNER JOIN job_company ON job_company.name = job_offers.company WHERE active IS NOT NULL AND deleted IS NULL ORDER BY active DESC");
      $stmt->bind_result($id_from_db, $name_from_db, $desc_from_db, $company_from_db, $county_from_db, $parish_from_db, $location_from_db, $address_from_db, $link, $inserted_from_db, $active_from_db, $email_from_db, $number_from_db);
      $stmt->execute();

      $array = array();

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

    function getNewsData($id) {
      $stmt = $this->connection->prepare("SELECT news.id, news_categories.name, subject, text, posted FROM news
                                          INNER JOIN news_categories ON news_categories.id = news.category
                                          WHERE deleted IS NULL AND news.id = ? ORDER BY posted DESC");
      $stmt->bind_param("i", $id);
      $stmt->bind_result($id, $category, $subject, $text, $posted);
      $stmt->execute();

      $news = new StdClass();
      if($stmt->fetch()) {
        $news->id = $id;
        $news->category = $category;
        $news->subject = $subject;
        $news->text = $text;
        $news->posted = $posted;
      }
      return $news;

      $stmt->close();

    }

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

    function editNews($news_id, $sub, $cat, $text) {
      $response = new StdClass();

      $stmt = $this->connection->prepare("UPDATE news SET subject = ?, category = ?, text = ? WHERE id = ?");
      $stmt->bind_param("sisi", $sub, $cat, $text, $news_id);

      if($stmt->execute()) {
        $success = new StdClass();
        $success->message = "Uudis edukalt muudetud!";
        $response->success = $success;
      } else {
        $error = new StdClass();
        $error->message = "Midagi läks valesti! Anna teada administraatorile!";
        $response->error = $error;
      }

      $_SESSION['response'] = $response;
      header("Location: news.php?id=".$news_id);
      exit();

      $stmt->close();
    }

    function deleteNews($news_id) {
      $response = new StdClass();

      $stmt = $this->connection->prepare("UPDATE news SET deleted = NOW() WHERE id = ?");
      $stmt->bind_param("i", $news_id);

      if($stmt->execute()) {
        $success = new StdClass();
        $success->message = "Uudis edukalt kustutatud!";
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

    function getCurrentCategoriesSelect($news_id) {
      $html = '';
      $html .= '<select name="category" class="form-control">';

      $stmt1 = $this->connection->prepare("SELECT id, name FROM news_categories");
      $stmt2 = $this->connection->prepare("SELECT category FROM news WHERE id = ?");

      $stmt2->bind_param("i", $news_id);

      $stmt1->bind_result($id, $name);
      $stmt2->bind_result($category);

      $stmt2->execute();
      $stmt2->fetch();
      $stmt2->close();

      $stmt1->execute();
      while($stmt1->fetch()) {
        if($category == $id) {
          $html .= '<option value="'.$id.'" selected>'.$name.'</option>';
        } else {
          $html .= '<option value="'.$id.'">'.$name.'</option>';
        }

      }
      $stmt1->close();


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
