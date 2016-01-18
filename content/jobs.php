<?php
	//Lehe nimi
	$page_title = "Tööpakkumised";
	//Faili nimi
	$page_file = "jobs.php";
?>
<?php
	require_once("../header.php");
	require_once ("../inc/functions.php");
?>
<?php

	if(isset($_SESSION['logged_in_user_id'])) {
		if($_SESSION['logged_in_user_group'] == 3) {
			if(isset($_GET["delete"])) {
				$Job->deleteJobData($_GET["delete"]);
			}
			if(isset($_GET["update"])) {
				$Job->updateJobData($_GET["job_id"], $_GET["job_name"], $_GET["job_desc"], $_GET["job_company"], $_GET["job_county"], $_GET["job_parish"], $_GET["job_location"], $_GET["job_address"]);
			}
		}
	}
	if(isset($_GET["view"])) {
		$Job->singleJobData($_GET["view"]);
		$singleJob = $Job->singleJobData($_GET["view"]);
	}


	//kõik tööd objektide kujul massiivis
	$job_array = $Job->getAllData();



	$keyword = "";
	if (isset($_GET["keyword"])) {
		$keyword = cleanInput($_GET["keyword"]);

		//otsime
		$job_array = $Job->getAllData($keyword);
	} else {
		//Naitame koiki tulemus
		$job_array = $Job->getAllData();
	}
?>

<?php if(isset($_SESSION['response']->success)): ?>

<div class="alert alert-success alert-dismissible fade in" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<p><?=$_SESSION['response']->success->message;?></p>
</div>

<?php elseif(isset($_SESSION['response']->error)): ?>

<div class="alert alert-danger alert-dismissible fade in" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<p><?=$_SESSION['response']->error->message;?></p>
</div>

<?php
	endif;
	unset($_SESSION['response']);
?>

<div class="col-xs-12 col-sm-2 text-center">
	<h4 style="padding-bottom: 30px">FILTER</h4>
	<ul class="nav nav-pills nav-stacked">
		<h4 style="padding-bottom: 30px">Vald</h5>
		<?php
			$job_parish_array = filterParish();
			for($i = 0; $i < count($job_parish_array); $i++) {
				echo "<a href='?keyword=".$job_parish_array[$i]->parish."'>".$job_parish_array[$i]->parish." (".$job_parish_array[$i]->parish_count.")</a><br>";
		}
		?>
		<h4 style="padding-bottom: 30px">Asula</h5>
		<?php
				$job_location_array = filterLocation();
				for($i = 0; $i < count($job_location_array); $i++) {
					echo "<a href='?keyword=".$job_location_array[$i]->location."'>".$job_location_array[$i]->location." (".$job_location_array[$i]->location_count.")</a><br>";
				}
		?>
	</ul>
	<div class="col-xs-12 col-sm-1">
	</div>
</div>

<div class="col-xs-12 col-sm-10">
	<form action="jobs.php" method="get" class="col-xs-12 col-sm-12">
		<div class="input-group">
		<input name="keyword" type="text" class="form-control" placeholder="Otsi..." value="<?=$keyword?>">
		<span class="input-group-btn">
			<button class="btn btn-default" type="submit" value="otsi">Otsi!</button>
		</span>
		</div>
	</form>
	<div class="col-xs-12 col-sm-12">
	<br>

		<div class="list-group">
		<?php
			for($i = 0; $i < count($job_array); $i++) {
				echo '<a class="list-group-item" role="button" data-toggle="collapse" href="#'.$job_array[$i]->id.'" aria-expanded="false" aria-controls="'.$job_array[$i]->id.'">';
				echo '<h4 class="list-group-item-heading">'.$job_array[$i]->name.'</h4>';
				echo '<p class="list-group-item-text">'.$job_array[$i]->company.", ".$job_array[$i]->county.", ".$job_array[$i]->parish.'</p>';
				echo '</a>';
				echo '<div class="collapse" id="'.$job_array[$i]->id.'">';
				echo '<div class="well">';
				echo '<h4 style="margin-bottom: 5px;">Kirjeldus:</h4>';
				echo '<p class="list-group-item-text">'.$job_array[$i]->description.'</p><br>';

				echo '<h4 style="margin-bottom: 5px;">Kontakt:</h4>';
				echo '<p class="list-group-item-text">'.$job_array[$i]->email.'</p>';
				echo '<p class="list-group-item-text">'.$job_array[$i]->number.'</p>';
				echo '<p class="list-group-item-text">'.$job_array[$i]->county.', '.$job_array[$i]->parish.', '.$job_array[$i]->location.', '.$job_array[$i]->address.'</p><br>';
				echo '<ul class="list-inline">';
				echo '<li>Sisestatud: '.$job_array[$i]->inserted.'</li>';
				
				if($_SESSION['logged_in_user_group'] == 1) {
				echo '<li class="pull-right"><a href="../job/'.$job_array[$i]->link.'.php" class="btn btn-success btn-sm">
												Saada CV	<span class="glyphicon glyphicon-share-alt"></span>
							</a></li>';
				}

				echo '</ul>';
				#echo '<p class="list-group-item-text">Sisestatud: '.$job_array[$i]->inserted.'</p>';



				echo '</div>';
				echo '</div>';
			}

			?>
		</div>


	</div>
</div>
<?php require_once("../footer.php"); ?>
