<?php
  require_once 'includes/config.php';

  if ($_SESSION["is_admin"] != 1) {
    header("Location: index.php");
  }

  $post = new Post($db,htmlspecialchars($_GET["id"]));
  $e_title=$e_desc=$e_category=$e_content=$e_file=$success="";
  if(isset($_POST["edit"])) {
    if(!isset($_POST["title"]) OR empty($_POST["title"])) {
      $e_title = "Missing title!";
    }
    if(!isset($_POST["category"]) OR empty($_POST["category"])) {
      $e_category = "Missing category!";
    }
    if(!isset($_POST["desc"]) OR empty($_POST["desc"])) {
      $e_desc = "Missing description!";
    }
    if(!isset($_POST["body"]) OR empty($_POST["body"])) {
      $e_content = "Missing body!";
    }
    if($e_title=="" && $e_desc=="" && $e_category=="" && $e_content=="") {
      if(!isset($_FILES["file"]["name"]) OR empty($_FILES["file"]["name"])) {
        try {
          $stmt = $db->prepare("UPDATE blog_posts SET postTitle=?,postDesc=?,postCont=?,postDate=NOW(),postTag=?,postImg=? WHERE postID=?");
          $stmt->bindParam(1, $_POST["title"]);
          $stmt->bindParam(2, $_POST["desc"]);
          $stmt->bindParam(3, $_POST["body"]);
          $stmt->bindParam(4, $_POST["category"]);
          $stmt->bindParam(5, $post->_postImg);
          $stmt->bindParam(6, $post->_postID);
          $stmt->execute();
          header("Location: admin.php");
        } catch (PDOexception $e) {
          echo "Database Error is: ".$e->getMessage();
        } catch (Exception $e) {
          echo "General Error: ".$e->getMessage();
        }
      } else {
        // Banner picture for post upload
        $target_dir = "img/blog/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $e_file = "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $e_file = "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["file"]["size"] > 500000) {
            $e_file = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $e_file = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            //$e_file = "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
              // MySQL queries here, title, desc, category, content, image
              try {
                $stmt = $db->prepare("UPDATE blog_posts SET postTitle=?,postDesc=?,postCont=?,postDate=NOW(),postTag=?,postImg=? WHERE postID=?");
                $stmt->bindParam(1, $_POST["title"]);
                $stmt->bindParam(2, $_POST["desc"]);
                $stmt->bindParam(3, $_POST["body"]);
                $stmt->bindParam(4, $_POST["category"]);
                $stmt->bindParam(5, basename($_FILES["file"]["name"]));
                $stmt->bindParam(6, $post->_postID);
                $stmt->execute();
                header("Location: admin.php");
              } catch (PDOexception $e) {
                echo "Database Error is: ".$e->getMessage();
              } catch (Exception $e) {
                echo "General Error: ".$e->getMessage();
              }
            } else {
                $e_file = "Sorry, there was an error uploading your file.";
            }
        }
      }

    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=no">
<title>Admin</title>
<link rel="stylesheet" href="css/md-css.min.css">
<link rel="stylesheet" href="css/md-icons.min.css">
<link rel="stylesheet" href="css/main.min.css">
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
</head>
<body material centered fluid>
  <div toolbar>
    <button raised onclick="history.go(-1);">Back</button>
    Welcome <?= $_SESSION["user_email"]?>
    <a fg-black href="logout.php">Logout</a>
  </div>
  <div content>
    <h3 style="color:red"><?= $e_title?></h3>
    <h3 style="color:red"><?= $e_category?></h3>
    <h3 style="color:red"><?= $e_file?></h3>
    <h3 style="color:red"><?= $e_desc?></h3>
    <h3 style="color:red"><?= $e_content?></h3>
    <div card z-1 style="width:90%">
    <?php if($post->get()) : ?>
      <!-- Ei saa PHP_SELF kasutada siin, sest GET andmed ei säili -->
      <form  role="form" action="" method="post" enctype="multipart/form-data">
        <span>Title</span><input value="<?= $post->_postTitle?>" type="text" name="title">
        <select name="category">
          <?php
            try {
              $result = $db->query("SELECT * FROM blog_tag_color");
              $html = " ";
              foreach ($result as $row) {
                $html .= '<option value="'.$row["postTag"].'" ';
                if($row["postTag"] === $post->_postTag) {
                  $html .= 'selected ';
                }
                $html .= '";>'.$row["postTag"].'</option>';
              }
              echo $html;
            } catch (PDOexception $e) {
              echo "Database Error is: ".$e->getMessage();
            } catch (Exception $e) {
              echo "General Error: ".$e->getMessage();
            }
          ?>
        </select>
        <!-- Aksepteeri ainult pildi formaat -->
        <!-- file input ei saa kasutada value="", sest turvalisus. -->
        <input type="file" name="file" accept="image/*">
        <h6>Description</h6>
        <textarea name="desc"><?= $post->_postDesc?></textarea>
        <h6>Content</h6>
        <textarea name="body"><?= $post->_postCont?></textarea>
        <div align-right>
          <button type="submit" name="edit" bg-blue-grey400 ripple-color="tealA400">Post</button>
        </div>
      </form>
    <?php else : ?>
      <h1 centered>Sorry, no such post exists!</h1>
    <?php endif; ?>
    </div>
  </div>
</body>
</html>
