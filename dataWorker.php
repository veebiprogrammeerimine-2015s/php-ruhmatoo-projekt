<?php
	
	/*/dataWorker.php?peakontor&keyword=pakend_lekib*/
	require_once("worker.class.php");
	
	$Worker = new Worker($mysqli);
	$getvar = key($_GET);
	
	if(empty($_GET)){
		Header("Location: ?peakontor");
	}
	
	if(isset($_GET["delete"])){
		deletePacket($_GET["delete"]);
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
		<?php
		if(isset($_GET["peakontor"])){
			
			echo "<input type='hidden' name='peakontor'>";
			
		}elseif(isset($_GET["kopli"])){
			
			echo "<input type='hidden' name='kopli'>";
			
		}elseif(isset($_GET["kopli"])){
			
			echo "<input type='hidden' name='kopli'>";
			
		}elseif(isset($_GET["kristiine"])){
			
			echo "<input type='hidden' name='kristiine'>";
			
		}elseif(isset($_GET["lasna"])){
			
			echo "<input type='hidden' name='lasna'>";
			
		}elseif(isset($_GET["mustamae"])){
			
			echo "<input type='hidden' name='mustamae'>";
			
		}elseif(isset($_GET["nomme"])){
			
			echo "<input type='hidden' name='nomme'>";
			
		}elseif(isset($_GET["oismae"])){
			
			echo "<input type='hidden' name='oismae'>";
			
		}elseif(isset($_GET["pirita"])){
			
			echo "<input type='hidden' name='pirita'>";
			
		}
		?>
		<input type="search" name="keyword" value="<?php echo $keyword;?>">
		<input type="submit">
	</form>
	<p><a href="?peakontor">Peakontor<a>  <a href="?kopli">Kopli<a>  <a href="?kristiine">Kristiine<a>  <a href="?lasna">Lasnamäe<a>  <a href="?mustamae">Mustamäe<a>  <a href="?nomme">Nõmme<a>  <a href="?oismae">Õismäe<a>  <a href="?pirita">Pirita<a></p>
	<table border="1">
	
	

	<?php
		
		if(isset($_GET["peakontor"])){
				
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
		}
		
		if(isset($_GET["kopli"]) OR isset($_GET["kristiine"]) OR isset($_GET["lasna"]) OR isset($_GET["mustamae"]) OR isset($_GET["nomme"]) OR isset($_GET["oismae"]) OR isset($_GET["pirita"])){
				
			echo "<tr>";
			echo "<th>Saadetise id</th>";
			echo "<th>Saabumisaeg</th>";
			echo "<th>Lahkumisaeg</th>";
			echo "<th>Märkus</th>";
			echo "<th>Kustuta</th>";
			echo "<th>Edit</th>";
			echo "</tr>";
			echo "<tr>";
		}
		
		for($i = 0; $i < count($packet_array); $i=$i+1){
			
			if(isset($_GET["peakontor"])){
				
				echo "<td>".$packet_array[$i]->id."</td>";
				echo "<td>".$packet_array[$i]->arrival."</td>";
				echo "<td>".$packet_array[$i]->fromc."</td>";
				echo "<td>".$packet_array[$i]->comment."</td>";
				echo "<td>".$packet_array[$i]->office_id."</td>";
				echo "<td><a href='dataWorker.php?".$getvar."&delete=".$packet_array[$i]->id."'>X</a></td>";
				echo "<td><a href='edit.php?edit_id=".$packet_array[$i]->id."'>edit</a></td>";
				echo "</tr>";
				
			}elseif(isset($_GET["kopli"]) OR isset($_GET["kristiine"]) OR isset($_GET["lasna"]) OR isset($_GET["mustamae"]) OR isset($_GET["nomme"]) OR isset($_GET["oismae"]) OR isset($_GET["pirita"])){
				
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
</body>
