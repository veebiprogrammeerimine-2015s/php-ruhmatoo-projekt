<?php
	//Lehe nimi
	$page_title = "CV saatmine";
	//Faili nimi
	$page_file = "sendresume.php";
?>
<?php
	require_once("../header.php");
	require_once ("../inc/functions.php");
?>
<?php

	$my_resumes = $Resume->getResumes($_SESSION['logged_in_user_id']);

	$motivation = "";
	$selected_resume = "";
	$current = $_SERVER['PHP_SELF'];
	$path = pathinfo($current);
	$file_to_trim = $path['basename'];
	$trimmed = rtrim($file_to_trim, ".php");
	$currentJob = $Job->singleJobData($trimmed);

  if(isset($_SESSION['logged_in_user_id'])) {
    if($_SESSION['logged_in_user_group'] == 1) {
      if( $_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["send_cv"])) {
					$selected_resume = cleanInput($_POST["my_resume"]) + 0;
          $motivation = cleanInput($_POST["motivation"]);
          $Resume->sendResume($trimmed, $_SESSION['logged_in_user_id'], $selected_resume, $motivation);
					#var_dump($motivation." ".$selected_resume," ".$trimmed);
        }
      }
    }
  }
?>
<div class="col-sm-6">
<h3>Töökuulutus</h3>
<div class="list-group">
  <div id="job_offer" class="list-group-item">
    <h4 class="list-group-item-heading"><strong><?=$currentJob->name;?></strong></h4>
    <p class="list-group-item-text"><?=$currentJob->company;?></p>
		<p style="height: 1px; margin: 9px 0; overflow: hidden; background-color: #e5e5e5;"></p>
		<p class="list-group-item-text"><?=$currentJob->description;?></p>
		<p style="height: 1px; margin: 9px 0; overflow: hidden; background-color: #e5e5e5;"></p>
		<p class="list-group-item-text"><?=$currentJob->county."<br>".$currentJob->parish."<br>".$currentJob->location."<br>".$currentJob->address;?></p>
  </div>
</div>

</div>

<div class="col-sm-6">
<h3>CV saatmine</h3>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<div class="list-group">
	  <div id="application" class="list-group-item">
			<label>Vali CV</label>
	    <select name="my_resume" class="form-control">
				<?php for($i = 0; $i < count($my_resumes); $i++){
					echo '<option value="'.$my_resumes[$i]->id.'">'.$my_resumes[$i]->name.'</option>';

				}?>
			</select>
			<p style="height: 1px; margin: 9px 0; overflow: hidden; background-color: #e5e5e5;"></p>
			<label>Motivatsioonikiri</label>
			<textarea class="form-control" rows="6" name="motivation" type="text"></textarea>
	  </div>
	</div>

</div>

<div class="col-sm-6">
	<br>

</div>

<div class="col-sm-6">
	<br>
	<button type="submit" name="send_cv" class="btn btn-success pull-right">
	  <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Saada CV
	</button>
</div>

</form>


<script>

	var job_height = document.getElementById("job_offer").offsetHeight;
	var application_height = document.getElementById("application").offsetHeight;

	if (job_height > application_height) {
		document.getElementById("application").style.height = job_height + "px";

	} else {
		document.getElementById("job_offer").style.height = application_height + "px";

	}


</script>




<?php require_once("../footer.php"); ?>
