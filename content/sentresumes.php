<?php
	//Lehe nimi
	$page_title = "Esitatud CVd";
	//Faili nimi
	$page_file = "sentresumes.php";
?>
<?php
	require_once ("../inc/functions.php");
?>
<?php

	#$company = $Job->getMyData($_SESSION['logged_in_user_id']);
	$sent_cv = $Resume->getSentResumes($_SESSION['logged_in_user_id']);
	$answered_cv = $Resume->getAnsweredResumes($_SESSION['logged_in_user_id']);
	$answer = $answer_type = "";
	$answer_error = $answer_type_error = "";
	$answers = $answers_type = "";
	$answers_error = $answers_type_error = "";
	$longAnswer = array();

	if(isset($_SESSION['logged_in_user_id'])) {
		if($_SESSION['logged_in_user_group'] == 2) {
			if( $_SERVER["REQUEST_METHOD"] == "POST") {

				if(isset($_POST["send_answers"])) {

					if(empty($_POST["answer"])) {
						$answers_error = "See väli on kohustuslik!";
					} else {
						$answers = cleanInput($_POST["answer"]);
					}

					if(empty($_POST["answer_type"])) {
						$answers_type_error = "See väli on kohustuslik!";
					} else {
						$answers_type = cleanInput($_POST["answer_type"]);
					}

					$current_ids = cleaninput($_POST["current_id"]) + 0;

					if($answers_error == "" && $answers_type_error == "") {

						$Resume->sendAnswer($current_ids, $answers_type, $answers);
					} else {
						$response->error->message = "Viga! Sa ei täitnud kõike kohustuslike lahtreid!";
					}

				}

				if(isset($_POST["send_answer"])) {

					if(empty($_POST["answer"])) {
						$answer_error = "See väli on kohustuslik!";
					} else {
						$answer = cleanInput($_POST["answer"]);
					}

					if(empty($_POST["answer_type"])) {
						$answer_type_error = "See väli on kohustuslik!";
					} else {
						$answer_type = cleanInput($_POST["answer_type"]);
					}

					$current_id = cleaninput($_POST["current_id"]) + 0;

					if($answer_error == "" && $answer_type_error == "") {

						$Resume->sendAnswer($current_id, $answer_type, $answer);
					} else {
						$response->error->message = "Viga! Sa ei täitnud kõike kohustuslike lahtreid!";
					}

				}

				}
			}
		}

		require_once("../header.php");
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

<?php elseif(isset($response->error)): ?>

<div class="alert alert-danger alert-dismissible fade in" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<p><?=$response->error->message;?></p>
</div>

<?php endif; unset($_SESSION['response']); ?>

<h3> Laekunud CVd </h3>
<h4 style="margin-bottom: 10px;">Vastamata <span style="font-size: 8pt">(Uuemad on eespool)</span></h4>

<ul class="list-group">
<?php
	for($i = 0; $i < count($sent_cv); $i++) {
		echo '<li class="list-group-item">';

		echo '
					<table style="width: 100%">
						<td class="table-25">
							<span class="badge">'.$sent_cv[$i]->job.'</span>
						</td>
						<td class="table-25">
							<span class="">'.$sent_cv[$i]->first.' '.$sent_cv[$i]->last.'</span>
						<td class="table-25">
							<span class="">'.$sent_cv[$i]->time.'</span>
						</td>

					';


		echo '<td class="table-25">
					<div class="pull-right">

						<div class="dropdown">
						  <button class="btn btn-xs only-caret" data-toggle="dropdown">
						    <span class="glyphicon glyphicon-option-horizontal"></span>
						  </button>

						  <ul class="dropdown-menu dropdown-menu-left pull-left disable-width">
								<li><a href="" data-toggle="modal" data-target="#'.$sent_cv[$i]->id.'">
									<span class="glyphicon glyphicon-comment"></span> Vasta
								</a></li>
								<li><a href="../pdf/resume.php?id='.$sent_cv[$i]->id.'">
									<span class="glyphicon glyphicon-open-file"></span> Vaata
								</a></li>
						  </ul>

						</div>

					</div></td>';

		echo '</table></li>';
	}
?>
</ul>


<h4 style="margin-bottom: 10px;">Vastatud <span style="font-size: 8pt">(Viimati vastatud on eespool)</span></h4>

<ul class="list-group">
<?php
	for($i = 0; $i < count($answered_cv); $i++) {
		if($answered_cv[$i]->answer_type == "Vastuvõetud") {
			echo '<li class="list-group-item list-group-item-success" title="'.$answered_cv[$i]->answer_type.'">';
		} elseif ($answered_cv[$i]->answer_type == "Tagasilükatud") {
			echo '<li class="list-group-item list-group-item-danger" title="'.$answered_cv[$i]->answer_type.'">';
		} else {
			echo '<li class="list-group-item">';
		}

		echo '
					<table style="width: 100%">
						<td class="table-20">
							<span class="badge">'.$answered_cv[$i]->job.'</span>
						</td>
						<td class="table-20">
							<span class="">'.$answered_cv[$i]->first.' '.$answered_cv[$i]->last.'</span>
						<td class="table-20">
							<span class="">'.$answered_cv[$i]->answer_time.'</span>
						</td>';
		echo '<td class="table-20">';
					if (strlen($answered_cv[$i]->answer) > 30) {
						$str = $answered_cv[$i]->answer;
						$str = explode( "\n", wordwrap( $answered_cv[$i]->answer, 30));
						$str = $str[0] . '...<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>';
						echo '<a id="popover-'.$answered_cv[$i]->id.'" tabindex="0" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="'.$answered_cv[$i]->answer.'">' . $str . '</a>';
						array_push($longAnswer, $answered_cv[$i]->id);

					} else {
						echo $answered_cv[$i]->answer;
					}
		echo '</td>';

		echo '<td class="table-20">
					<div class="pull-right">

						<div class="dropdown">
						  <button class="btn btn-xs only-caret" data-toggle="dropdown">
						    <span class="glyphicon glyphicon-option-horizontal"></span>
						  </button>

						  <ul class="dropdown-menu dropdown-menu-left pull-left disable-width">
								<li><a href="" data-toggle="modal" data-target="#'.$answered_cv[$i]->id.'">
									<span class="glyphicon glyphicon-comment"></span> Vasta
								</a></li>
								<li><a href="../pdf/resume.php?id='.$answered_cv[$i]->id.'">
									<span class="glyphicon glyphicon-open-file"></span> Vaata
								</a></li>
						  </ul>

						</div>

					</div></td>';

		echo '</table></li>';
	}
?>
</ul>

<!-- Modal -->
<?php
	for($i = 0; $i < count($sent_cv); $i++) {
		echo '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">';
		echo '<div class="modal fade" id="'.$sent_cv[$i]->id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">';
		echo '  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Vastus ametile: '.$sent_cv[$i]->job.'<br>Saatja: '.$sent_cv[$i]->first.' '.$sent_cv[$i]->last.'</h4>
		      </div>
		      <div class="modal-body">';
		echo '<input type="hidden" name="current_id" value="'.$sent_cv[$i]->id.'">';
		echo 'Enne vastuse saatmist veendu, et oled vaadanud CVd!
						Saadetud vastus on lõplik!<br><br>';
		echo '<label for="answer">Tagasiside</label>
						<textarea class="form-control" rows="4" name="answer" type="text"></textarea><br>';
		echo $Resume->answerTypes();
		echo '</div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Katkesta</button>
		        <button type="submit" name="send_answers" class="btn btn-primary">Saada</button>
		      </div>
		    </div>
		  </div>
		</div>';
		echo '</form>';
	}
?>


<!-- Modal -->
<?php
	for($i = 0; $i < count($answered_cv); $i++) {
		echo '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">';
		echo '<div class="modal fade" id="'.$answered_cv[$i]->id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">';
		echo '  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Vastus ametile: '.$answered_cv[$i]->job.'<br>Saatja: '.$answered_cv[$i]->first.' '.$answered_cv[$i]->last.'</h4>
		      </div>
		      <div class="modal-body">';
		echo '<input type="hidden" name="current_id" value="'.$answered_cv[$i]->id.'">';
		echo 'Enne vastuse saatmist veendu, et oled vaadanud CVd!
						Saadetud vastus on lõplik!<br><br>';
		echo '<label for="answer">Vastus/põhjus</label>
						<textarea class="form-control" rows="4" name="answer" type="text"></textarea><br>';
		echo $Resume->answerTypes();
		echo '</div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Katkesta</button>
		        <button type="submit" name="send_answer" class="btn btn-primary">Saada</button>
		      </div>
		    </div>
		  </div>
		</div>';
		echo '</form>';
	}
?>

<script>

		<?php for($i = 0; $i < count($longAnswer); $i++): ?>
			document.getElementById("popover-<?=$longAnswer[$i]?>").addEventListener("click", function() {
				$('#popover-<?=$longAnswer[$i]?>').popover('toggle');
			});
		<?php endfor; ?>

</script>

<?php require_once("../footer.php"); ?>
