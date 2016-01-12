<?php
  require_once("page/header.php");
  require_once("user.class.php");
  require_once("page/functions.php");
  //if(isset($_POST["osta"])){
  $user->purchaseMovie();
  //}
  ?>
  <h1> Film tuleb enne ära rentida </h1>
  <form action="main.php" method="post">
        <input name="osta" type="submit" value="Luban postiga raha filmi eest saata">
  </form>

  <?php require_once("page/footer.php"); ?>
