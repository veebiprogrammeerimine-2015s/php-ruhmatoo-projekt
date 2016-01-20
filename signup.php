<?php


	// Loon andmebaasi ühenduse
	require_once("functions.php");

	if(isset($_SESSION["logged_in_user_id"])){
		header("Location:data.php");
		
	}


		// LOGIN.PHP
		//echo $_POST["email"];
		//echo $_POST["password"];
		// errori muutujad peavad igal juhul olemas olema
		$email_error = "";
		$password_error= "";	
		$username_error= "";
		$create_email_error= "";
		$create_password_error="";
		
		//muutujad andmebaasi väärtuste jaoks
		$username= "";
		$email= "";
		$password="";
		$create_password="";
		$create_email="";
		
		
		//kontrollime et keegi vajutas input nuppu
		if($_SERVER["REQUEST_METHOD"] == "POST")  {
			//echo "keegi vajutas nuppu";
			
			//vajutas login nuppu
			if(isset($_POST["login"])){	
				
				
				
			
				//kontrollin et e-post ei oleks tühi
				
				if (empty($_POST["email"]) ) {
					$email_error = "See väli on kohustuslik";
				}else{
					$email = cleanInput($_POST["email"]);
					
				}
				
				//kontrollin, et parool ei ole tühi
				if (empty($_POST["password"]) ) {
					$password_error= "Kirjuta parool";
				} else {
					// kui oleme siia jõudnud, siis parool ei ole veel tühi
					// kontrollin
					if(strlen($_POST["password"]) < 8) {
					$password_error= "Peab olema vähemalt 8 tähemärki pikk"; 
					}else{
						
						$password = cleanInput($_POST["password"]);
					}
					
				}
			
				if($email_error== "" && $password_error == "") {
				
				
				
				$hash= hash("sha512", $password);
				loginUser($email, $hash);
				
				}
			
			}
			
			
			
			
			// keegi vajutas create nuppu	
			if(isset($_POST["create"])){
			
				
				
				if (empty($_POST["username"]) ) {
					$username_error = "Kirjuta oma kasutajanimi";
				
					
				}else{
					$username=cleanInput($_POST["username"]);
				}
				
				
		
				
				
				if (empty($_POST["create_email"]) ) {
					$create_email_error = "Kirjuta oma email";
				}else{
					$create_email = cleanInput($_POST["create_email"]);
					
				}
				
				
				if (empty($_POST["create_password"]) ) {
					$create_password_error= "Kirjuta parool";
				} else {
				
					if(strlen($_POST["create_password"]) < 8) {
						$create_password_error= "Peab olema vähemalt 8 tähemärki pikk"; 
					}else{
						
						$create_password = cleanInput($_POST["create_password"]);
					}
					
				}
				
				
			
		
				if ($create_email_error=="" && $create_password_error=="" && $username_error=="" ){
						
						$hash= hash("sha512", $create_password);
						
						
						
						createUser($username, $create_email, $hash);
						
					
				}
				
			}
			
		}
		
	function cleanInput($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
	}
	
?>
<?php
	$page_title = "Sisselogimise leht";
	$page_file_name="signup.php";

?>
<?php require_once("header.php"); ?>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">PHOTTLE</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="#">Front Page <span class="sr-only">(current)</span></a></li>
        <li><a href="about.php">About</a></li>
		<li><a href="forums.php">Foorum</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

	<h2>Loo kasutaja</h2>
		<form action="signup.php" method="post"> 
			<input name="username" type="text" placeholder="Kasutaja"><?php echo $username_error; ?><br></br>  
			<input name="create_email" type="email" placeholder="E-post"><?php echo $create_email_error;?> <br></br>
			<input name="create_password" type="password" placeholder="Parool"><?php echo $create_password_error;?> <br></br>
			<input name="create" type="submit" value="Loo kasutaja">
		</form>
<?php require_once("footer.php"); ?>	