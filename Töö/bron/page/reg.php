

    <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

        <link rel="stylesheet" href="css/style.css">

<div class="module form-module">
  <div class="toggle">

  </div>
  <div class="form">
    <h2>Klient Registreeru</h2>
			<form class="form-style-4" action ="index.php#login" method="post">
				<input type="text" name="username" value ="<?php echo $username ?>" placeholder="kasutajanimi"><?php echo $username_error;?><br>
				<input type="text" name="firstname" value ="<?php echo $firstname ?>" placeholder="Eesnimi"><?php echo $firstname_error;?><br>
				<input type="text" name="lastname" value ="<?php echo $lastname ?>" placeholder="Perekonnanimi"><?php echo $lastname_error;?><br>
				<input name="email2" type="email" placeholder="E-post" value ="<?php echo $email2 ?>"><?php echo $email2_error; ?><br>
				<input name="password2" type="password" placeholder="Parool"><?php echo $password2_error; ?><br>
				<input name="password3" type="password" placeholder="Korda parooli"><?php echo $password3_error; ?><br>
				<input type="submit" name="registreeri" value="Registreeri"><br>
    </form>
  </div>