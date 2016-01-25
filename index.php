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
	if(isset($_GET['job_link'])) {
		$current = $Job->singleJobData($_GET['job_link']);
	}



?>

<div class="row">
	<div class="col-xs-12 col-sm-4">
		<h3 id="statbar">Viimati lisatud tööd</h3>
		<div class="list-group">
			<?php
				if (count($job_array) >= 5) {
					for($i = 0; $i < 5; $i++) {
						echo '<a style="cursor:pointer" class="list-group-item" data-toggle="modal" data-target="#'.$job_array[$i]->id.'">';
						echo '<h4 class="list-group-item-heading">'.$job_array[$i]->name.'</h4>';
						echo '<p class="list-group-item-text">'.$job_array[$i]->company.', '.$job_array[$i]->parish.'</p>';
						echo '</a>';
					}
				} elseif (count($job_array) < 5) {
						for($i = 0; $i < count($job_array); $i++) {
							echo '<a style="cursor:pointer" class="list-group-item" data-toggle="modal" data-target="#'.$job_array[$i]->id.'">';
							echo '<h4 class="list-group-item-heading">'.$job_array[$i]->name.'</h4>';
							echo '<p class="list-group-item-text">'.$job_array[$i]->company.', '.$job_array[$i]->parish.'</p>';
							echo '</a>';
					}

				}
			?>
		</div>
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

<!-- Modal for single job-->
<?php
	if (count($job_array) >= 5):
	for($i = 0; $i < 5; $i++):
?>
<div class="modal fade" id="<?=$job_array[$i]->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=$job_array[$i]->name;?></h4>
				<?=$job_array[$i]->company;?>
      </div>
      <div class="modal-body">
				<h4 style="margin-bottom: 5px;">Kirjeldus:</h4>
				<?=$job_array[$i]->description;?><br>
				<h4 style="margin-bottom: 5px;">Kontakt:</h4>
				<?=$job_array[$i]->email;?><br>
				<?=$job_array[$i]->number;?><br>
				<?=$job_array[$i]->county.", ".$job_array[$i]->parish.", ".$job_array[$i]->location.", ".$job_array[$i]->address;?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Sulge</button>
				<?php if($_SESSION['logged_in_user_group'] == 1): ?>
					<a href="<?=$myurl;?>job/<?=$job_array[$i]->link;?>.php" class="btn btn-success btn-sm">
						Saada CV	<span class="glyphicon glyphicon-share-alt"></span>
					</a>
				<?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php
	endfor;
	elseif (count($job_array) < 5):
	for($i = 0; $i < count($job_array); $i++):
?>
<div class="modal fade" id="<?=$job_array[$i]->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=$job_array[$i]->name;?></h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?php
	endfor;
	endif;
?>

<?php require_once("footer.php"); ?>
