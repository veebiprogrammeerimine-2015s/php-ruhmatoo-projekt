<?php
	//load header
	require_once("header.php");
?> 
<!--main code start here --> 
   
<?php
	require_once("functions.php");
	require_once("AvailableTimeDetails.class.php");
	require_once("UserBookingManager.class.php");
	
	if(!isset($_SESSION["id_from_db"])){
		// suunan data lehele
		header("Location: login.php");
		exit();
	}
	
	print_r( $_SESSION["return_url"]);
	echo "valitud aja id ";
	print_r ($_SESSION["selected_available_time"]);
	// omistame probleemi
	$problem_description = $_SESSION["problem_description"];
	var_dump($problem_description);
	
	// teeme uue instantsi class AvailableTimeDetails
	$AvailableTimeDetails = new AvailableTimeDetails($mysqli);
	$UserBookingManager = new UserBookingManager($mysqli);
	
	// tommame urlist id
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
		$session_start = $getTimeInfo[0]->time_start;
		$session_end = $getTimeInfo[0]->time_end;
	
		$getDrAllDeseases = $AvailableTimeDetails->getDoctorDeseases($timeavailableid);
		//var_dump($getDrAllDeseases);
		$getDrDayTimes = $AvailableTimeDetails->getDoctorDayTimes($timeavailableid);
		//var_dump($getDrDayTimes);
		
		//kontrollime soovitava aja broneeringu staatust teeme integeriks
					
					
					
		$time_status = $UserBookingManager->checkTimeStatus(intval($timeavailableid));
		if (isset($time_status->error)){
			$main_error = $time_status->error->message;
						
		}
	
	
	// keegi chekkis radiobuttoni ja hakkab broneerima
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST["book-now"])){
					
					// kontrollime, kas kasutaja sisse loginud
					$log_in_info = $UserBookingManager->checkUserLogedIn();
					
					if (isset($log_in_info->error)){
						
						 $main_error = $log_in_info->error->message;
						
					}
					
					$selected_available_time = (intval($_POST["selectedavailabletime"]));
					
					$problem_description = ($_POST["problemdescrpt"]);
					
		}
		
	
	}
	
?>

<div class="container">
<?php if(isset($main_error)): ?>
		<?= $UserBookingManager->buildMainError($main_error) ;?>
	<?php endif; ?>
	<div class="row">
	
	
	
	<H1> Broneeringu kinnitamine </h1>
  			<label for="comment">Arsti nimi:</label>  <?php echo $dr_name ?>
  			<div class="form-group">
  			<form action="<?php // echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  				<label for="comment">Mure:</label>  <?php echo $problem_description ?>
			</div> 
		
			<label for="comment">Asutuse nimi: </label>  <?php echo $hospidal_name ?></br>
  			<label for="comment">Aadress: </label> <?php echo $address.", ". $area.", ".$city;  ?></br>
  			
  			<label for="comment">Kuupäev:</label> <?php echo $date_appoitmnt; ?> <br>
  			<label for="comment">Algusaeg:</label> <?php echo $session_start; ?> <br>
  			<label for="comment">Lõpp:</label> <?php echo $session_end; ?> <br>
  			</br>
  			<input type="submit" name="book-now" value="Kinnita broneering">
  			</form>	
  			<?php if(isset($_SESSION["return_url"])): ?>
  				<?= createBackButton($_SESSION["return_url"]); //kutsume välja tagasi nupu  ?>
  			<?php endif; ?>
  			
		
		
  			
  			
		
	
				
  	</div>
</div>




<?php
	//load footer
	require_once("footer.php");	
?> 
    