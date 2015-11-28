<?php
	//Lehe nimi
	$page_title = "Muuda töökohti";
	//Faili nimi
	$page_file = "editjobs.php";
?>
<?php
	require_once("header.php"); 
	require_once ("functions.php");
?>
<?php
	$job_array = $Job->getAllData();
	if(isset($_GET["update"])) {
		$Job->updateJobData($_GET["job_id"], $_GET["job_name"], $_GET["job_company"], $_GET["job_desc"], $_GET["job_county"], $_GET["job_parish"], $_GET["job_location"], $_GET["job_address"]);
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
				$currentcounty = $Job->editCountyDropdown($job_array[$i]->id);
				$currentparish = $Job->editParishDropdown($job_array[$i]->id);
				$currentlocation = $Job->editLocationDropdown($job_array[$i]->id);
				
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
			echo '<a href="?delete='.$job_array[$i]->id.'" class="btn btn-default"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
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
				echo $currentcounty;
				echo '</div>';
				
				echo '<div class="form-group">';
				echo '<label> Vald </label>';
				echo $currentparish;
				echo '</div>';
				
				echo '</div>';
				
				
				echo '<div class="col-sm-6">';
				
				echo '<div class="form-group">';
				echo '<label> Asula </label>';
				echo $currentlocation;
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

<?php require_once("footer.php"); ?>