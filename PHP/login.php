<?php
// ühenduse loomiseks kasuta
	require_once("../configglobal.php");
	$database = "if15_taunlai_";
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	

//echo $_POST["email"];

//defineerime muutujad
$email_error="";
$password_error="";

//kontrollin kas keegi vajutas nuppu
if($_SERVER["REQUEST_METHOD"]=="POST"){
	
	

// kontrollin mis nuppu vajutati
		if(isset($_POST["login"])){

	if(empty($_POST["email"])){
		//jah oli tühi
		$email_error = "See väli on kohustuslik";
}
else{

//puhastame muutuja võimalikest üleliigsetest sümbolitest
$email = cleanInput($_POST["email"]);
}
//kas parool on tühi
	//jah on tühi
if(empty($_POST["password"])){
		$password_error = "See väli on kohustuslik";
}
else{	
		$password = cleanInput($_POST["password"]);
		}
			// Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
				
				echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
				
				$password_hash = hash("sha512", $password);
				
				$stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
				$stmt->bind_param("ss", $email, $password_hash);
				
				//paneme vastuse muutujatesse
				$stmt->bind_result($id_from_db, $email_from_db);
				$stmt->execute();
				
				if($stmt->fetch()){
					//leidis
					echo "<br>";
					echo"Kasutaja id=".$id_from_db;
				}else{
					//tühi, ei leidnud, ju siis midagi valesti
					echo "<br>";
					echo "Wrong password or email!";
					
				}
				
				$stmt->close();
			}
	}
	
		}
		
	
	//Paneme ühenduse kinni
	$mysqli->close();
	
	
	
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
  	return $data;
  }
?>

<?php
	$page_title = "Login leht";
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
<!--####################-->
<!--#######Sisu#########-->
<!--####################-->
<div class="container-fluid"> 
<h1>Tere tulemast!</h1>

	<div class="row">
		
		
		<div class="col-md-offset-1 col-md-6 col-sm-8 ">
		<div class="jumbotron">
		  
		  <img src="pictures/kokteilid.jpg" alt="cocktails" width="500">
		  <h1>King of cocktails</h1>
		  <p>...</p>
		  <p><a class="btn btn-primary btn-lg" href="top10.php" role="button">Top 10 baarid</a></p>
		</div>
		</div>
		
		<div class=" col-md-offset-1 col-md-3 col-sm-4">




			<h2>Login</h2>
				<form action="login.php" method="post">
				<div class="form-group">
					<input class="form-control" name="email" type="email" placeholder="E-post"><?php echo $email_error ?> 
				</div>
				<div class="form-group">
				<input  class="form-control" name="password"type="password" placeholder="Parool" ><?php echo $password_error ?> 
				</div>
				<div class="form-group">
				<input  class="btn btn-success pull-right hidden-xs" name="login" type="submit" value="Logi sisse"> 
				</div>
				<div class="form-group">
				<input  class="btn btn-success visible-xs btn-block" name="login" type="submit" value="Logi sisse"> 
				</div>
				</form>
			<h2> <a href="leht2">Ei ole kriitik? <br>Saa kriitikuks!<br> </a> </h2>
	</div>
</div>
</div>






<?php require_once("footer.php"); ?>