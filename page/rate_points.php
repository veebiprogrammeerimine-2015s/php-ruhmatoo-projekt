<?php

$helpful = $clarity = $exam = $class = "";
$helpful_error = $clarity_error = $exam_error = $class_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_POST["add"])){
		if (empty($_POST["helpful"]) ) {
			$helpful_error = "See väli on kohustuslik";
		}else{
			$helpful = cleanInput($_POST["helpful"]);
		}

		if (empty($_POST["clarity"]) ) {
			$clarity_error = "See väli on kohustuslik";
		}else{
			$clarity = cleanInput($_POST["clarity"]);
		}

		if (empty($_POST["exam"]) ) {
			$exam_error = "See väli on kohustuslik";
		}else{
			$exam = cleanInput($_POST["exam"]);
		}

		if (empty($_POST["class"]) ) {
			$class_error = "See väli on kohustuslik";
		}else{
			$class = cleanInput($_POST["class"]);
		}

		if ($helpful_error == "" && $clarity_error == "" && $exam_error == "" && $class_error == "") {
			$response = $Rate->ratePro($_SESSION['logged_in_user_id'], $trimmed, $helpful, $clarity, $exam, $class);
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

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<label for="helpful">Abivalmidus</label>
	<select name="helpful" class="form-control">
		<option selected>- Määra hinnang -</option>
		<option value="1">- 1 -</option>
		<option value="2">- 2 -</option>
		<option value="3">- 3 -</option>
		<option value="4">- 4 -</option>
		<option value="5">- 5 -</option>
	</select>
	<label for="clarity">Selgus</label>
	<select name="clarity" class="form-control">
		<option selected>- Määra hinnang -</option>
		<option value="1">- 1 -</option>
		<option value="2">- 2 -</option>
		<option value="3">- 3 -</option>
		<option value="4">- 4 -</option>
		<option value="5">- 5 -</option>
	</select>
	<label for="exam">Eksamihinne</label>
	<select name="exam" class="form-control">
		<option selected>- Määra hinne -</option>
		<option value="0">- F -</option>
		<option value="1">- E -</option>
		<option value="2">- D -</option>
		<option value="3">- C -</option>
		<option value="4">- B -</option>
		<option value="5">- A -</option>
	</select>
	<label for="class">Üldine hinnang</label>
	<select name="class" class="form-control">
		<option selected>- Määra hinnang -</option>
		<option value="1">- 1 -</option>
		<option value="2">- 2 -</option>
		<option value="3">- 3 -</option>
		<option value="4">- 4 -</option>
		<option value="5">- 5 -</option>
	</select>
  <br>
  <input type="submit" name="add" class="btn btn-primary pull-right">

</form>
