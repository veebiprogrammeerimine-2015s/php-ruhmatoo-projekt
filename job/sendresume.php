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

  echo "Ettevõte:".$currentJob->company;
  echo "<br>Kandideerid ametile:".$currentJob->name;
  echo "<br>Töö kirjeldus:".$currentJob->description;
  echo "<h3>Asukoht:</h3><p>".$currentJob->county."<br>".$currentJob->parish."<br>".$currentJob->location."<br>".$currentJob->address."</p>";

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
<div class="col-sm-12">

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<label for="motivation">Motivatsioonikiri</label>
<textarea class="form-control" rows="6" name="motivation" type="text"></textarea>
</div>
<br>

<div class="col-sm-6">
	<br>
	<select name="my_resume" class="form-control">
		<?php for($i = 0; $i < count($my_resumes); $i++){
			echo '<option value="'.$my_resumes[$i]->id.'">'.$my_resumes[$i]->name.'</option>';

		}?>
	</select>
</div>

<div class="col-sm-6">
	<br>
	<button type="submit" name="send_cv" class="btn btn-success pull-right">
	  <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Saada CV
	</button>
</div>

</form>







<?php require_once("../footer.php"); ?>
