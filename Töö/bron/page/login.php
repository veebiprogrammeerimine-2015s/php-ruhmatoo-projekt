

    <link rel='stylesheet prefetch' href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

        <link rel="stylesheet" href="css/style.css">

<div class="module form-module">
  <div class="toggle"><i class="fa-user"></i>
    <div class="tooltip">Tööline</div>
  </div>
  <div class="form">
    <h2>Klient</h2>
    <form class="form-style-4" action="index.php#login" method="post">
		<input name="username" type="text" value="<?php echo $username ?>" placeholder="Kasutajanimi"> <?php echo $username_error; ?><br>
		<input name="password1" type="password" placeholder="Parool"> <?php echo $password1_error; ?>
      	<input type="submit" name="login" value="Log in">
    </form>
  </div>
  <div class="form">
    <h2>Tööline</h2>
    <form class="form-style-4" action="index.php#login" method="post">
		<input name="usernameW" type="text" value="<?php echo $usernameW ?>" placeholder="Kasutajanimi"> <?php echo $usernameW_error; ?><br>
		<input name="passwordW" type="password" placeholder="Parool"> <?php echo $passwordW_error; ?>
      	<input type="submit" name="loginW" value="Log in">
    </form>
	<script src='js/da0415260bc83974687e3f9ae.js'></script>
    <script src="js/index.js"></script>



