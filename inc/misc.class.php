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

    function getNews() {

      $stmt = $this->connection->prepare("SELECT news_categories.name, subject, text, posted FROM news
                                          INNER JOIN news_categories ON news_categories.id = news.category
                                          WHERE deleted IS NULL");
      $stmt->bind_result($category, $subject, $text, $posted);
      $stmt->execute();

      $array = array();

      while($stmt->fetch()) {
        $news = new StdClass();
        $news->category = $category;
        $news->subject = $subject;
        $news->text = $text;
        $news->posted = $posted;
        array_push($array, $news);
      }
      return $array;

      $stmt->close();

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
