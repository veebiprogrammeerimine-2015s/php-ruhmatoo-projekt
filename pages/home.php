<?php require_once("../header.php"); ?>
<?php require_once("../functions.php"); ?>
<?php require_once("../classes/Series.class.php"); ?>

home sortBy date_created limit = 4 - peaks andma 4 viimast sisestaud seriaali

<?php
	$Series = new Series($mysqli, $_SESSION["logged_in_user_id"]);
	
	
	$keyword = "";
	
	if(isset($_GET["keyword"])){
		
		$keyword = $_GET["keyword"];
		$series_array = getSeries($keyword);
		
	}else{
		
		//käivitan funktsiooni
		$series_array = getSeries();
	}
	
	
	if(isset($_POST["createList"])){
	
		// 1 seriaali id, 2 listi id
		//saveToList($_POST["add"], $_POST["new_dd_selection"]);
		
		
		// VAATA series.class rida 133
		$Series->addToList($_POST["add"], $_POST["new_dd_selection"]);
	}
	

	
?>


<h2>Series list</h2>

<form action="home.php" method="get">
	<input type="search" name="keyword" value="<?=$keyword;?>">
	<input type="submit" value="Otsi">
</form>

<table >
	<tr>
		
		<th>Name</th>
		<th>Season</th>
		<th>Description</th>
		<th>Picture</th>
		<th>Add to list</th>
	</tr>
	
	<?php
	
		
		var_dump($_POST);
	
		// trükime välja read
		// massiivi pikkus count()
		for($i = 0; $i < count($series_array); $i++){
			//echo $series_array[$i]->id;
			
					
					echo "<tr>";
					
					echo "<td>".$series_array[$i]->title."</td>";
					echo "<td>".$series_array[$i]->season."</td>";
					echo "<td>".$series_array[$i]->description."</td>";
					echo "<td><img src='".$series_array[$i]->picture."' width='200px'></td>";
					echo "<td><a href='?add=".$series_array[$i]->id."'>Lisa</a></td>";
					
					if(isset($_GET["add"]) && $series_array[$i]->id == $_GET["add"]){
						echo "<td>"; ?>
							
							<form method="post">
								<input type="hidden" name="add" value="<?=$_GET["add"];?>" type="text">
								<?php echo dropdown($_GET["add"]); ?>
								<input type="submit" name="createList" value="Submit">
							</form>

						<?php echo "</td>";
					} 
					
					echo "</tr>";
					
				
			
			
		}
	
	
	?>
</table>

<?php require_once("../footer.php"); ?>