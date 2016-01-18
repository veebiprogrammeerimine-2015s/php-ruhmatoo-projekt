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
<?php
	$job_array = $Misc->getJobs();
	$news = $Misc->getNews();



?>



<div class="row">
	<div class="col-xs-12 col-sm-4">
		<h3 id="statbar">Viimati lisatud tööd</h3>
		<ol>
			<?php
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
		<?php
		if (count($job_array) >= 5) {
				for($i = 0; $i < 5; $i++) {
					echo "<h4 id='jobname'>".$news[$i]->subject."</h4><br>".$news[$i]->category.", ".$news[$i]->posted."<br>";
					echo '<p>'.$news[$i]->text.'</p>';
			}
		} else {
				for($i = 0; $i < count($news); $i++) {
					echo "<h4 id='jobname'>".$news[$i]->subject."</h4><br>".$news[$i]->category.", ".$news[$i]->posted."<br>";
					echo '<p>'.$news[$i]->text.'</p>';
			}
		}

		?>
	</div>

	<div class="col-xs-12 col-sm-4">
		<h3 id="statbar">Stastistika</h3>
		<p>Hetkel on aktiivseid töid: <?php echo count($job_array);?></p>
		<p>Kokku on olnud töid: <?php echo count($Misc->getDeleted());?></p>
		<p>Kasutajaid on kokku: <?php echo count($Admin->getUsers());?> </p>
		<p>Uudiseid kokku: <?php echo count($Misc->countNews());?></p>
		<p>Loodud CVsi: <?php echo count($Misc->getResumes());?></p>
		<p>Kandideerimisi: <?php echo count($Misc->getSentResumes());?></p>
	</div>
</div>
<?php require_once("footer.php"); ?>
