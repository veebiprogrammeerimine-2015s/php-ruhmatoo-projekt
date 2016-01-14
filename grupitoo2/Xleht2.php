
<?php
// ühenduse loomiseks kasuta
	require_once("../configglobal.php");
	$database = "if15_taunlai_";
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	

//echo $_POST["email"];

//defineerime muutujad
$first_name_error="";
$last_name_error="";
$user_name_error="";
$password_error="";
$email_error="";
//muutujad väärtuste jaoks
$first_name="";
$last_name="";
$user_name="";
$password ="";
$email="";
// kontrollin kas keegi vajutas nuppu
if($_SERVER["REQUEST_METHOD"] == "POST") {
//kontrollin kas keegi vajutas nuppu
if(isset($_POST["create"])){
		
			if( empty($_POST["first_name"])) {
				//jah oli tyhi
				$first_name_error = "See väli on kohustuslik";
				}else{
				$first_name = cleanInput($_POST["first_name"]);				
			}
			
			if( empty($_POST["last_name"])) {
				//jah oli tyhi
				$last_name_error = "See väli on kohustuslik";
				}else{
				$last_name = cleanInput($_POST["last_name"]);
			}
			
			if( empty($_POST["create_email"])) {
				//jah oli tyhi
				$email_error = "See väli on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["create_email"]);
			}
			
			if( empty($_POST["create_password"])) {
				//jah oli tyhi
				$password_error = "See väli on kohustuslik";
			}else {
				if(strlen($_POST["create_password"]) < 8) {
					$password_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$create_password = cleanInput($_POST["create_password"]);
				}
			}
			if(	$email_error == "" && $password_error == "" && $first_name_error == "" && $last_name_error == ""){
				echo "Võib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password;
			$password_hash = hash("sha512", $create_password);
				echo "<br>";
				echo $password_hash;
			$stmt = $mysqli->prepare("INSERT INTO user (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
				echo $mysqli->error;
				echo $stmt->error;
				
			//asendame kysimärgid muutujate väärtustega
				$stmt->bind_param("ssss", $first_name, $last_name, $create_email, $password_hash);
				$stmt->execute();
				$stmt->close();
			}
		} // create if end
	
	
}
  //paneme ühenduse kinni
  $mysqli->close();
  
  
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
?>

<?php
	$page_title = "Konto loomine";
	$file_name = "";
?>
<?php require_once("header.php"); ?>
	 <nav class="navbar navbar-inverse
navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php">Kings of cocktails</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Top 10 baarid <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Meist</a></li>
        <li class="dropdown">
          
        </li>
      </ul>
      
     
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<br>
<br>
	
	<h2> Kriitiku konto loomine</h2>
	<form action="leht2.php" method="post" >
	<input name="first_name" type="text" placeholder="Eesnimi"><?php echo $first_name_error ?> <br><br>
	<input name="last_name" type="text" placeholder="Perekonnanimi"><?php echo $last_name_error ?> <br><br>
	<input name="create_email" type="email" placeholder="E-post"><?php echo $email_error ?> <br><br>
	<input name="create_password" type="password" placeholder="Parool"><?php echo $password_error ?> <br><br>
	
	<input name="create" type="submit" value="Registreeri">
	</form>
	<br><br>
	
	
	
<?php require_once("footer.php"); ?>

