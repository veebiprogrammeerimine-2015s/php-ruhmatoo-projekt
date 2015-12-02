<?php
	//load header
	require_once("header.php");
?> 
<!--main code start here --> 
   
<?php
	require_once("functions.php");
	require_once("AvailableTimeDetails.class.php");
	
	// teeme uue instantsi class AvailableTimeDetails
	$AvailableTimeDetails = new AvailableTimeDetails($mysqli);
	if(isset($_GET["timeavailableid"])){
        $timeavailableid = $_GET["timeavailableid"];
    }
	$getTimeInfo = $AvailableTimeDetails->getFreeTimesDetails($timeavailableid);
	//var_dump($getTimeInfo);
	$getDrAllDeseases = $AvailableTimeDetails->getDoctorDeseases($timeavailableid);
	//var_dump($getDrAllDeseases);
	$getDrDayTimes = $AvailableTimeDetails->getDoctorDayTimes($timeavailableid);
	//var_dump($getDrDayTimes);
	
	
?>
<div class="container">
	<div class="row">
	<H1> Broneeringu detailandmed </h1>
  		<div class="col-md-3">
  			<h2>Kelle juurde </h2>
  			<label for="comment">Arsti nimi:</label>
  			<div class="form-group">
  				<label for="comment">Sisesta oma mure siia:</label>
  			<textarea class="form-control" rows="5" id="problem-descrition"></textarea>
			</div> 
		</div>
		<div class="col-md-3 ">
  			<h2>Millal </h2>
  			<label for="comment">Kuupäev:</label> <br>
  			<label for="comment">Vali sobiv aeg:</label>
  			<?php echo $AvailableTimeDetails->build_table($getDrDayTimes); ?>
  			
  			
  			
		</div> 
		<div class="col-md-3">
  			<h2>Asutus </h2>
  			<label for="comment">Asutuse nimi:</label>
  			<label for="comment">Aadress:</label>
  			
  
		</div> 				
  	</div>
</div>




<?php
	//load footer
	require_once("footer.php");	
?> 
    