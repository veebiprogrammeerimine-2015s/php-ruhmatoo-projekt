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
	$answer = $answer_type = "";
	$answer_error = $answer_type_error = "";

	if(isset($_SESSION['logged_in_user_id'])) {
		if($_SESSION['logged_in_user_group'] == 2) {
			if( $_SERVER["REQUEST_METHOD"] == "POST") {

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

					$current_id = cleaninput($_POST["current_id"]);

					if($answer_error == "" && $answer_type_error == "") {
						$response = $Resume->sendAnswer($current_id, $answer_type, $answer);
					}

				} else {
					$response->error->message = "Viga! Sa ei täitnud kõike kohustuslike lahtreid!";
				}

				}
			}
		}

?>
<?php if(isset($response->success)): ?>

<div class="alert alert-success alert-dismissible fade in" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<p><?=$response->success->message;?></p>
</div>

<?php elseif(isset($response->error)): ?>

<div class="alert alert-danger alert-dismissible fade in" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<p><?=$response->error->message;?></p>
</div>

<?php endif; ?>

<h3> Laekunud CVd </h3>
<table class="table table-striped table-condensed">
	<thead>
		<tr>
			<th>Amet</th>
			<th>Saatja</th>
			<th>Saadetud</th>
			<th>Vastus</th>
			<th>Valikud</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<?php
				for($i = 0; $i < count($sent_cv); $i++) {
					echo '<td>'.$sent_cv[$i]->job.'</td>
							  <td>'.$sent_cv[$i]->first.' '.$sent_cv[$i]->last.'</td>
							  <td>'.$sent_cv[$i]->time.'</td>
							  <td>'.$sent_cv[$i]->answer.'</td>';
					echo '<td><div class="btn-group">
									<a class="btn btn-success btn-sm" data-toggle="modal" data-target="#'.$sent_cv[$i]->id.'">
										<span class="glyphicon glyphicon-comment"></span> Vasta
									</a>
									<a href="../pdf/resume.php?id='.$sent_cv[$i]->id.'" class="btn btn-info btn-sm">
										<span class="glyphicon glyphicon-open-file"></span> Vaata
									</a>

								</div></td>';

				}

			?>

		</tr>
	</tbody>
</table>
<!-- Modal -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<?php
	for($i = 0; $i < count($sent_cv); $i++) {
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
	}
?>
</form>



<?php require_once("../footer.php"); ?>
