<?php
	require_once("../functions.php");
	require_once("../header.php"); 
	

//login välja	
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
	}

	
	//kontrollin, kas kasutaja ei ole sisseloginud	
	if(!isset($_SESSION["id_from_db"])){
		header("Location: login.php");

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
				$stmt = $mysqli->prepare("INSERT INTO parks_php (park_name, nr_of_baskets) VALUES (?, ?)");
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

//PARide sisestamiseks
	if(isset($_POST["pars"])){
		$park_id = $_GET["id"];
		$nr_of_baskets = $_GET["nr"];
		
		insertPars($park_id, $nr_of_baskets);
		
		header("Location: insert_pars.php");
	}

	
?>



<h2>Please, insert new disc golf park</h2>
<table class="center" border= 1>
	<tr>
		<th>id</th>
		<th>Park name</th>
		<th>Number of baskets</th>
		<th>Number of PARs</th>
		<th>X</th>
		<th>Edit</th>
		
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
						echo "<td><input type='submit' name='pars' value='PARs'></td>";
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
				echo "<td><a href='insert_pars.php?id=".$park_list[$i]->id."&nr=".$park_list[$i]->basket_number."'> 	PARs</a></td>";
				echo "<td><a href='?delete=".$park_list[$i]->id."'><input type='submit' name='delete' value='X'></td>";
				echo "<td><a href='?edit=".$park_list[$i]->id."'><input type='submit' name='edit' value='edit'</td>";
				
				
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

