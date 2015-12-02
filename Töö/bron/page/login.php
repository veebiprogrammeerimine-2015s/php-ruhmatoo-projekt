		<div class="loginContainer">
			<h2>Log in</h2>
			<form class="form-style-4" action="index.php#login" method="post">
				<input name="username" type="text" value="<?php echo $username ?>" placeholder="E-post"> <?php echo $username_error; ?><br>
				<input name="password1" type="password" placeholder="Parool"> <?php echo $password1_error; ?> <br>
				<input type="submit" name="login" value="Log in"><br>
			</form>
		</div>


