<?php
	$page_title = "avaleht";
	$file_name = "home.php";
?>
#
<!--####################-->
<!--# DATABASE ÜHENDUS #-->
<!--####################-->
<?php
// ühenduse loomiseks kasuta
	require_once("../../../../configglobal.php");
	$database = "if15_kkkaur";
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
	//kopeerime header.php sisu
require_once("header.php");
?>

<?php echo $file_name; ?>
<br>
<br>
<ul>
	
	<?php if ($file_name == "home.php"){ ?>
	
		
		
	<?php } else { ?>	
	
	
	
	
	<?php } ?>
	
	
	
</ul>

<!--####################-->
<!--###### MENÜÜ #######-->
<!--####################-->
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
        <li><a href="top.php">Top baarid</a></li>
        <li><a href="critic.php">Kriitikule</a></li>
        <li class="dropdown">
          
        </li>
      </ul>
      
     
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<br>
<br>
<br>
<!--####################-->
<!--###### SISU ########-->
<!--####################-->
<div class="container-fluid"> 
<h1>Tere tulemast!</h1>

	<div class="row">
		<div class="col-md-offset-1 col-md-6 col-sm-8 ">
			<div class="jumbotron">
		
				<img src="pictures/kokteilid.jpg" alt="cocktails" width="500">
				<h1>King of cocktails</h1>
				<p>Tere kokteilisõber! Hakkame kultuurselt jooma!</p>
				<p><a class="btn btn-primary btn-lg" href="top10.php" role="button">Top 10 baarid</a></p>
				</div>
		</div>
		<div class=" col-md-offset-1 col-md-3 col-sm-4">
		<!-- SIIA MINGIT INFI -->
			<p>
			Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. Mingi äge info on siin ka veel. 
			</p>
		</div>
	</div>
</div>

<?php require_once("footer.php") ?>
