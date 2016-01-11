<?php
	require_once("../config_global.php");
	$database = "if15_teamalpha_3";
	
	require_once("edit.class.php");
	//if(!isset($_SESSION["logged_in_user_id"])){
	//	header("Location: login.php");
	//}
	$Edit = new Edit($mysqli);
	
	$office = $_GET["office"];
	$packet_id = $_GET["edit_id"];
	$packet_array = $Edit->getPacketData($packet_id);
	
	if(isset($_POST["update_packet"])){
		$Edit->updatePacket($office, $_POST["arrival"], $_POST["departure"], $_POST["fromc"], $_POST["comment"], $_POST["office_id"], $packet_id);
		header("Location: dataWorker.php");
	}
	
?>

<h2>Muuda saadetise andmeid</h2>
<form method="post">
		
		<label for ="arrival">Saabumisaeg</label><br>
		<input id="arrival" name="arrival" type="text" value="<?=$packet_array[0]->arrival;?>"> <br><br>
		
		<label for ="arrival">Väljumisaeg</label><br>
		<input id="departure" name="departure" type="text" value="<?=$packet_array[0]->departure;?>"> <br><br>
		
		<label for ="fromc">Lähteriik</label><br>
		<input id="fromc" name="fromc" type="text" value="<?=$packet_array[0]->fromc;?>"> <br><br>
		
		<label for ="comment">Märkus</label><br>
		<input id="comment" name="comment" type="text" value="<?=$packet_array[0]->comment;?>"> <br><br>
		
		<?php 
		if($office == "peakontor"){
		echo "<label for ='office_id'>Järgnev kontor</label><br>";
		echo "<input id='office_id' name='office_id' type='text' value=".$packet_array[0]->office_id."> <br><br>";
		}
		?>
		
		<input type="submit" name="update_packet" value="Salvesta"><br>
</form>	

		
		
		
		
		
		
		
		