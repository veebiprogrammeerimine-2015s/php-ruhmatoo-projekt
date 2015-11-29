<?php
	//load header
	require_once("header.php");
?> 
<!--main code start here --> 
   
<?php
	require_once("functions.php");
	require_once("AvailableTimes.class.php");
	
	// teeme uue instantsi class AvailableTimes
	$AvailableTimes = new AvailableTimes($mysqli);
?>
	
	
<?php
	// Tõmmame kõik vabad ajad
	$getAllTimes = $AvailableTimes->getAllFreeTimes("Tallinn","Kesklinn", "Suguhaigused");
	echo $AvailableTimes->createDropdownCity($getAllTimes);
	
	echo $AvailableTimes->createDropdownArea();
	echo $AvailableTimes->createDropdownDesease();
	
	echo $AvailableTimes->build_table($getAllTimes);
	
	
?>

<!--main code end here -->  

<?php
	//load footer
	require_once("footer.php");	
?> 
    