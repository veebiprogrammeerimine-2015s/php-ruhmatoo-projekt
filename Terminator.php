<?php require_once("page/header.php");
      require_once("page/functions.php");
      $id = 1;
      $control = $user->getAccess($id);
      if ($control == "2"){
        $link = "https://youtu.be/c4Jo8QoOTQ4";
      }
      else{
        $link = "/~robigin/vebprog/php-ruhmatoo-projekt/purchase.php";
      }

?>

<html>
<body>
<h1>Terminator</h1>
<a href="<?php echo $link; ?>">Link</a>
</body>
</html>
<?php require_once("page/footer.php"); ?>
