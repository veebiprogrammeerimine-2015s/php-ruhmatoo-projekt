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
	
	<p> <?php echo $AvailableTimes->getAllFreeTimes();?></p>


<!--main code end here -->  

<?php
	//load footer
	require_once("footer.php");	
?> 
    