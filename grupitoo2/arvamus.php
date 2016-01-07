<?php
	$page_title = "Arvamus";
	$file_name = "arvamus.php";
?>
<?php
##################################### SEE LEHT ON PRAEGU SISULISELT KASUTU
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
			$stmt = $mysqli->prepare("INSERT INTO user (bar, cocktail, service, interior, price, rating, info) VALUES (?, ?, ?, ?, ?, ?, ?)");
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
  
  
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
?>

<html lang="et">
<head>
<meta charset="utf-8">
<title>Arvamus</title>

<body>

	

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
        <li class="active"><a href="top10.php">Top 10 baarid <span class="sr-only">(current)</span></a></li>
        <li><a href="meist.php">Meist</a></li>
        <li class="dropdown">
          
        </li>
      </ul>
      
     
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<br>
<br>


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
<?php require_once("footer.php") ?>