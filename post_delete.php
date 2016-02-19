<?php
  require_once 'includes/config.php';

  if ($_SESSION["is_admin"] != 1) {
    header("Location: index.php");
  }
  if (isset($_GET["id"]) && !empty($_GET["id"])) {
    try {
      $stmt = $db->prepare("DELETE FROM blog_posts WHERE postID=?");
      $stmt->bindParam(1, htmlspecialchars($_GET["id"]));
      $stmt->execute();
      header("Location: admin.php");
    } catch (PDOexception $e) {
      echo "Database Error is: ".$e->getMessage();
    } catch (Exception $e) {
      echo "General Error: ".$e->getMessage();
    }
  } else {
    header("Location: index.php");
  }
?>
