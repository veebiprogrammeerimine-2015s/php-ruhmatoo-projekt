<?php require_once("functions.php"); 

require_once("../classes/Confirm.class.php");
	
require_once("../classes/InterestManager.class.php");	

	if(!isset($_SESSION['logged_in_user_id'])){
    header("Location: login.php");
    }
	
	if(isset($_GET["logout"])){
	//kustutame sessiooni muutujad
	session_destroy();
	header("Location: login.php");
    }

$InterestManager = new InterestManager($mysqli, $_GET["id"]);
	
	$Confirm = new Confirm($mysqli);
	$contest_array = $Confirm->getAllData();
?>

<?php 
    // lehe nimi
    $page_title = "Kasutaja info";

?>

<?php
    require_once("../header.php");
?>
	
<br><br>

<div class="container">
	<div class="row">
		<div class="box">
			<div class="col-lg-12">
				<hr>
				<h2 class="intro-text text-center">Kasutaja tulemused
				</h2>
				<hr>

				<table class="table table-condensed">

				<tr>
					<th>Osaleja nimi</th>
					<th>Võistlus</th>
					<th>Tulemus</th>
					<th>Hinda võistlust</th>
					<th>Kommentaarid</th>
				</tr>
				<?php
				//osalejad ükshaaval läbi käia
				for($i = 0; $i < count($contest_array); $i++){ //SIIN ON MIDAGI VALESTI? 
				//tabelis ainult esimesel viskab selle rea ette kinnituslehel

				if($contest_array[$i]->user_id == $_GET["id"]){
				//kasutaja tahab rida muuta
				//lihtne vaade
				echo "<tr>";
				echo "<td>".$contest_array[$i]->user."</td>";
				echo "<td>".$contest_array[$i]->contest_name."</td>";
				echo "<td>".$contest_array[$i]->result."</td>";
				echo "<td>".$contest_array[$i]->grade."</td>";
				echo "<td>".$contest_array[$i]->run_comment."</td>";
				echo "</tr>";

				}

				}

				?>

			</table>

			<br>

	<div class="row">
		<div class="col-lg-12">
			<hr>
			<h2 class="intro-text text-center">Huvid
			</h2>
			<hr>
		</div>
	</div>

				<?=$InterestManager->getUserInterests();?>
			</div>
		</div>
	</div>
</div>

<?php require_once("../footer.php"); ?> 

