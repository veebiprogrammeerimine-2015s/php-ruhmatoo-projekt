<?php
	//Lehe nimi
	$page_title = "Avaleht";
	//Faili nimi
	$page_file = "index.php";
?>
<?php
	require_once("header.php");
	require_once ("inc/functions.php");
?>



<div class="row">
	<div class="col-xs-12 col-sm-4">
		<h3 id="statbar">Viimati lisatud tööd</h3>
		<ol>
			<?php
				//kõik tööd objektide kujul massiivis
				$job_array = $Job->getHomeData();
				//tööd ükshaaval läbi käia
				if (count($job_array) >= 5) {
					for($i = 0; $i < 5; $i++) {
						echo "<h4 id='jobname'><li>".$job_array[$i]->name."</li></h4><br>".$job_array[$i]->company.", ".$job_array[$i]->parish."<br>";
					}
				} elseif (count($job_array) < 5) {
						for($i = 0; $i < count($job_array); $i++) {
							echo "<h4 id='jobname'><li>".$job_array[$i]->name."</li></h4><br>".$job_array[$i]->company.", ".$job_array[$i]->parish."<br>";
					}

				}
			?>
		</ol>
	</div>
	<div class="col-xs-12 col-sm-4">
		<h3 id="statbar">Uudised</h3>
		<p>Siia kuvatakse uudised</p>
	</div>

	<div class="col-xs-12 col-sm-4">
		<h3 id="statbar">Stastistika</h3>
		<p>Hetkel on aktiivseid töid: <?php echo count($job_array);?></p>
		<p>Kokku on olnud töid: </p>
		<p>Kasutajaid on kokku: </p>
		<p>Uudiseid kokku: </p>
		<p>Täidetud CV: </p>
		<p>Esitatud CV: </p>
	</div>
</div>
<?php require_once("footer.php"); ?>
