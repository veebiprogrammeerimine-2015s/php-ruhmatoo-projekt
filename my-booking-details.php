<?php
	//load header
	require_once("header.php");
?> 
<!--main code start here --> 
   
<?php
	require_once("functions.php");
	require_once("UserBookingManager.class.php");
	
	if(!isset($_SESSION["id_from_db"])){
		// suunan login lehele, kuna siin võib olla delikaatseid andmeid
		header("Location: login.php");
		exit();
	}
	
	// omistame probleemi
	
	$user_id = ($_SESSION["id_from_db"]);
		
	// teeme uue instantsi class
	$UserBookingManager = new UserBookingManager($mysqli);
	
	// tommame urlist id
	if(isset($_GET["bookingid"])){
        $booking_id = $_GET["bookingid"];
    }
    
    
    //tommame kogu info
	$getBookingDetail = $UserBookingManager->getBookingDetails($booking_id, $user_id);
			
			
		$hospidal_name = $getBookingDetail[0]->hospidal_name;
		$dr_name = $getBookingDetail[0]->dr_name;
		$area = $getBookingDetail[0]->area;
		$city = $getBookingDetail[0]->city;
		$address = $getBookingDetail[0]->address;
		$date_appoitmnt = $getBookingDetail[0]->date_appoitmnt;
		$session_start = $getBookingDetail[0]->time_start;
		$session_end = $getBookingDetail[0]->time_end;
		$desease = $getBookingDetail[0]->desease;
		$problem_description = $getBookingDetail[0]->problem_descr;
			
		
		//kontrollime soovitava aja broneeringu staatust juba broneeritud kellegi poolt, või minu
		// oma (success) broneeringutabelis,teeme integeriks
					

		$time_status = $UserBookingManager->checkTimeStatus(intval($timeavailableid));
		if (isset($time_status->error)){
			$booked_item_user_id = $UserBookingManager->getBookingUser(intval($timeavailableid));
			 // akki valitud aeg on minu oma
			if ($booked_item_user_id == $_SESSION["id_from_db"]){
				$main_success = "Minu poolt broneeritud suuname kasutaja minu broneeringute lehele";
				//booking id arraysse
				
			}
			else{
				$main_error = $time_status->error->message;
			}
		}
		
		$booked_item_user_id = $UserBookingManager->getBookingUser(intval($timeavailableid));
		
		var_dump($booked_item_user_id);
		
	// keegi tühistas bookingu otse lehelt
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST["cancel-booking"])){
			$UserBookingManager->cancelBooking($booking_id);
			
		}
		
	}
		
	
	
	// keegi chekkis radiobuttoni ja hakkab broneerima
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST["confirm-now"])){
					
					// kontrollime, kas kasutaja sisse loginud
					$log_in_info = $UserBookingManager->checkUserLogedIn();
					if (isset($log_in_info->error)){
						
						 $main_error = $log_in_info->error->message;
					}
					
					// kävitame broneerimis funktsiooni
					$result = $UserBookingManager->insertBooking(intval($timeavailableid), intval($user_id), intval($selected_desease_id), $problem_description);
					if (isset($result->error)){
						
						 $main_error = $result->error->message;
						
					}
					else{
						$main_success = $result->success->message;
					}
					
		}
		
	
	}
	
?>

<div class="container">
<?php if(isset($main_error)): ?>
		<?= buildMainError($main_error) ;?>
	<?php endif; ?>
	
<?php if(isset($main_success)): ?>
		<?= buildMainSuccess($main_success) ;?>
	<?php endif; ?>
	<div class="row">
	
	
	
	<H1> Minu broneeringu detailandmed </h1>
  			<label for="comment">Arsti nimi:</label>  <?php echo $dr_name ?>
  			<div class="form-group">
  			<form action="<?php // echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  				<label for="comment">Mure:</label>  <?php echo $problem_description ?> </br>
  				<label for="comment">Valdkond:</label>  <?php echo $desease ?>
			</div> 
		
			<label for="comment">Asutuse nimi: </label>  <?php echo $hospidal_name ?></br>
  			<label for="comment">Aadress: </label> <?php echo $address.", ". $area.", ".$city;  ?></br>
  			
  			<label for="comment">Kuupäev:</label> <?php echo $date_appoitmnt; ?> <br>
  			<label for="comment">Algusaeg:</label> <?php echo $session_start; ?> <br>
  			<label for="comment">Lõpp:</label> <?php echo $session_end; ?> <br>
  			</br>
  			<?php if(isset($main_success)): ?>
				<?= $UserBookingManager->buildCancelButton() ;?>
			<?php endif; ?>
			
			<?php if(!isset($main_error) & !isset($main_success)): ?>
				<?= $UserBookingManager->buildCancelButton() ;?>
			<?php endif; ?>
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
    