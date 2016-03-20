<?php
	//Lehe nimi
	$page_title = "Muuda töökohti";
	//Faili nimi
	$page_file = "editjobs.php";
?>
<?php
	require_once("../header.php");
	require_once ("../inc/functions.php");

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
	$job_array = $Job->getAdminData();

	if(isset($_SESSION['logged_in_user_id'])) {
		if($_SESSION['logged_in_user_group'] == 3) {
			if(isset($_GET["delete"])) {
				$Job->deleteJobData($_GET["delete"]);
			}

			if(isset($_GET["update"])) {
				$Job->updateJobData($_GET["job_id"], $_GET["job_name"], $_GET["job_company"], $_GET["job_desc"], $_GET["job_county"], $_GET["job_parish"], $_GET["job_location"], $_GET["job_address"]);
			}

			if(isset($_GET["activate"])) {
				$Job->activateData($_GET["activate"]);
			}

			if(isset($_GET["deactivate"])) {
				$Job->deactivateData($_GET["deactivate"]);
			}

		}
	}

	$droparray = $Job->parishDrop2();
	$jsarray = json_encode($droparray[0]);
	$jsarray_loc = json_encode($droparray[1]);

	if(isset($_GET["edit"])) {
		// leian valitud rea maakonna jm
		for($i = 0; $i < count($job_array); $i++){

			if($job_array[$i]->id == $_GET["edit"]){
				$selected_county = $job_array[$i]->county;
				$selected_parish = $job_array[$i]->parish;
				$selected_loc = $job_array[$i]->location;
				#echo('siin');
				#var_dump($job_array[$i]);
			}
		}

	}
?>


<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	<?php
		for($i = 0; $i < count($job_array); $i++) {
			echo '<div class="panel panel-default">';

			echo '<div class="panel-heading" role="tab" id="'.$job_array[$i]->id.'heading">';
			echo '<h4 class="panel-title">';
			if(isset($_GET["edit"]) && $_GET["edit"] == $job_array[$i]->id) {

				$currentcompany = $Job->editCompanyDropdown($job_array[$i]->id);
				//$currentcounty = $Job->editCountyDropdown($job_array[$i]->id);
				//$currentparish = $Job->editParishDropdown($job_array[$i]->id);
				//$currentlocation = $Job->editLocationDropdown($job_array[$i]->id);

				echo '<a class role="button" data-toggle="collapse" data-parent="#accordion" href="#'.$job_array[$i]->id.'content" aria-expanded="true" aria-controls="'.$job_array[$i]->id.'content">';
				echo $job_array[$i]->id.' '.$job_array[$i]->name.' '.$job_array[$i]->company;
				echo '</a>';
			} else {
				echo '<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#'.$job_array[$i]->id.'content" aria-expanded="false" aria-controls="'.$job_array[$i]->id.'content">';
				echo $job_array[$i]->id.' '.$job_array[$i]->name.' '.$job_array[$i]->company;
				echo '</a>';
			}
			echo '<div class="pull-right btn-group btn-group-xs" role="group">';
			echo '<a href="?edit='.$job_array[$i]->id.'" class="btn btn-default"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';

			if($job_array[$i]->active != NULL) {
				echo '<a title="Muuda töö ebaaktiivseks" href="?deactivate='.$job_array[$i]->id.'" class="btn btn-default"><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span></a>';
			} else {
				echo '<a title="Muuda töö aktiivseks" href="?activate='.$job_array[$i]->id.'" class="btn btn-default"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></a>';
			}

			echo '<a class="btn btn-default" onclick="confirmDelete('.$job_array[$i]->id.')"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
			echo '</div>';
			echo '</h4>';
			echo '</div>';
			if(isset($_GET["edit"]) && $_GET["edit"] == $job_array[$i]->id) {
				echo '<form action="editjobs.php" method="get">';
				echo '<div id="'.$job_array[$i]->id.'content" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="'.$job_array[$i]->id.'heading">';
				echo '<input type="hidden" name="job_id" value="'.$job_array[$i]->id.'">';
				echo '<div class="panel-body">';
				echo '<div class="col-sm-6">';
				echo '<div class="form-group">';
				echo '<label> Amet </label>';
				echo '<input class="form-control" type="text" name="job_name" value="'.$job_array[$i]->name.'">';
				echo '</div>';
				echo '</div>';

				echo '<div class="col-sm-6">';
				echo '<div class="form-group">';
				echo '<label> Ettevõte </label>';
				echo $currentcompany;
				echo '</div>';
				echo '</div>';

				echo '<div class="col-sm-12">';
				echo '<div class="form-group">';
				echo '<label> Kirjeldus </label>';
				echo '<textarea id="job_desc" class="form-control" rows="5" name="job_desc" type="text">'.$job_array[$i]->description.'</textarea>';
				echo '</div>';
				echo '</div>';

				echo '<div class="col-sm-6">';

				echo '<div class="form-group">';
				echo '<label> Maakond </label>';
				//echo $currentcounty;
				echo '<select name="job_county" id="job_county" class="form-control">';
				echo '<option>Vali vald</option>';
				echo '</select>';
				echo '</div>';

				echo '<div class="form-group">';
				echo '<label> Vald </label>';
				//echo $currentparish; //Muutmine
				echo '<select name="job_parish" id="job_parish" class="form-control">';
				echo '<option>Vali vald</option>';
				echo '</select>';
				echo '</div>';

				echo '</div>';


				echo '<div class="col-sm-6">';

				echo '<div class="form-group">';
				echo '<label> Asula </label>';
				echo '<select name="job_location" id="job_location" class="form-control">';
				echo '<option>Vali asula</option>';
				echo '</select>';
				//echo $currentlocation;
				echo '</div>';

				echo '<div class="form-group">';
				echo '<label> Aadress </label>';
				echo '<input class="form-control" type="text" name="job_address" value="'.$job_array[$i]->address.'">';
				echo '</div>';
				echo '<div class="pull-right btn-group" role="group">';
				echo '<button name="update" class="btn btn-success" type="submit"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>';
				echo '<a href="editjobs.php" class="btn btn-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo '</form>';

			} else {

				echo '<div id="'.$job_array[$i]->id.'content" class="panel-collapse collapse" role="tabpanel" aria-labelledby="'.$job_array[$i]->id.'heading">';

				echo '<div class="panel-body">';
				echo '<div class="col-sm-6">';
				echo '<div class="form-group">';
				echo '<label> Amet </label>';
				echo '<input class="form-control" type="text" placeholder="'.$job_array[$i]->name.'" readonly>';
				echo '</div>';
				echo '</div>';

				echo '<div class="col-sm-6">';
				echo '<div class="form-group">';
				echo '<label> Ettevõte </label>';
				echo '<input class="form-control" type="text" placeholder="'.$job_array[$i]->company.'" readonly>';
				echo '</div>';
				echo '</div>';

				echo '<div class="col-sm-12">';
				echo '<div class="form-group">';
				echo '<label> Kirjeldus </label>';
				echo '<textarea id="job_desc" class="form-control" rows="5" name="job_desc" type="text" placeholder="'.$job_array[$i]->description.'" readonly></textarea>';
				echo '</div>';
				echo '</div>';

				echo '<div class="col-sm-6">';

				echo '<div class="form-group">';
				echo '<label> Maakond </label>';
				echo '<input class="form-control" type="text" placeholder="'.$job_array[$i]->county.'" readonly>';
				echo '</div>';

				echo '<div class="form-group">';
				echo '<label> Vald </label>';
				echo '<input class="form-control" type="text" placeholder="'.$job_array[$i]->parish.'" readonly>';
				echo '</div>';

				echo '</div>';


				echo '<div class="col-sm-6">';

				echo '<div class="form-group">';
				echo '<label> Asula </label>';
				echo '<input class="form-control" type="text" placeholder="'.$job_array[$i]->location.'" readonly>';
				echo '</div>';

				echo '<div class="form-group">';
				echo '<label> Aadress </label>';
				echo '<input class="form-control" type="text" placeholder="'.$job_array[$i]->address.'" readonly>';
				echo '</div>';

				echo '</div>';

				echo '</div>';
				echo '</div>';
			}
			echo '</div>';

		}
	?>
</div>

<script>
	function confirmDelete(id) {
		var confirmation = confirm("Kas oled kindel, et soovid kustutada?");
		if (confirmation == true) {
			window.location = "?delete="+id;
		}
	};
</script>

<?php

	if(isset($_GET['edit'])):

?>

<script>
	window.onload = function(){


		var jsarray = JSON.parse('<?=$jsarray;?>');
		var jsarray_loc = JSON.parse('<?=$jsarray_loc;?>');

		var selected_county = '<?=$selected_county;?>';
		var selected_parish = '<?=$selected_parish;?>';
		var selected_loc = '<?=$selected_loc;?>';
		console.log(selected_county,selected_parish,selected_loc);

		console.log(jsarray_loc);

		var county_select = document.getElementById('job_county');
		var parish_select = document.getElementById('job_parish');
		var loc_select = document.getElementById('job_location');

		var list_of_countys = createListOfCountys(jsarray);

		console.log(list_of_countys);

		createDropDown(list_of_countys, county_select, selected_county);
		selected_county = null;
		for(var i = 0; i < jsarray.length; i++){
			if(jsarray[i].county == county_select.value){
				createDropDown(jsarray[i].parish, parish_select, selected_parish);
				selected_parish = null;
			}
		}

		//loc_select.innerHTML = '<option>Vali asula</option>';
		for(var i = 0; i < jsarray_loc.length; i++){
			if(jsarray_loc[i].parish == parish_select.value){
				createDropDown(jsarray_loc[i].location, loc_select, selected_loc);
				selected_loc = null;
			}
		}

		county_select.addEventListener('change', function(){
			console.log('valik muuutus '+ county_select.value);

			for(var i = 0; i < jsarray.length; i++){
				if(jsarray[i].county == county_select.value){
					createDropDown(jsarray[i].parish, parish_select, null);
				}
			}

			//loc_select.innerHTML = '<option>Vali asula</option>';
			for(var i = 0; i < jsarray_loc.length; i++){
				if(jsarray_loc[i].parish == parish_select.value){
					createDropDown(jsarray_loc[i].location, loc_select, null);
				}
			}

		});

		parish_select.addEventListener('change', function(){
			console.log('valik muuutus '+ parish_select.value);

			for(var i = 0; i < jsarray_loc.length; i++){
				if(jsarray_loc[i].parish == parish_select.value){
					createDropDown(jsarray_loc[i].location, loc_select, null);
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

	function createDropDown(array, element, selected){

		var html = '';

		for(var i = 0; i < array.length; i++){
			console.log(selected);
			if(selected && selected == array[i]){

				html+= '<option selected value="'+array[i]+'">'+

						array[i]+

					'</option>';

			}else{

				html+= '<option value="'+array[i]+'">'+

						array[i]+

					'</option>';

			}

		}

		element.innerHTML = html;

	}
</script>


<?php

	endif;

?>


<?php require_once("../footer.php"); ?>
