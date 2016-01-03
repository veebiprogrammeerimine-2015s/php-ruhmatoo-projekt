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
  $currentJob = $Job->singleJobData($_GET['id']);
  $current_id = $_GET['id'];
  echo $current_id;
  echo "Ettevõte:".$currentJob->company;
  echo "<br>Kandideerid ametile:".$currentJob->name;
  echo "<br>Töö kirjeldus:".$currentJob->description;
  echo "<h3>Asukoht:</h3><p>".$currentJob->county."<br>".$currentJob->parish."<br>".$currentJob->location."<br>".$currentJob->address."</p>";

  if(isset($_SESSION['logged_in_user_id'])) {
    if($_SESSION['logged_in_user_group'] == 1) {
      if( $_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["send_cv"])) {
          $motivation = cleanInput($_POST["motivation"]);
          $Resume->sendResume($current_id, $_SESSION['logged_in_user_id'], $motivation);

        }
      }
    }
  }
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<label for="motivation">Motivatsioonikiri</label>
<textarea class="form-control" rows="6" name="motivation" type="text"></textarea>
<br>
<button type="submit" name="send_cv" class="btn btn-success pull-right">
  <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Saada CV
</button>
</form>







<?php require_once("../footer.php"); ?>
