<?php
	//load header
	require_once("header.php");
?> 
<!--main code start here --> 
   
<?php
	require_once("functions.php");
	require_once("AvailableTimeDetails.class.php");
	require_once("UserBookingManager.class.php");
	var_dump($_SESSION["id_from_db"]);
	/*if(isset($_SESSION["id_from_db"])){
		// suunan data lehele
		header("Location: home.php");
		exit();
	}*/
	
	// tuhjad muudujad
	$problem_description ='';
	
	
	// teeme uue instantsi class AvailableTimeDetails
	$AvailableTimeDetails = new AvailableTimeDetails($mysqli);
	$UserBookingManager = new UserBookingManager($mysqli);
	
	// tommame 
	if(isset($_GET["timeavailableid"])){
        $timeavailableid = $_GET["timeavailableid"];
    }
    
    
    //tommame kogu info
	$getTimeInfo = $AvailableTimeDetails->getFreeTimesDetails($timeavailableid);
	
	//kontrollime, kas ei tule null rida parameetri vastu
	if (isset($getTimeInfo->error)){
		// kui on,suunan error lehele
		header("Location: error.php");
		exit();
	
	}
		$hospidal_name = $getTimeInfo[0]->hospidal_name;
		$dr_name = $getTimeInfo[0]->dr_name;
		$area = $getTimeInfo[0]->area;
		$city = $getTimeInfo[0]->city;
		$address = $getTimeInfo[0]->address;
		$date_appoitmnt = $getTimeInfo[0]->date_appoitmnt;
	
		$getDrAllDeseases = $AvailableTimeDetails->getDoctorDeseases($timeavailableid);
		//var_dump($getDrAllDeseases);
		$getDrDayTimes = $AvailableTimeDetails->getDoctorDayTimes($timeavailableid);
		//var_dump($getDrDayTimes);
	
	
	
	// keegi chekkis radiobuttoni ja hakkab broneerima
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST["book-now"])){
					
					// kontrollime, kas kasutaja sisse loginud
					$log_in_info = $UserBookingManager->checkUserLogedIn();
					
					if (isset($log_in_info->error)){
						
						 $main_error = $log_in_info->error->message;
						
					}
					
					//kontrollime soovitava aja broneeringu staatust teeme ingegeriks
					$selected_available_time = (intval($_POST["selectedavailabletime"]));
					
					
					$time_status = $UserBookingManager->checkTimeStatus($selected_available_time);
					
					if (isset($time_status->error)){
						
						 $main_error = $time_status->error->message;
						
					}
					
					$problem_description = ($_POST["problemdescrpt"]);
					
		}
		
	
	}
	
	echo ($_SESSION["id_from_db"]."session id");
?>

<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>
<?php echo htmlspecialchars($_SERVER["QUERY_STRING"]);?>




<div class="container">
<?php if(isset($main_error)): ?>
		<?= $UserBookingManager->buildMainError($main_error) ;?>
	<?php endif; ?>
	<div class="row">
	
	
	
	<H1> Broneeringu detailandmed </h1>
  		<div class="col-md-3">
  			<h2>Kelle juurde </h2>
  			<label for="comment">Arsti nimi:</label>  <?php echo $dr_name ?>
  			<div class="form-group">
  		<form action="<?php // echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  				<label for="comment">Sisesta oma mure siia:</label>
  			<textarea class="form-control" rows="5" name="problemdescrpt" id="problem-descrition"></textarea>
			</div> 
		</div>
		<div class="col-md-3 ">
  			<h2>Millal </h2>
  			<label for="comment">Kuupäev:</label> <?php echo $date_appoitmnt; ?> <br>
  			<label for="comment">Vali sobiv aeg:</label>
  			<?php echo $AvailableTimeDetails->build_table($getDrDayTimes); ?>
  			<input type="submit" name="book-now" value="Broneeri valitud aeg">
  			</form>	
  			
  			
		</div> 
		<div class="col-md-3">
  			<h2>Asutus </h2>
  			<label for="comment">Asutuse nimi: </label>  <?php echo $hospidal_name ?></br>
  			<label for="comment">Aadress: </label> <?php echo $address.", ". $area.", ".$city;  ?></br>
		</div> 
	
				
  	</div>
</div>




<?php
	//load footer
	require_once("footer.php");	
?> 
    