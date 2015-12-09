<?php
	require_once("../functions.php");
	// kas kustutame
	// ?delete=vastav id mida kustutada on aadressireal
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	if(isset($_GET["delete"])){
		
		echo "Kustutame id ".$_GET["delete"];
		//käivitan funktsiooni, saadan kaasa id!
		deleteSeries($_GET["delete"]);
		
	}
	
	//salvestan andmebaasi uuendused
	if(isset($_POST["save"])){
		
		updateSeries($_POST["id"], $_POST["title"], $_POST["series"], $_POST["description"], $_POST["picture"]);
	}
	
	
	$keyword = "";
	
	if(isset($_GET["keyword"])){
		
		$keyword = $_GET["keyword"];
		$array_of_series = getPosts($keyword);
		
	}else{
		
		//käivitan funktsiooni
	$array_of_series = getPosts();
	}
	
	
	

?>

<h2>Series list</h2>

<form action="table.php" method="get">
	<input type="search" name="keyword" value="<?=$keyword;?>">
	<input type="submit" value="Otsi">
</form>

<table >
	<tr>
		
		<th>Name</th>
		<th>Season</th>
		<th>Description</th>
		<th>Photo</th>
		<th>Add to list</th>
	</tr>
	
	<?php
		// trükime välja read
		// massiivi pikkus count()
		for($i = 0; $i < count($array_of_series); $i++){
			//echo $array_of_series[$i]->id;
			
			//näitame aiunult mida tohib muuta
			if( $array_of_series[$i]->user_id == $_SESSION["logged_in_user_id"] ){
				
				
				//kasutaja tahab muuta seda rida
				if(isset($_GET["edit"]) && $array_of_series[$i]->id == $_GET["edit"]){
					
					echo "<tr>";
					echo "<form action='table.php' method='post'>";
					echo "<input type='hidden' name='id' value='".$array_of_series[$i]->id."'>";
					
					echo "<td><input name='title' value='".$array_of_series[$i]->title."'></td>";
					echo "<td><input name='media' value='".$array_of_series[$i]->season."'></td>";
					echo "<td><input name='media' value='".$array_of_series[$i]->description."'></td>";
					echo "<td><input name='media' value='".$array_of_series[$i]->picture."'></td>";
					echo "<td><a href='table.php'>cancel</a></td>";
					echo "<td><input type='submit' name='save'></td>";
					echo "</form>";
					echo "</tr>";
					
				}else{
					
					echo "<tr>";
					
					echo "<td>".$array_of_series[$i]->title."</td>";
					echo "<td>".$array_of_series[$i]->season."</td>";
					echo "<td>".$array_of_series[$i]->description."</td>";
					echo "<td><img src='".$array_of_series[$i]->picture."' width='200px'></td>";

					
					echo "</tr>";
					
				}
			}
			
		}
	
	
	?>
</table>