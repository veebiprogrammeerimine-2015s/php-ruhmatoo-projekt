<?php
	//Lehe nimi
	$page_title = "Sisesta";
	//Faili nimi
	$page_file = "insert.php";
	require_once("header.php");
	require_once("functions.php");
	
	if(!isset($_SESSION['logged_in_user_id'])) {
	header("Location: register.php");
	exit ();
	}
	if($_SESSION['logged_in_user_group'] == 1 || $_SESSION['logged_in_user_group'] == 2) {
	header("Location: noaccess.php");
	exit ();
	}
?>
<?php
	$job_county = $job_parish = $job_location = "";
	$job_county_error = $job_parish_error = $job_location_error = "";
	$response = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){		
		if(isset($_POST["add_county"])){
			if (empty($_POST["job_county"])) {
				$job_county_error = "Maakond on kohustuslik";
			} else {
				$job_county = cleanInput($_POST["job_county"]);
			}

			if ($job_county_error == "") {
				$response = $Insert->insertCounty($job_county);
			}
			
			if (isset($response->success)) {
				$job_county = "";
			} 
			
		}
		
		if(isset($_POST["add_parish"])){
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
			
			if ($job_county_error == "" && $job_parish_error == "") {
				$response = $Insert->insertParish($job_county, $job_parish);
			}
			
			if (isset($response->success)) {
				$job_parish = "";
			} 
			
		}
		
		if(isset($_POST["add_location"])){
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
			
			if ($job_county_error == "" && $job_parish_error == "" && $job_location_error == "") {
				$response = $Insert->insertLocation($job_county, $job_parish, $job_location);
			}
			
			if (isset($response->success)) {
				$job_location = "";
			} 
			
		}
	}
	#$droparray = $Job->parishDrop2();
?>
<!--
<script>
function populate(cdrop, pdrop) {
	var cdrop = document.getElementById(cdrop);
	var pdrop = document.getElementById(pdrop);
	pdrop.innerHTML = "";
	console.log(array);
	
	for(i = 0; i < ; i++) {
		if(cdrop.value == array[i]) {
			
			var optionArray = ["esimene|Esimene", "teine|Teine"]
	}
		
	}
	

	for(var option in optionArray) {
		var pair = optionArray[option].split("|");
		var newOption = document.createElement("option");
		newOption.value = pair[0];
		newOption.innerHTML = pair[1];
		pdrop.options.add(newOption);
	}
}
</script>

<?php #var_dump ($droparray); ?>
<select id="countydrop" name="countydrop" onchange="populate(this.id,'parishdrop')">
<option selected value="">Vali maakond</option>
<?#=$Job->countyDropdown2();?>
</select>


<select id="parishdrop">
  <option>Vali vald</option>
</select>-->



<div class="col-xs-12">
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
</div>

<form class="col-xs-12 col-md-4" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<div class="col-sm-6 col-md-12">
	<h3>Uus maakond</h3>
		<div class="form-group">
			<label for="job_county"> Maakond </label>
			<input id="job_county" class="form-control" name="job_county" type="text" value="<?=$job_county;?>"> <?=$job_county_error;?>
		</div>
	</div>
	<div class="col-sm-6 col-md-12">
		<div class="form-group">
			<label> Vald </label>
			<input class="form-control" readonly>
		</div>
	</div>
	<div class="col-sm-6 col-md-12">
		<div class="form-group">
			<label> Asula </label>
			<input class="form-control" readonly>
		</div>
	</div>
	<div class="col-sm-6 col-md-12">
		<div class="form-group">
			<input type="submit" class="btn btn-success btn-block" name="add_county" value="Lisa">
		</div>	
	</div>
</form>

<form class="col-xs-12 col-md-4" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<div class="col-sm-6 col-md-12">
	<h3>Uus vald</h3>
		<div class="form-group">
			<label for="job_county"> Maakond </label>
			<?=$Job->countyDropdown();?>
		</div>
	</div>
	<div class="col-sm-6 col-md-12">
		<div class="form-group">
			<label for="job_parish"> Vald </label>
			<input id="job_parish" class="form-control" name="job_parish" type="text" value="<?=$job_parish;?>"> <?=$job_parish_error;?>
		</div>
	</div>
	<div class="col-sm-6 col-md-12">
		<div class="form-group">
			<label> Asula </label>
			<input class="form-control" readonly>
		</div>
	</div>
	<div class="col-sm-6 col-md-12">
		<div class="form-group">
			<input type="submit" class="btn btn-success btn-block" name="add_parish" value="Lisa">
		</div>	
	</div>
</form>

<form class="col-xs-12 col-md-4" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<div class="col-sm-6 col-md-12">
	<h3>Uus asula</h3>
		<div class="form-group">
			<label for="job_county"> Maakond </label>
			<?=$Job->countyDropdown();?>
		</div>
	</div>
	<div class="col-sm-6 col-md-12">
		<div class="form-group">
			<label for="job_parish"> Vald </label>
			<?=$Job->parishDropdown();?>
		</div>
	</div>
	<div class="col-sm-6 col-md-12">
		<div class="form-group">
			<label for="job_location"> Asula </label>
			<input id="job_location" class="form-control" name="job_location" type="text" value="<?=$job_location;?>"> <?=$job_location_error;?>
		</div>
	</div>
	<div class="col-sm-6 col-md-12">
		<div class="form-group">
			<input type="submit" class="btn btn-success btn-block" name="add_location" value="Lisa">
		</div>	
	</div>
</form>
<script>

    var countyvalue = document.getElementById("#countyid").value;
    if (countyvalue == <?php $county ?>) {
		console.log ("Tere");
	}
	

</script>

<?php
	require_once("footer.php");
?>