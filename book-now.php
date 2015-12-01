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
	
	$getTimeInfo = $AvailableTimeDetails->getFreeTimesDetails(1);
	var_dump($getTimeInfo);
	$getDrAllDeseases = $AvailableTimeDetails->getDoctorDeseases(1);
	var_dump($getDrAllDeseases);
	$getDrOtherDayTimes = $AvailableTimeDetails->getDoctorDayTimes(1);
	var_dump($getDrOtherDayTimes);
	
?>



<?php
	//load footer
	require_once("footer.php");	
?> 
    