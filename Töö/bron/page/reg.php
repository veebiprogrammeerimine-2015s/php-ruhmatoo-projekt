
		<div class="regContainer">
			<h2>Loo kasutaja</h2>
			<form class="form-style-4" action ="index.php#reg" method="post">
				<input type="text" name="username" value ="<?php echo $username ?>" placeholder="kasutajanimi"><?php echo $username_error;?><br>
				<input type="text" name="firstname" value ="<?php echo $firstname ?>" placeholder="Eesnimi"><?php echo $firstname_error;?><br>
				<input type="text" name="lastname" value ="<?php echo $lastname ?>" placeholder="Perekonnanimi"><?php echo $lastname_error;?><br>
				<input name="email2" type="email" placeholder="E-post" value ="<?php echo $email2 ?>"><?php echo $email2_error; ?><br>
				<input name="password2" type="password" placeholder="Parool"><?php echo $password2_error; ?><br>
				<input name="password3" type="password" placeholder="Korda parooli"><?php echo $password3_error; ?><br>
				<input type="submit" name="registreeri" value="Registreeri"><br>
		</div>

			</form>
		
