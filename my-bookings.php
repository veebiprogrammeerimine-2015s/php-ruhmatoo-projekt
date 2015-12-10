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
		// suunan login lehele, kuna siin võib olla delikaatseid andmeid
		header("Location: login.php");
		exit();
	}
	
	// omistame probleemi
	
	$user_id = ($_SESSION["id_from_db"]);
	

	
	// teeme uued instantsi class AvailableTimeDetails
	$AvailableTimeDetails = new AvailableTimeDetails($mysqli);
	$UserBookingManager = new UserBookingManager($mysqli);
	
	//tommame kogu info
	$myUpcomingBookings = $UserBookingManager->getMyUpComingBookings($user_id);
	
	// todo
	//$myOldBookings = $UserBookingManager->getMyBookingHistory($user_id);
			
	
?>

<div class="container">
<?php if(isset($main_error)): ?>
		<?= buildMainError($main_error) ;?>
	<?php endif; ?>
	
<?php if(isset($main_success)): ?>
		<?= buildMainSuccess($main_success) ;?>
	<?php endif; ?>
	<div class="row">
	
	
	
	<H1> Minu tulevased broneeringud </h1>
  	
  			
	<?php echo $UserBookingManager->build_table($myUpcomingBookings); ?>
  	
		
	
				
  	</div>
</div>




<?php
	//load footer
	require_once("footer.php");	
?> 
    