<?php require_once("page/header.php");
      require_once("page/functions.php");
      $id = 1;
      $control = $user->getAccess($id);
      if ($control == "1"){
        $link = "https://www.youtube.com/watch?v=-qxBXm7ZUTM";
      }
      else{
        $link = "/~robigin/vebprog/php-ruhmatoo-projekt/purchase.php";
      }

?>

<html>
<body>
<h1>die hard</h1>
<a href="<?php echo $link; ?>">Link</a>
</body>
</html>
<?php require_once("page/footer.php"); ?>
