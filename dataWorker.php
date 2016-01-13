<?php
	
	require_once("worker.class.php");
	require_once("header.php");
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
		exit();
	}
	
	if(isset($_GET["logout"])){
		session_destroy();
		
		header("Location: login.php");
	}
	
	$Worker = new Worker($mysqli);
	$getvar = key($_GET);
	
	if(empty($_GET)){
		
		Header("Location: ?office=peakontor");
		
	}
	
	$office = $_GET["office"];
	
	if(isset($_GET["delete"])){
		
		$Worker->deletePacket($office, $_GET["delete"]);
		
	}
	
	$keyword="";
	
	if(isset($_GET["keyword"])){
		
		$keyword = $_GET["keyword"];
		$packet_array = $Worker->getPacketData($office, $keyword);
		
	}else{
		
		$packet_array = $Worker->getPacketData($office);
		
	}
	
?>

	<p>Tere, <?php echo $_SESSION["logged_in_user_email"];?>.</p>
	
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
	<table border="1" class="table">
	
	
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
				echo "<td><a href='dataWorker.php?office=".$office."&delete=".$packet_array[$i]->id."'>X</a></td>";
				echo "<td><a href='edit.php?office=".$office."&edit_id=".$packet_array[$i]->id."'>edit</a></td>";
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
				echo "<td><a href='dataWorker.php?office=".$office."&delete=".$packet_array[$i]->id."'>X</a></td>";
				echo "<td><a href='edit.php?office=".$office."&edit_id=".$packet_array[$i]->id."'>edit</a></td>";
				echo "</tr>";
			}	
		}
	
	?>
	
	
	</table>
	
	</div>

	<p>
		<a href="addPacket.php?office=<?=$office; ?>">Lisa uus pakend</a>
	</p>
	
<?php require_once("footer.php"); ?>