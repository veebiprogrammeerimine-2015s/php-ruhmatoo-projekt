<?php





// muuutujad errorite jaoks
	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";
	$create_name_error = "";
	$create_school_error = "";
  // muutujad väärtuste jaoks
	$email = "";
	$password = "";
	$create_email = "";
	$create_password = "";
	$create_name = "";
	$create_school = "";
	
	?>
<body>
<h2>Create user</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
  	<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
	<input name="create_name" type="text" placeholder="Nimi"  value="<?php echo $create_name; ?>"> <?php echo $create_name_error; ?> <br><br>
	<input name="create_school" type="text" placeholder="Asukoht" value="<?php echo $create_school; ?>"> <?php echo $create_school_error; ?> <br><br>
	
  	<input type="submit" name="create" value="Create user">
  </form>
<body>
<html>