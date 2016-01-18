<?php
	//Lehe nimi
	$page_title = "Esitatud CVd";
	//Faili nimi
	$page_file = "sentresumes.php";
?>
<?php
	require_once("../header.php");
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
<table class="table table-striped table-condensed table-responsive">
	<thead>
		<tr>
			<th>Amet</th>
			<th>Saatja</th>
			<th>Saadetud</th>
			<th></th>
			<th></th>
			<th>Valikud</th>
		</tr>
	</thead>
	<tbody>
			<?php
				for($i = 0; $i < count($sent_cv); $i++) {
					echo '<tr><td>'.$sent_cv[$i]->job.'</td>
							  <td>'.$sent_cv[$i]->first.' '.$sent_cv[$i]->last.'</td>
							  <td>'.$sent_cv[$i]->time.'</td>
								<td style="width: 120px;"></td>
								<td style="width: 120px;"></td>';
					echo '<td><div class="btn-group">
									<a class="btn btn-success btn-sm" data-toggle="modal" data-target="#'.$sent_cv[$i]->id.'">
										<span class="glyphicon glyphicon-comment"></span> Vasta
									</a>
									<a href="../pdf/resume.php?id='.$sent_cv[$i]->id.'" class="btn btn-info btn-sm">
										<span class="glyphicon glyphicon-open-file"></span> Vaata
									</a>

								</div></td></tr>';

				}

			?>

	</tbody>
</table>
<h4 style="margin-bottom: 10px;">Vastatud <span style="font-size: 8pt">(Uuemad on eespool)</span></h4>
<table class="table table-striped table-condensed table-responsive">
	<thead>
		<tr>
			<th>Amet</th>
			<th>Saatja</th>
			<th>Saadetud</th>
			<th>Vastus</th>
			<th>Põhjus</th>
			<th>Valikud</th>
		</tr>
	</thead>
	<tbody>
			<?php
				for($i = 0; $i < count($answered_cv); $i++) {
					echo '<tr><td>'.$answered_cv[$i]->job.'</td>
							  <td>'.$answered_cv[$i]->first.' '.$answered_cv[$i]->last.'</td>
							  <td>'.$answered_cv[$i]->time.'</td>
								<td>'.$answered_cv[$i]->answer_type.'</td>
								<td>'.$answered_cv[$i]->answer.'</td>';
					echo '<td><div class="btn-group">
									<a class="btn btn-success btn-sm" data-toggle="modal" data-target="#'.$answered_cv[$i]->id.'">
										<span class="glyphicon glyphicon-comment"></span> Vasta
									</a>
									<a href="../pdf/resume.php?id='.$answered_cv[$i]->id.'" class="btn btn-info btn-sm">
										<span class="glyphicon glyphicon-open-file"></span> Vaata
									</a>

								</div></td></tr>';

				}

			?>

	</tbody>
</table>

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




<?php require_once("../footer.php"); ?>
