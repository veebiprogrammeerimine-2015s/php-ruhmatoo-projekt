<?php require_once("header.php"); ?>

	<!-- ###################### -->
	<!-- ####### MENUU ######## -->
	<!-- ###################### -->
	
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Ruslan</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Link</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	
<br><br><br><br><br><br>

	

<?php require_once("footer.php"); ?>


<?php
	
	// LOGIN.PHP
	
	//require_once("functions.php");//
	$login_email = "";
	$email_error = "";
	$create_email = "";
	$create_email_error = "";
	$create_email_confirm = "";
	$create_email_confirm_error = "";
	
	$login_password = "";
	$password_error = "";
	$create_password = "";
	$create_password_error = "";
	$create_password_confirm = "";
	$create_password_confirm_error = "";
	
	$firstname = "";
	$lastname = "";
	$firstname_error = "";
	$lastname_error = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if(isset($_POST["login"])){ 
			if ( empty($_POST["email1"]) ) {
				$email_error = "See vali on kohustuslik";
			}else{
				$login_email = test_input($_POST["email1"]);
			}
			
			if ( empty($_POST["password1"]) ) {
				$password_error = "See vali on kohustuslik";
			}else{
				
				if(strlen($_POST["password1"]) < 8) { 
				
					$password_error = "Peab olema vahemalt 8 tahemarki pikk!";
					
				}else{
					$login_password = test_input($_POST["password1"]);
				}
				
			}
			
			if($email_error == "" && $password_error ==""){
				
				echo "kontrollin sisselogimist ".$login_email." ja parool ";
			}
		
		
			if($password_error == "" && $email_error == ""){
				echo "Voib sisse logida! Kasutajanimi on ".$login_email." ja parool on ".$login_password;
				
				$hash = hash("sha512", $login_password);
				
				echo $hash;
				
				loginUser($login_email, $hash);
			}
		}
		
		elseif(isset($_POST["create"])){
			
			if ( empty($_POST["firstname"]) ) {
				$firstname_error = "See vali on kohustuslik";
			}else{
				$firstname= test_input($_POST["firstname"]);
			}
			
			if ( empty($_POST["lastname"]) ) {
				$lastname_error = "See vali on kohustuslik";
			}else{
				$lastname = test_input($_POST["lastname"]);
			}
			
			if ( empty($_POST["create_email"]) ) {
				$create_email_error = "See vali on kohustuslik";
			}else{
				
				$create_email = test_input($_POST["create_email"]);
			}
			
			if ( empty($_POST["create_email_confirm"]) ) {
				$create_email_confirm_error = "See vali on kojustuslik";
			}else{
				$create_email_confirm = test_input($_POST["create_email_confirm"]);
			}
			
			if ( empty($_POST["create_password"]) ) {
				$create_password_error = "See vali on kohustuslik";
			} else {
				
				if(strlen($_POST["create_password"]) < 8) { 
				
					$create_password_error = "Peab olema vahemalt 8 tahemarki pikk!";
					
				}else{
					$create_password = test_input($_POST["create_password"]);
				}
			}
				
			if ( empty($_POST["create_password_confirm"]) ) {
				$create_password_confirm_error = "See vali on kohustuslik";
			}else {
				
				if(strlen($_POST["create_password_confirm"]) < 8) { 
				
					$create_password_confirm_error = "Peab olema vahemalt 8 tahemarki pikk!";
					
				}else{
					$create_password_confirm = test_input($_POST["create_password_confirm"]);
				}
			}
				if(	$create_email_error == "" && $create_password_error == ""){
					
				$hash = hash("sha512", $create_password);
				
				echo "Voib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password. " ja rasi on".$hash;
				
				createUser($create_email, $hash, $firstname, $lastname);
		  }
		}
		
		
		
	}
	
	function test_input($data) {
		 $data = trim($data);
		 $data = stripslashes($data);
		 $data = htmlspecialchars($data);
		 return $data;
	}
	
?>
<html>
<head>
	<title>Login page</title>
</head>
<body>
	<h2>Log in</h2>
	
		<form action="login.php" method="post" >
			<input name="email1" type="email" placeholder="Email"> <?php echo $email_error; ?><br><br>
			<input name="password1" type="password" placeholder="Password"> <?php echo $password_error; ?><br><br>
			<input name="login" type="submit" value="Log in">
		</form>
		
	<h2>Create user</h2>
		<form action="login.php" method="post" >
			<input name="firstname" type="name" placeholder="First name"> <?php echo $firstname_error; ?>*<br><br>
			<input name="lastname" type="name" placeholder="Last name"> <?php echo $lastname_error; ?>*<br><br>
			<?php
			
			echo "<select name='sel_date'>";
			$i = 1;
			while ($i <= 31) {
				echo "<option value='" . $i . "'>$i</option>";
				$i++;
			}
			echo "</select>";
			
			echo "<select name='sel_month'>";
			$month = array(
				"Jan",
				"Feb",
				"Mar",
				"Apr",
				"May",
				"Jun",
				"Jul",
				"Aug",
				"Sep",
				"Oct",
				"Nov",
				"Dec"
			);
			foreach ($month as $m) {
				echo "<option value='" . $m . "'>$m</option>";
			}
			echo "</select>";
			
			echo "<select name='sel_year'>";
			$j = 1920;
			while ($j <= 2015) {
				echo "<option value='" . $j . "'>$j</option>";
				$j++;
			}
			echo "</select>";
			?><br><br>
			<input name="create_email" type="email" placeholder="Email"> <?php echo $create_email_error; ?>*<br><br>
			<input name="create_email_confirm" type="email" placeholder="Re-enter email"> <?php echo $create_email_confirm_error; ?>*<br><br>
			<input name="create_password" type="password" placeholder="Password"> <?php echo $create_password_error; ?>*<br><br>
			<input name="create_password_confirm" type="password" placeholder="Password"> <?php echo $create_password_confirm_error; ?>*<br><br>
			<input name="create" type="submit" value="Create">
		</form>
</body>
</html>