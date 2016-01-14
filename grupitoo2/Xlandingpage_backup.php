<?php
	//kopeerime header.php sisu
	//../ naitab, et fail asub uhe kasuta vorra valjaspool
require_once("header.php");
?>



<?php
	$page_title = "maandumisleht";
	$file_name = "pandingpage.php";
?>


<?php

##################################### MAANDUMISLEHT ON HETKEL VEEL KATKI. TÖÖTAN SELLE KALLAL, ET SAADA SISESTADA ANDMEID TABELISSE JA TABELITEST INFOT KÄTTE SAADA
##################################### SISSELOGIMINE JA UUE KASUTAJA REGISTREERIMINE TÖÖTAB


	//********************ENDA***************************************

// 1) $_session["nimi"]; - serveris mingi osa mälust on eraldatud sellele kasutajale (sessioonile). Brauser kinni = sess läbi
// 2) $_cookie["nimi"]; - paned brauseri akna kinni, sess jääb ikka lahti. Avad brauseri ja oled ikka sisse logitud


	//laen funktsioonid failis
	require_once("functions.php");
	//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		//suunan login lehele
		header("Location: login.php");
		
		
	}	
	if(isset($_GET["logout"])){
		//sessdestroy kustutab kõik sessi muutujad
		session_destroy();
		header("Location: home.php");
	}
#################################### CARPLATES ALGUS ##########################################
	//määran ära errorid vms
	$number_plate = $color = $number_plate_error = $color_error = "";	

	if(isset($_POST["create"])){
			if ( empty($_POST["number_plate"]) ) {
				$number_plate_error = "See väli on kohustuslik";
			}else{
				$number_plate = cleanInput($_POST["number_plate"]);
			}
			if ( empty($_POST["color"]) ) {
				$color_error = "See väli on kohustuslik";
				}else{
					$color = cleanInput($_POST["color"]);
				}
			if(	$number_plate_error == "" && $color_error == ""){	
				//msg on message funktsioonist, msi tagasi saadame
				$msg = createCarPlate($number_plate, $color);	
				if($msg !=""){
					//salv õnnestus
					//teen tyhjaks input value'd ehk väljad
					$number_plate = "";
					$color = "";
					
				}
			echo $msg;
			}
		}	
     // create if end
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	  }
?>
<p>
Tere, <?php echo $_SESSION["user_email"]; ?> 
</p>

<!-- "<?php echo $_SESSION["user_email"]; ?>" saaks ka lühemalt "<?=$_SESSION["user_email"];?>" -->
<p>
<a href="?logout=1">Logi välja</a>
</p>

 <h2>Lisa auto</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="number_plate" >auto nr</label><br>
	<input id="number_plate" name="number_plate" type="text" value="<?=$number_plate; ?>"> <?=$number_plate_error; ?><br><br> 
  	<label>värv</label><br>
	<input name="color" type="text" value="<?=$color; ?>"> <?=$color_error; ?><br><br>
  	<input type="submit" name="create" value="Salvesta">
  </form>
<!-- #################################### CARPLATES LÕPP ########################################## -->
<?php
// ühenduse loomiseks kasuta
	require_once("../../../../config.php");
	$database = "if15_taunlai_";
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	

//defineerime muutujad
$bar_error="";
$cocktail_error="";
$service_error="";
$interior_error="";
$price_error="";
$rating_error="";
$info_error="";
//muutujad väärtuste jaoks
$bar="";
$cocktail="";
$service="";
$interior="";
$price="";
$rating="";
$info="";
// kontrollin kas keegi vajutas nuppu
if($_SERVER["REQUEST_METHOD"] == "POST") {
//kontrollin kas keegi vajutas nuppu
		if(isset($_POST["create"])){
		
			if( empty($_POST["bar"])) {
				//jah oli tyhi
				$bar_error = "See väli on kohustuslik";
				}else{
				$bar = cleanInput($_POST["bar"]);				
			}
			
			if( empty($_POST["cocktail"])) {
				//jah oli tyhi
				$cocktail_error = "See väli on kohustuslik";
				}else{
				$cocktail = cleanInput($_POST["cocktail"]);
			}
			
			if( empty($_POST["service"])) {
				//jah oli tyhi
				$service_error = "See väli on kohustuslik";
			}else{
				$service = cleanInput($_POST["service"]);
			}
			
			if( empty($_POST["interior"])) {
				//jah oli tyhi
				$interior_error = "See väli on kohustuslik";
			}else{
				$interior = cleanInput($_POST["interior"]);
			}
			if( empty($_POST["price"])) {
				//jah oli tyhi
				$price_error = "See väli on kohustuslik";
			}else{
				$price = cleanInput($_POST["price"]);
			}
			if( empty($_POST["rating"])) {
				//jah oli tyhi
				$rating_error = "See väli on kohustuslik";
			}else{
				$rating = cleanInput($_POST["rating"]);
			}
			if( empty($_POST["info"])) {
				//jah oli tyhi
				$info_error = "See väli on kohustuslik";
			}else{
				$info = cleanInput($_POST["info"]);
			}
			}
			if(	$bar_error == "" && $cocktail_error == "" && $service_error == "" && $interior_error == "" && $price_error == "" && $rating_error == "" && $info_error == ""){
				echo "Arvamus sisestatud!";
			$stmt = $mysqli->prepare("INSERT INTO jook (bar, cocktail, service, interior, price, rating, info) VALUES (?, ?, ?, ?, ?, ?, ?)");
				echo $mysqli->error;
				echo $stmt->error;
				
			//asendame kysimärgid muutujate väärtustega
				$stmt->bind_param("sssssss", $bar, $cocktail, $service, $interior, $price, $rating, $info);
				$stmt->execute();
				$stmt->close();
			}
		} // create if end
	
	

  //paneme ühenduse kinni
  $mysqli->close();
  
  

#	function cleanInput($data) {
#		$data = trim($data);
#		$data = stripslashes($data);
#		$data = htmlspecialchars($data);
#		return $data;
#	  }
?> 
  

<html lang="et">
<head>
<meta charset="utf-8">
<title>Kriitiku leht</title>

<body>

	


<form method="post">
		<h3>Arvamuse lisamine</h3>
		<form action="arvamus.php" method="post">
		<div class="form-group">
				<input class="form-control" name="Baar" type="name" placeholder="Baar"><?php echo $bar_error ?> 
		</div>
		<div class="form-group">
				<input  class="form-control" name="Kokteil"type="name" placeholder="Kokteil" ><?php echo $cocktail_error ?> 
		</div>
		<div class="form-group">
				<input class="form-control" name="Teenindus" type="name" placeholder="Teenindus"><?php echo $service_error ?> 
		</div>
		<div class="form-group">
				<input  class="form-control" name="Interjöör"type="name" placeholder="Interjöör" ><?php echo $interior_error ?> 
		</div>
		<div class="form-group">
				<input class="form-control" name="Hind" type="name" placeholder="Hind"><?php echo $price_error ?> 
		</div>
		<div class="form-group">
				<input  class="form-control" name="Lõpphinne"type="name" placeholder="Lõpphinne" ><?php echo $rating_error ?> 
		</div>
		<div class="form-group">
				<input  class="form-control" name="Lisainfo"type="name" placeholder="Lisainfo" ><?php echo $info_error ?> 
		</div>
		<div class="form-group">
				<input  class="btn btn-success pull-right hidden-xs" name="submit" type="submit" value="Lisa arvustus"> 
		</div>
		</form>

</body>

</body>
</html>


<?php
######################################## TEST ENDA CRITIC SISESTUSFUNKTSIOON ###################################################
	$critic = "";
	$critic_error = "";
	// et ei ole tühjad
	// clean input
	// salvestate
	
	if(isset($_POST["create"])){

		if ( empty($_POST["create_critic"]) ) {
			$critic_error = "See väli on kohustuslik";
		}else{
			$critic = cleanInput($_POST["critic"]);
		}

		if(	$critic_error == ""){
			
			// functions.php failis käivina funktsiooni
			insertreview($critic);			
		}
    } // create if end
######################################## TEST ENDA CRITIC SISESTUSFUNKTSIOON ###################################################
	

	
	
	
?>

<p>
	Tere, <?=$_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

 <h2>Critic</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="critic" >Critic</label><br>
	<input id="critic" name="critic" type="text" value="<?=$critic; ?>"> <?=$critic_error; ?><br><br>
  	<input type="submit" name="create_critic" value="Salvesta">
  </form>

  
  
 <?php require_once("footer.php") ?>