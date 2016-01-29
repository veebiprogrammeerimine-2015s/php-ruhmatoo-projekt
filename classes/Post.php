<?php
  class Post {

    private $_db;
    public $_postID;
    public $_postTitle;
    public $_postDesc;
    public $_postCont;
    public $_postDate;
    public $_postTag;
    public $_color;

    public function __construct(PDO $db, $id) {
  		$this->_db = $db;
      $this->_postID = $id;
  	}

    public function get() {
      try {
        $stmt = $this->_db->prepare("SELECT * FROM blog_posts
          LEFT JOIN blog_tag_color
          ON blog_posts.postTag=blog_tag_color.postTag
          WHERE postID=:postID");
        $stmt->bindParam(':postID', $this->_postID, PDO::PARAM_INT, 16);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result) {
          $this->_postCont = $result["postCont"];
          $this->_postTitle = $result["postTitle"];
          $this->_postDesc = $result["postDesc"];
          $this->_postDate = $result["postDate"];
          $this->_postTag = $result["postTag"];
          $this->_color = $result["color"];
          return True;
        }
      } catch (PDOexception $e) {
        echo "Error is: " . $e-> etmessage();
      }
    }

  }
?>
