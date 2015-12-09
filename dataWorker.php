<?php
	
	/*/dataWorker.php?peakontor&keyword=pakend_lekib*/
	require_once("worker.class.php");
	
	$Worker = new Worker($mysqli);
	$getvar = key($_GET);
	
	if(empty($_GET)){
		
		Header("Location: ?office=peakontor");
		
	}
	
	if(isset($_GET["delete"])){
		
		deletePacket($_GET["delete"]);
		
	}
	
	$keyword="";
	
	
	$office = $_GET["office"];
	
	if(isset($_GET["keyword"])){
		
		$keyword = $_GET["keyword"];
		$packet_array = $Worker->getPacketData($office, $keyword);
		
	}else{
		
		$packet_array = $Worker->getPacketData($office);
		
	}
?>

<body>

	<p>Tere, <?php echo $_SESSION["logged_in_user"];?></p>
	
	<br><br>
	
	<form action="dataWorker.php" method="get">
		
		<input type='hidden' name='office' value="<?=$_GET["office"];?>">
		<input type="search" name="keyword" value="<?php echo $keyword;?>">
		<input type="submit">
		
	</form>
	
		<p>
		
			<a href="?office=peakontor">Peakontor</a>
			<a href="?office=kopli">Kopli</a>
			<a href="?office=kristiine">Kristiine</a>
			<a href="?office=lasna">Lasnamäe</a>
			<a href="?office=mustamae">Mustamäe</a>
			<a href="?office=nomme">Nõmme</a>
			<a href="?office=oismae">Õismäe</a>
			<a href="?office=pirita">Pirita</a>
			
		</p>
	<div>
	<table border="1">
	
	
	<?php
		
		if($office == "peakontor"){
				
			echo "<tr>";
			echo "<th>Saadetise id</th>";
			echo "<th>Saabumisaeg</th>";
			echo "<th>Lähteriik</th>";
			echo "<th>Märkus</th>";
			echo "<th>Järgnev kontor</th>";
			echo "<th>Kustuta</th>";
			echo "<th>Edit</th>";
			echo "</tr>";
			echo "<tr>";
			
			for($i = 0; $i < count($packet_array); $i=$i+1){
				
				echo "<td>".$packet_array[$i]->id."</td>";
				echo "<td>".$packet_array[$i]->arrival."</td>";
				echo "<td>".$packet_array[$i]->fromc."</td>";
				echo "<td>".$packet_array[$i]->comment."</td>";
				echo "<td>".$packet_array[$i]->office_id."</td>";
				echo "<td><a href='dataWorker.php?".$getvar."&delete=".$packet_array[$i]->id."'>X</a></td>";
				echo "<td><a href='edit.php?edit_id=".$packet_array[$i]->id."'>edit</a></td>";
				echo "</tr>";
					
			}
			
			
		}else{
				
			echo "<tr>";
			echo "<th>Saadetise id</th>";
			echo "<th>Saabumisaeg</th>";
			echo "<th>Lahkumisaeg</th>";
			echo "<th>Märkus</th>";
			echo "<th>Kustuta</th>";
			echo "<th>Edit</th>";
			echo "</tr>";
			echo "<tr>";
			
			for($i = 0; $i < count($packet_array); $i=$i+1){
				
				echo "<tr>";
				echo "<td>".$packet_array[$i]->id."</td>";
				echo "<td>".$packet_array[$i]->arrival."</td>";
				echo "<td>".$packet_array[$i]->departure."</td>";
				echo "<td>".$packet_array[$i]->comment."</td>";
				echo "<td><a href='?delete=".$packet_array[$i]->id."'>X</a></td>";
				echo "<td><a href='edit.php?edit_id=".$packet_array[$i]->id."'>edit</a></td>";
				echo "</tr>";
			}	
		}
	
	?>
	
	
	</table>
	
	</div>

	<p>
		<a href="addPacket.php">Lisa uus pakend</a>
	</p>
	
</body>

