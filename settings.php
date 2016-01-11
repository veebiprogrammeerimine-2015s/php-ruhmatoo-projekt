<?php require_once("page/header.php"); ?>
<?php require_once("page/functions.php");?>
<?php

 //errorid
 $old_password_error = "";
 $new_password_error = "";
 $new2_password_error = "";
 $old_password_error_match = "";

 //muutujad
 $old_password = "";
 $new_password = "";
 $new2_password = "";

 // *************************
 // ** UUS PAROOL ***********
 // *************************

 if(isset($_POST["new_pw"])){
	 if (empty($_POST["vana_parool"])){
		 $old_password_error = "See väli on kohustuslik";
	 }else{
		 echo "Hiljem kontrolli kas vana pass on sama mis db's";
	 }
	 if($new_password == $new2_password){
		 $new_hash = hash("sha512", $new_password);
		 $user->updateUser($new_hash);
	 }
 }

?>
<!DOCTYPE html>
<html>
<body>

	<h2>Vaheta parooli</h2>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<input name="vana_parool" type="password" placeholder="Vana parool" value="<?php echo $old_password; ?>"> <?php echo $old_password_error; ?> <?php echo $old_password_error_match; ?> <br><br>
	<input name="uus_parool" type="password" placeholder="Uus parool" value="<?php echo $new_password; ?>"> <?php echo $new_password_error; ?> <br><br>
	<input name="uus_parool_uuesti" type="password" placeholder="Uus parool uuesti" value="<?php echo $new2_password; ?>"> <?php echo $new2_password_error; ?> <br><br>
	<input type="submit" name="new_pw" value="Kinnita">
	</form>

</body>
</html>

<?php require_once("page/footer.php"); ?>
