<?php

	require_once("worker.class.php");
	require_once("header.php");
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
		exit();
	}
	
	$Worker = new Worker($mysqli);
	$office1 = $_GET["office"];
	
	$arrival = "";
	$departure = "";
	$fromc = "";
	$comment = "";
	$office_id = "";
	$date = "";
	
	$arrival_error = "";
	$fromc_error = "";
	$office_error = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
	
		if(isset($_POST["submit"])){
			
			if(empty($_POST["arrival"])/* || empty($_POST["arrival_time"])*/){
				
				$arrival_error = "See väli peab olema täidetud!";
				
			}
			
			if(empty($_POST["fromc"])){
				
				$fromc_error = "See väli peab olema täidetud!";
				
			}
			
			if(!empty($_POST["departure"])){
				
				if(empty($_POST["office"])){
					
					$office_error = "Kuhu pakend väljub?";
					
				}
				
			}
			
			if($arrival_error == "" && $fromc_error == "" && $office_error == ""){
				
				$arrival = cleanInput($_POST["arrival"]);
				$departure = cleanInput($_POST["departure"]);
				$fromc = cleanInput($_POST["fromc"]);
				$comment = cleanInput($_POST["comment"]);
				$office_id = cleanInput($_POST["office_id"]);
				$code = sprintf('%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535));
				
				$Worker->addPacket($office1, $arrival, $departure, $fromc, $comment, $office_id, $code);
			
			}
			
		}
			
	}
	
	function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
	
?>
	
	<p><a href="dataWorker.php">Tagasi</a> eelmisele lehele</p>
	<h2>Lisa uus pakend</h2>
	<form method="post">
			Pakendi saabumine:<br>
			<input name="arrival" type="number" maxlength="14" value="Yearmmddhhmmss"> <?php echo $arrival_error; ?> <br><br>
			Pakendi väljumine:<br>
			<input name="departure" type="number" maxlength="14" value="Yearmmddhhmmss"> <br><br>
			
			<?php 
			if($office1 == "peakontor"){
			echo "Pakendi lähteriik:<br>";
			echo "<input name='fromc' type='text' value=".$fromc."> ".$fromc_error."<br><br>";
			}
			?>
			
			Märkus:<br>
			<input name="comment" type="text" value="<?php echo $comment; ?>"> <br><br>
			
			<?php 
			if($office1 == "peakontor"){
			echo "Kuhu pakend edasi liigub:<br>";
			echo "<input name='office_id' type='number' maxlength='1' min='1' max='7' value=".$office_id."> ".$office_error." <br><br>";
			}
			?>
			
		<input type="submit" name="submit">
	</form>
	
	<?php require_once("footer.php"); ?>