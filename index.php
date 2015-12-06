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
	// otsingu jaoks tühjad muutujad
	$city = "";
	$area = "";
	$desease = "";
	if(isset($_GET["selectcity"])){
        $city = $_GET["selectcity"];
    }
	
	if(isset($_GET["selectarea"])){
        $area = $_GET["selectarea"];
    }
    if(isset($_GET["selectdesease"])){
        $desease = $_GET["selectdesease"];
    }
    
	// Tõmmame kõik vabad ajad linn, area , haigus
	$getAllTimes = $AvailableTimes->getAllFreeTimes($city, $area, $desease);
?>

<form> 
	<?php
	echo $AvailableTimes->createDropdownCity($getAllTimes, $city );
	
	echo $AvailableTimes->createDropdownArea($getAllTimes, $area);
	echo $AvailableTimes->createDropdownDesease($getAllTimes, $desease);
	
	
	?>
   <input value="otsi" type="submit">
</form>

	<?php echo $AvailableTimes->build_table($getAllTimes);?>
	
<!--main code end here -->  

<?php
	//load footer
	require_once("footer.php");	
?> 
    