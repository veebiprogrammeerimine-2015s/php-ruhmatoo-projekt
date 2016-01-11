<?php
	require_once("functions.php");
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
	}
	$problem = "";
	$date = "";
	$animal_kind = "";
	$owner_name = "";
	$animal_name = "";
	$problem_error = "";
	$date_error = "";
	$animal_kind_error = "";
	$owner_name_error = "";
	$animal_name_error = "";
	
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
	}
	
	if(isset($_POST["register"])){


		if ( empty($_POST["owner_name"]) ) {
				$owner_name_error = "See väli on kohustuslik";
			}else{
				$owner_name = cleanInput($_POST["owner_name"]);
			}
		if ( empty($_POST["animal_name"]) ) {
				$animal_name_error = "See väli on kohustuslik";
			}else{
				$animal_name = cleanInput($_POST["animal_name"]);
			}
		if ( empty($_POST["animal_kind"]) ) {
				$animal_kind_error = "See väli on kohustuslik";
			}else{
				$animal_kind = cleanInput($_POST["animal_kind"]);
			}
		if ( empty($_POST["date"]) ) {
				$date_error = "See väli on kohustuslik";
			}else{
				$date = cleanInput($_POST["date"]);
			}
		if ( empty($_POST["problem"]) ) {
				$problem_error = "See väli on kohustuslik";
			}else{
				$problem = cleanInput($_POST["problem"]);
			}
			
			
		if($problem_error  == "" && $date_error  == "" && $animal_kind_error  == "" && $owner_name_error  == "" && $animal_name_error == ""){

				$message = registerAnimal($owner_name, $animal_name, $animal_kind, $date, $problem);
				
				if($message != ""){
					// õnnestus, teeme inputi väljad tühjaks
					$problem = "";
					$date = "";
					$animal_kind = "";
					$owner_name = "";
					$animal_name = "";
					
					echo $message;
					
				}
			}
	}
?>
<head>
	<link rel="stylesheet" href="materialize.min.css">
	</head>

<body>
<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?> 
	<a href="?logout=1"> Logi välja </a> 
</p>

<div class="owner_register">
<div class="row">
<h2>Registreerimine</h2>
<form class="col s12" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<div class="row">
	<div class="input-field col s4">
		<label for="owner_name">Omaniku nimi</label>
		<input id="owner_name" name="owner_name" type="text" class="validate" value="<?php echo $owner_name; ?>"> <?php echo $owner_name_error; ?><br><br>
	</div>
	</div>
	<div class="row">
	<div class="input-field col s4">
		<label for="animal_name">Looma nimi</label>
		<input id="animal_name" name="animal_name" type="text" class="validate"  value="<?php echo $animal_name; ?>"> <?php echo $animal_name_error; ?><br><br>
	</div>
	</div>
	<div class="row">
	<div class="input-field col s4">
		<label for="animal_kind">Looma liik</label>
		<input id="animal_kind" name="animal_kind" type="text" class="validate"  value="<?php echo $animal_kind; ?>"> <?php echo $animal_kind_error; ?><br><br>
	</div>
	</div>
	<div class="row">
	<div class="input-field col s4">
		<label for="date" class="">Kuupäev</label>
		<input id="date" name="date" type="date" class="datepicker" value="<?php echo $date; ?>"> <?php echo $date_error; ?><br><br>
	</div>
	</div>
	<div class="row">
	<div class="input-field col s4">
	<label for="problem">Probleemi kirjeldus</label>
	<textarea id="problem"  class="materialize-textarea" name="problem" col=40 rows=8 value="<?php echo $problem; ?>"> <?php echo $problem_error; ?> </textarea>
	</div>
	</div>
	<div class="waves-effect waves-light btn">
		<input type="submit" name="register" value="Salvesta">
	</div>
</div>
</form>
</div>

<form class="waves-effect waves-light btn" action="feedback.php" method="post" >
	<input type="submit" name="tagasiside" value="Tagasiside">
</form>

<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="materialize.min.js"></script>

 <script>
  $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15 // Creates a dropdown of 15 years to control year
  });
  </script>
    </body>

<?php
require("footer.html");
?>
