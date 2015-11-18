<?php

?>
<html>

<head>
	<title>Eesti post</title>

</head>
<body>
		<form>
			<h2>Jätkamiseks vali roll</h2>
			<input type="radio" name="role" value="quest">Külaline<br><input type="radio" name="role" value="employee">Töötaja<br><br>
			<input type="submit" name="choose_role" value="Vali"><br>
		</form>
		<h2>Log in</h2>
		<form action="login.php" method="post">
			<input name="email1" type="email" value="<?php echo $email1 ?>" placeholder="E-post"> <?php echo $email1_error; ?><br><br>
			<input name="password1" type="password" placeholder="Parool"> <?php echo $password1_error; ?> <br><br>
			<input type="submit" name="login" value="Log in"><br>
			<a href="http://www.tlu.ee/~earist/">Unustasid parooli?</a>
		</form>
	
	<h2>Create user</h2>
		<form action ="login.php" method="post">
			<input type="text" name="firstname" value ="<?php echo $firstname ?>" placeholder="Eesnimi"><?php echo $firstname_error;?><br>
			<input type="text" name="lastname" value ="<?php echo $lastname ?>" placeholder="Perekonnanimi"><?php echo $lastname_error;?><br>
			<input name="email2" type="email" placeholder="E-post" value ="<?php echo $email2 ?>"><?php echo $email2_error; ?><br>
			<input name="password2" type="password" placeholder="Parool"><br><?php echo $password2_error; ?><br>
			<input name="password3" type="password" placeholder="Korda parooli"><?php echo $password3_error; ?><br><br>
			Sugu?<br><input type="radio" name="sugu" value="mees">Mees&nbsp;&nbsp;&nbsp;<input type="radio" name="sugu" value="naine">Naine<br><br>
			<input type="submit" name="registreeri" value="Registreeri"><br>
		</form>
</body>

</html>