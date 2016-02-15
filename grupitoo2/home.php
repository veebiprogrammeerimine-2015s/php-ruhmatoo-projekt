<?php
	$page_title = "avaleht";
	$file_name = "home.php";
?>

<?php
	//kopeerime header.php sisu
	//../ naitab, et fail asub uhe kasuta vorra valjaspool
require_once("header.php");
?>

	

<html>
<title>Pealeht</title>
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
		<div class=" col-md-offset-1 col-md-3 col-sm-4"></div>


	</div>



</div>
</html>
<?php require_once("footer.php") ?>





<?php
require_once("footer.php");
?>