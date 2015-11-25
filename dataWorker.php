<?php
	$keyword="";
	
	if(isset($_GET["keyword"])){
		$keyword = $_GET["keyword"];
		$package_array = getCarData($keyword);
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
			<th>Edit</th>
		</tr>

	<?php
	
		for($i = 0; $i < count($car_array); $i=$i+1){
			
			if(isset($_GET["edit"]) && $car_array[$i]->id == $_GET["edit"]){
				
				echo "<tr>";
				echo "<form action='table.php' method='post'>";
				echo "<input type='hidden' name='id' value='".$car_array[$i]->id."'>";
				echo "<td>".$car_array[$i]->id."</td>";
				echo "<td>".$car_array[$i]->user."</td>";
				echo "<td><input name='plate_number' value='".$car_array[$i]->plate."'></td>";
				echo "<td><input name='color' value='".$car_array[$i]->color."'></td>";
				echo "<td><a href='table.php'>cancel</a></td>";
				echo "<td><input type='submit' name='save' value='save'></td>";
				echo "</form>";
				echo "</tr>";
				
			}else{
				
				echo "<tr>";
				echo "<td>".$car_array[$i]->id."</td>";
				echo "<td>".$car_array[$i]->user."</td>";
				echo "<td>".$car_array[$i]->plate."</td>";
				echo "<td>".$car_array[$i]->color."</td>";
				echo "<td><a href='?delete=".$car_array[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$car_array[$i]->id."'>edit</a></td>";
				echo "<td><a href='edit.php?edit_id=".$car_array[$i]->id."'>edit</a></td>";
				echo "</tr>";
				
			}
		}
	
	?>
</body>
