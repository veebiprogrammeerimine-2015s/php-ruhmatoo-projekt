<?php
	//load header
	require_once("header.php");
?> 
<!--main code start here --> 
   
<?php
	require_once("functions.php");
	require_once("AvailableTimeDetails.class.php");
	require_once("UserBookingManager.class.php");
	
	
	echo "session id: ";
	
	print_r($_SESSION["id_from_db"]);
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
	
	
	// tommame urlist id
	if(isset($_GET["timeavailableid"])){
        $timeavailableid = $_GET["timeavailableid"];
    }
    
    
    //tommame kogu info
	$getTimeInfo = $AvailableTimeDetails->getFreeTimesDetails($timeavailableid);
	// tõmmame arsti haigused, millega tegeleb
	$getDrDeseaes = $AvailableTimeDetails->getDoctorDeseases($timeavailableid);
	
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
					// votame vormidelt vaartused
					$selected_available_time = (intval($_POST["selectedavailabletime"]));
					$selected_desease_id = (intval($_POST["selectdesease"]));
					$problem_description = ($_POST["problemdescrpt"]);
					$_SESSION["selected_available_time"] = $selected_available_time ;
					$_SESSION["problem_description"] = $problem_description;
					$_SESSION["selected_desease"] = $selected_desease_id;
					// kontrollime, kas kasutaja sisse loginud 
					$log_in_info = $UserBookingManager->checkUserLogedIn();
					if (isset($log_in_info->error)){
						
						 $main_error = $log_in_info->error->message;
						
						}
					
					//kontrollime soovitava aja broneeringu staatust teeme integeri			
					$time_status = $UserBookingManager->checkTimeStatus(intval($_SESSION["selected_available_time"]));
					if (isset($time_status->error)){
						$main_error = $time_status->error->message;	
						
					}
					
					if(empty($_POST["problemdescrpt"])){
						$main_error = "Sisest palun oma mure";
					}
					
					if(empty($_POST["selectdesease"])){
						$main_error = "vali palun haigus";
					}
					
					
					//jõudsime siia, suuname kasuataja kinnituslehele ja salvestame return aadressi
					
					if($main_error == ""){
					
						
					
						$return_url =  htmlspecialchars($_SERVER["PHP_SELF"]);
						$return_url .="?";
						$return_url .= 'timeavailableid='.($_SESSION["selected_available_time"]);
					
						$_SESSION["return_url"] = $return_url;
					
						header("Location:book-confirmation.php?timeavailableid=".$_SESSION["selected_available_time"]);
					}
		}
		
	
	}
	//kontrollime soovitava aja broneeringu staatust teeme integeri			
		$time_status = $UserBookingManager->checkTimeStatus(intval($timeavailableid));
		if (isset($time_status->error)){
			$main_error = $time_status->error->message;
						
		}
?>

<?php// echo htmlspecialchars($_SERVER["PHP_SELF"]);?>
<?php //echo htmlspecialchars($_SERVER["QUERY_STRING"]);?>




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
  				<label for="comment">Sisesta haiguse valdkond:</label>
  				<?php echo $AvailableTimeDetails->createDropdownDesease($getDrDeseaes); ?>
  				
  				<label for="comment">Sisesta oma mure siia:</label>
  			<textarea class="form-control" rows="5" name="problemdescrpt" id="problem-descrition"  ><?php echo $_SESSION["problem_description"] ?></textarea>
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
    