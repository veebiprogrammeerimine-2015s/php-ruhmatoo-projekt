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
	if($_SESSION['logged_in_user_group'] != 3) {
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
	$droparray = $Job->parishDrop2();
	$jsarray = json_encode($droparray[0]);
	
?>
<script>
	window.onload = function(){
		
		var jsarray = JSON.parse('<?=$jsarray;?>');
		console.log(jsarray);
		
		var county_select = document.getElementById('countyid2');
		var parish_select = document.getElementById('parishdrop');
		
		var list_of_countys = createListOfCountys(jsarray);
		
		console.log(list_of_countys);
		
		createDropDown(list_of_countys, county_select);
		
		county_select.addEventListener('change', function(){
			console.log('valik muuutus '+ county_select.value);
			
			for(var i = 0; i < jsarray.length; i++){
				if(jsarray[i].county == county_select.value){
					createDropDown(jsarray[i].parish, parish_select);
				}
			}
			
		});
	}
	
	function createListOfCountys(jsarray){
		
		var temp_array = [];
		for(var i = 0; i < jsarray.length; i++){
			temp_array.push(jsarray[i].county);
		}
		return temp_array;
	}
	
	function createDropDown(array, element){
		
		var html = '';
		for(var i = 0; i < array.length; i++){
			
			html+= '<option value="'+array[i]+'">'+ 
						
						array[i]+
			
					'</option>';
			
		}
		
		element.innerHTML = html;
		
	}
</script>

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
			<?=$Job->countyDropdown2();?>
		</div>
	</div>
	<div class="col-sm-6 col-md-12">
		<div class="form-group">
			<label for="parishdrop"> Vald </label>
			<select name="job_parish" id="parishdrop" class="form-control">
			  <option>Vali maakond</option>
			</select>
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

<?php
	require_once("footer.php");
?>