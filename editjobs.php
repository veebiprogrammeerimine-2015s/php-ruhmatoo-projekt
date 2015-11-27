<?php
	//Lehe nimi
	$page_title = "Avaleht";
	//Faili nimi
	$page_file = "home.php";
?>
<?php
	require_once("header.php"); 
	require_once ("functions.php");
?>
<?php
	$job_array = $Job->getAllData();
?>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	<?php
		for($i = 0; $i < count($job_array); $i++) {
			echo '<div class="panel panel-default">';
			
			echo '<div class="panel-heading" role="tab" id="'.$job_array[$i]->id.'heading">';
			echo '<h4 class="panel-title">';
			echo '<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#'.$job_array[$i]->id.'content" aria-expanded="false" aria-controls="'.$job_array[$i]->id.'content">';
			echo $job_array[$i]->id.' '.$job_array[$i]->name.' '.$job_array[$i]->company;
			echo '</a>';
			echo '</h4>';
			echo '</div>';
			
			echo '<div id="'.$job_array[$i]->id.'content" class="panel-collapse collapse" role="tabpanel" aria-labelledby="'.$job_array[$i]->id.'heading">';
			echo '<div class="panel-body">';
			echo 'Formid tulevad siia<br>'.$job_array[$i]->description;
			echo '</div>';
			echo '</div>';
			
			echo '</div>';
		}
	?>
</div>

<?php require_once("footer.php"); ?>