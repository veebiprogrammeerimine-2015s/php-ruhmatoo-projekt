<?php
	$page_title = "Unustasid parooli?";
	$page_file = "forgot.php";
?>
<?php
	require_once("header.php"); 
	require_once ("functions.php");
	
	if(isset($_SESSION['logged_in_user_id'])) {
		header("Location: index.php");
		exit ();
	}
	
?>
<h3>email -> URL -> Uus parool</h3>
<div class="row">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
 <div class="col-sm-4">
    <div class="input-group">
      <input type="email" name="email" class="form-control" placeholder="Email">
      <span class="input-group-btn">
        <input class="btn btn-success" type="submit" name="send" value="Saada">
      </span>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</form>
</div>

<?php require_once("footer.php"); ?>