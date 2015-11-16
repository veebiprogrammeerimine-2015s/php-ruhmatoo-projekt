<?php
    require_once("functions.php");
	require_once("../config_global.php");
	
	//Kui kasutaja ei ole sisse logitud, suuna teisele lehele
	//Kontrollin kas sessiooni muutuja on olemas
	
	if(!isset($_SESSION['logged_in_user_id'])) {
		header("Location: register.php");
		exit ();
	}
	
	if($_SESSION['logged_in_user_group'] == 1) {
		header("Location: noaccess.php");
		exit ();
	}

	
	//MUUTUJAD
	$job_name = $job_desc = $job_company = $job_county = $job_parish = $job_location = $job_address = "";
	$job_name_error = $job_desc_error = $job_company_error = $job_county_error = $job_parish_error = $job_location_error = $job_address_error = "";
	$response = "";
	$company_check = $Profile->companyCheck($_SESSION['logged_in_user_id']);
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
        
		if(isset($_POST["add_job"])){
			if (empty($_POST["job_company"])) {
				$job_company_error = "Asutus on kohustuslik";
			} else {
				$job_company = cleanInput($_POST["job_company"]);

			}
			if (empty($_POST["job_name"])) {
				$job_name_error = "Ameti nimi on kohustuslik";
			} else {
				$job_name = cleanInput($_POST["job_name"]);

			}
			if (empty($_POST["job_desc"])) {
				$job_desc_error = "Töö kirjeldus on kohustuslik";
			} else {
				$job_desc = cleanInput($_POST["job_desc"]);

			}
			if (empty($_POST["job_county"])) {
				$job_county_error = "Maakond on kohustuslik";
			} else {
				$job_county = cleanInput($_POST["job_county"]);

			}
			if (empty($_POST["job_parish"])) {
				$job_parish_error = "Vald on kohustuslik";
			} else {
				$job_parish = cleanInput($_POST["job_parish"]);

			}
			if (empty($_POST["job_location"])) {
				$job_location_error = "Asula on kohustuslik";
			} else {
				$job_location = cleanInput($_POST["job_location"]);

			}
			if (empty($_POST["job_address"])) {
				$job_address_error = "Aadress on kohustuslik";
				
			} else {
				$job_address = cleanInput($_POST["job_address"]);

			}
			
			//Errorite puudumisel käivitub funktsioon, mis sisestab andmebaasi
			if ($job_name_error == "" && $job_desc_error == "" && $job_company_error == "" && $job_county_error == "" && $job_parish_error == "" && $job_location_error == "" && $job_address_error == "") {
				//m - message, mis tuleb functions.php failist
				$response = $Job->createJob($job_company, $job_name, $job_desc, $job_county, $job_parish, $job_location, $job_address);
			}
			
      if (isset($response->success)) {
				//Vorm tühjaks
				$job_company = "";
				$job_name = "";
				$job_desc = "";
				$job_county = "";
				$job_parish = "";
				$job_location = "";
				$job_address = "";
			}   
				 
    }
            
  }
    
    
    // kirjuta fn 

	//Küsime tabeli kujul andmed
	$Job->getAllData();
	
?>

<?php
	//Lehe nimi
	$page_title = "Uus töökoht";
	//Faili nimi
	$page_file = "data.php";
?>

<?php require_once("header.php"); ?>

<div class="row">
	<div class="col-xs-12 col-md-4">
	<h2>Kirjeldus</h2>
	<pre class="pre-scrollable">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ornare sit amet erat id convallis. In hac habitasse platea dictumst. Sed a mauris sodales, tincidunt sapien non, hendrerit enim. Suspendisse potenti. Phasellus ut dui scelerisque, ultrices ex sed, fringilla dui. Ut fermentum enim sit amet sapien tristique, quis convallis nibh dapibus. Cras accumsan massa a augue elementum facilisis. Aenean dictum mauris ut erat rutrum faucibus. Praesent ac sollicitudin eros.

Quisque rutrum egestas sem at luctus. Etiam quis magna mollis, hendrerit ex a, facilisis neque. Donec sit amet hendrerit erat. Morbi maximus egestas massa. In diam metus, molestie a blandit non, lobortis eu purus. Mauris id sapien sit amet nibh auctor luctus. Curabitur pretium mauris id ullamcorper blandit. Donec non interdum ligula. Cras sit amet magna dui.
	</pre>
	</div>
		<?php if($company_check->name == ""): ?>
		<h2 class="col-xs-12 col-md-8">Lisa uus töökoht</h2>
		<div class="col-xs-12 col-md-8">
			<div class="alert alert-danger alert-dismissible fade in" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				<p>Palun täitke <a href="profile.php">profiilis</a> ettevõtte nimi!</p>
			</div>
		</div>
		<?php else: ?>
			<form class="col-xs-12 col-md-8" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
			<h2>Lisa uus töökoht</h2>

			  <?php if(isset($response->success)): ?>
				<div class="alert alert-success alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					<p><?=$response->success->message;?></p>
				</div>
			  
			  <?php elseif(isset($response->error)): ?>
				<div class="alert alert-danger alert-dismissible fade in" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
					<p><?=$response->error->message;?></p>
				</div>
			  <?php endif; ?>
			

			<div class="col-sm-6 col-md-6">
			<div class="form-group">
				<label for="job_name"> Amet </label>
				<input id="job_name"  class="form-control" name="job_name" type="text" value="<?=$job_name;?>"> <?=$job_name_error;?>
				</div>
				</div>
				<div class="col-sm-6 col-md-6">
				<div class="form-group">
				<label for="job_company"> Asutus </label>
				<?=$Job->companyReadOnly($_SESSION['logged_in_user_id']);?>
				</div>
				</div>
				<div class="col-sm-12 col-md-12">
				<div class="form-group">
				<label for="job_desc"> Töö kirjeldus </label>
				<textarea id="job_desc" class="form-control" rows="5" name="job_desc" type="text" value="<?=$job_desc;?>"></textarea> <?=$job_desc_error;?>
				</div>
				</div>
				
			<div class="col-sm-6 col-md-6">
			<div class="form-group">
				<label for="job_county"> Maakond </label>
				<?=$Job->countyDropdown();?>
			</div>
			
			<div class="form-group">
				<label for="job_parish"> Vald </label>
				<?=$Job->parishDropdown();?>
			</div>
			</div>
			
			<div class="col-sm-6 col-md-6">
			<div class="form-group">
				<label for="job_location"> Asula </label>
				<?=$Job->locationDropdown();?>
			</div>
			<div class="form-group">
				<label for="job_address"> Aadress </label>
				<input id="job_address" class="form-control" name="job_address" type="text" value="<?=$job_address;?>"> <?=$job_address_error;?>
			</div>
			</div>
			<div class="col-sm-12 col-md-12">
			<div class="form-group">
				<input type="submit" class="btn btn-success btn-block" name="add_job" value="Lisa">
			</div>	
			</div>	
			
			</form>
		<?php endif; ?>
	</div>
	
	
<?php require_once("footer.php"); ?>
	