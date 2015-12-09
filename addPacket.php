<?php

	require_once("worker.class.php");
	
	$Worker = new Worker($mysqli);
	
	$arrival_date = "";
	$arrival_time = "";
	$departure = "";
	$fromc = "";
	$comment = "";
	$office = "";
	$datetime = "";
	$date = ""
	
	$arrival_error = "";
	$fromc_error = "";
	$office_error = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
	
		if(isset($_POST["submit"])){
			
			if(empty($_POST["arrival_date"]) || empty($_POST["arrival_time"])){
				
				$arrival_error = "See väli peab olema täidetud!";
				
			}else{
				
				$arrival_date  = $_POST["arrival_date"];
				$arrival_time = $_POST["arrival_time"];
				
				
				$date = explode("-", $arrival_date);
				$time = explode(":", $arrival_time);
				
				//panen formaati mida saab ab'i salvestada
				$datetime = date("Y-m-d H:i:s", mktime($time[0], $time[1], 0, $date[1], $date[2], $date[0]));
				
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
				$office = cleanInput($_POST["office"]);
				$code = sprintf('%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535));
				
				$Worker->updatePacket($arrival, $departure, $fromc, $comment, $office, $code);
			
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
<body>
	<p><a href="dataWorker.php">Tagasi</a> eelmisele lehele</p>
	<h2>Lisa uus pakend</h2>
	<form action="addPacket.php" method="post">
			Pakendi saabumine:<br>
			<input name="arrival-date" type="date" value="<?php echo $arrival_date; ?>"> <?php echo $arrival_error; ?> <br>
			<input name="arrival-time" type="time" value="<?php echo $arrival_time; ?>"> <?php echo $arrival_error; ?> <br><br>
			Pakendi väljumine:<br>
			<input name="departure-date" type="date" value="<?php echo $departure; ?>"> <br>
			<input name="departure-time" type="time" value="<?php echo $departure; ?>"> <br><br>
			Pakendi lähteriik:<br>
			<input name="fromc" type="text" value="<?php echo $fromc; ?>"> <?php echo $fromc_error; ?><br><br>
			Märkus:<br>
			<input name="comment" type="text" value="<?php echo $comment; ?>"> <br><br>
			Kuhu pakend edasi liigub:<br>
			<input name="office" type="text" value="<?php echo $office; ?>"> <?php echo $office_error; ?><br><br>
		<input type="submit" name="submit">
	</form>
	<?=$datetime;?>
</body>