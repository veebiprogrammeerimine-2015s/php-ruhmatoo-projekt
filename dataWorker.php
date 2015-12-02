<?php

	require_once("worker.class.php");
	
	$Worker = new Worker($mysqli);
	
	if(isset($_GET["delete"])){
		echo "kustutame id ".$_GET["delete"];
		deletePacket($_GET["delete"]);
	}
	
	if(isset($_POST["save"])){
		updatePacket($_POST["id"], $_POST["arrival"], $_POST["departure"], $_POST["fromc"], $_POST["comment"]);
	}
	
	$keyword="";
	
	if(isset($_GET["keyword"])){
		$keyword = $_GET["keyword"];
		$packet_array = $Worker->getPacketData($keyword);
	}else{
		$packet_array = $Worker->getPacketData();
	}
?>

<body>

	<p>Tere, <?php echo $_SESSION["logged_in_user"];?></p>
	
	<br><br>
	
	<form action="dataWorker.php" method="get">
		<input type="search" name="keyword" value="<?php echo $keyword;?>">
		<input type="submit">
	</form>
	<table border="1">
		<tr>
			<th>Saadetise id</th>
			<th>Saabumisaeg</th>
			<th>Väljumisaeg</th>
			<th>Lähteriik</th>
			<th>Märkus</th>
			<th>Järgnev kontor</th>
			<th>Kustuta</th>
			<th>Edit</th>
		</tr>

	<?php
	
		for($i = 0; $i < count($packet_array); $i=$i+1){
			
			if(isset($_GET["edit"]) && $packet_array[$i]->id == $_GET["edit"]){
				
				echo "<tr>";
				echo "<form action='dataWorker.php' method='post'>";
				echo "<input type='hidden' name='id' value='".$packet_array[$i]->id."'>";
				echo "<td>".$packet_array[$i]->id."</td>";
				echo "<td><input name='arrival' value='".$packet_array[$i]->arrival."'></td>";
				echo "<td><input name='departure' value='".$packet_array[$i]->departure."'></td>";
				echo "<td><input name='fromc' value='".$packet_array[$i]->fromc."'></td>";
				echo "<td><input name='comment' value='".$packet_array[$i]->comment."'></td>";
				echo "<input type='hidden' name='office_id' value='".$packet_array[$i]->office_id."'>";
				echo "<td>".$packet_array[$i]->office_id."</td>";
				echo "<td><a href='dataWorker.php'>cancel</a></td>";
				echo "<td><input type='submit' name='save' value='save'></td>";
				echo "</form>";
				echo "</tr>";
				
			}else{
				
				echo "<tr>";
				echo "<td>".$packet_array[$i]->id."</td>";
				echo "<td>".$packet_array[$i]->arrival."</td>";
				echo "<td>".$packet_array[$i]->departure."</td>";
				echo "<td>".$packet_array[$i]->fromc."</td>";
				echo "<td>".$packet_array[$i]->comment."</td>";
				echo "<td>".$packet_array[$i]->office_id."</td>";
				echo "<td><a href='?delete=".$packet_array[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$packet_array[$i]->id."'>edit</a></td>";
				echo "<td><a href='edit.php?edit_id=".$packet_array[$i]->id."'>edit</a></td>";
				echo "</tr>";
				
			}
		}
	
	?>
</body>
