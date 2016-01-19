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
				if (count($job_array) >= 10) {
					for($i = 0; $i < 10; $i++) {
						echo "<h4 id='jobname'><li>".$job_array[$i]->name."</li></h4><br>".$job_array[$i]->company.", ".$job_array[$i]->parish."<br>";
					}
				} elseif (count($job_array) < 10) {
						for($i = 0; $i < count($job_array); $i++) {
							echo "<h4 id='jobname'><li>".$job_array[$i]->name."</li></h4><br>".$job_array[$i]->company.", ".$job_array[$i]->parish."<br>";
					}

				}
			?>
		</ol>
	</div>
	<div class="col-xs-12 col-sm-4">
		<h3 id="statbar"><a href="content/news.php" style="color: #333;">Uudised</a></h3>
		<?php
		if (count($job_array) >= 3) {
					for($i = 0; $i < 3; $i++) {
						echo '<div class="media">
										<div class="media-body">
											<h4 class="media-heading"><a href="content/news.php?id='.$news[$i]->id.'" style="color: #333;">'.$news[$i]->subject.'</a></h4>';
						if (strlen($news[$i]->text) > 350) {
							$str = $news[$i]->text;
							$str = explode( "\n", wordwrap( $news[$i]->text, 350));
							$str = $str[0] . '<a href="content/news.php?id='.$news[$i]->id.'"> Loe edasi... </a>';
							echo $str;
						} else {
	            echo $news[$i]->text;
	          }
						echo '</div>
									</div>';
				}
		} else {
					for($i = 0; $i < count($news); $i++) {
						echo '<div class="media">
										<div class="media-body">
											<h4 class="media-heading"><a href="content/news.php?id='.$news[$i]->id.'" style="color: #333;">'.$news[$i]->subject.'</a></h4>';
						if (strlen($news[$i]->text) > 350) {
							$str = $news[$i]->text;
							$str = explode( "\n", wordwrap( $news[$i]->text, 350));
							$str = $str[0] . '<a href="content/news.php?id='.$news[$i]->id.'"> Loe edasi... </a>';
							echo $str;
						} else {
	            echo $news[$i]->text;
	          }
						echo '</div>
									</div>';
						/*echo "<h4 id='jobname'>".$news[$i]->subject."</h4><br>".$news[$i]->category.", ".$news[$i]->posted."<br>";
						echo '<p>'.$news[$i]->text.'</p>';*/
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
