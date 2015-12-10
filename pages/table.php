<?php
	require_once("../functions.php");
	
	if(isset($_GET["main"])){
			
		header("Location: main.php");
		
	}
	
	$add_name_error = "";
	$add_basket_error = "";
	
	$add_name = "";
	$add_basket = "";
	
	
	
	if(isset($_POST["add"])){
		
		if(empty($_POST["park_name"])){
				$add_name_error = "pargi nimi on kohustuslik! ";
				echo $add_name_error;
			}else{
				$add_name = $_POST["park_name"];
			}
		if(empty($_POST["basket_number"])){
				$add_basket_error = "korvide arv on kohustuslik";
				echo $add_basket_error;
			}else{
				$add_basket = $_POST["basket_number"];
			}
		
		if($add_name_error == "" && $add_basket_error == ""){
				
				$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
				$stmt = $mysqli->prepare("INSERT INTO park_list (park_name, basket_number) VALUES (?, ?)");
				$stmt->bind_param("si", $add_name, $add_basket);
				
				$stmt->execute();
				echo "Pargi lisamine õnnestus!";
				$stmt->close();
				$mysqli->close();
				
			}
	}
	
	$park_list = getParkData();
	
//pargi kustutamiseks	
	if(isset($_GET["delete"])){
		
		deletePark($_GET["delete"]);
	}
	
	

	
?>



<h2>Parkide management leht</h2>
<table border= 1>
	<tr>
		<th>id</th>
		<th>Park name</th>
		<th>number of baskets</th>
		<th>PARs</th>
		<th>X</th>
		<th>Edit</th>
		<th></th>
	</tr>
	
	<?php
		for($i = 0; $i < count($park_list); $i++){
			
			if(isset($_GET["edit"]) && $park_list[$i]->id == $_GET["edit"]){
				//kasutajale muutmiseks
				echo "<tr>";
					echo "<form action=table.php method='get'>";
						echo "<td>".$park_list[$i]->id."</td>";
						echo "<td><input name='park name' value='".$park_list[$i]->park_name."'></td>";
						echo "<td><input name='number of baskets' value='".$park_list[$i]->basket_number."'></td>";
						echo "<td><input type='submit' name='PARs' value='PARs'></td>";
						echo "<td><a href='table.php'>cancel</a></td>";
						echo "<td><input type='submit' name='update' value='muuda' ></td>";
						echo "<td></td>";
						

					echo "</form";
					
				echo "</tr>";
		
			}else{
			echo "<tr>";
			
				echo "<td>".$park_list[$i]->id."</td>";
				echo "<td>".$park_list[$i]->park_name."</td>";
				echo "<td>".$park_list[$i]->basket_number."</td>";
				echo "<td><a href='?id=".$park_list[$i]->id."&nr=".$park_list[$i]->basket_number."'><input type='submit' name'pars' value='PARs'></td>";
				echo "<td><a href='?delete=".$park_list[$i]->id."'><input type='submit' name='delete' value='X'></td>";
				echo "<td><a href='?edit=".$park_list[$i]->id."'><input type='submit' name='edit' value='edit'</td>";
				echo "<td><a href='?play=".$park_list[$i]->id."'><input type='submit' name='play' value='Mine mängima!'></td>";
				
			echo "</tr>"; 
			}
		}
	echo "<tr>";
		echo "<form action=table.php method='post'>";
			echo "<td>"."</td>";
			echo "<td><input name='park_name'>"."</td>";
			echo "<td><input name='basket_number'></td>";
			echo "<td>"."</td>";
			echo "<td>"."</td>";
			echo "<td><input type='submit' name='add' value='Add'>"."</td>";
		echo "</form";
	echo "</tr>";  
	
	
	
?>
</table>	

<p>
	<a href="?main=1">MINE AVALEHELE</a>
	
</p>