<?php
	
	require_once("functions.php");
	
	if(isset($_GET["delete"])){
		
		deleteCar($_GET["delete"]);
		
	}
	
	
	$car_list = getCarData();


?>

<table border=1 >
	<tr>
		<th>id</th>
		<th>kasutaja id</th>
		<th>auto mark</th>
		<th>auto mudel/th>
		<th>auto värv</th>
		<th>X</th>
		<th>edit</th>
	</tr>
	
	<?php
	
		for($i = 0; $i < count($car_list); $i++){
			
			if(isset($_GET["edit"]) && $car_list[$i]->id == $_GET["edit"]){
				
				echo "<tr>";
				echo "<form action='table.php' method='post'>";
				echo "<td>".$car_list[$i]->id."</td>";
				echo "<td>".$car_list[$i]->user_id."</td>";
				echo "<td><input name='car_model' value='".$car_list[$i]->car_model."'></td>";
				echo "<td><input name='car_make' value='".$car_list[$i]->car_make."'></td>";
				echo "<td><input name='color' value='".$car_list[$i]->color."'></td>";
				echo "<td><input type='submit' name='update'></td>";
				echo "<td><a href='table.php'>cancel</a></td>";
				echo "</form>";
				echo "</tr>";
				
			}else{
			
				echo "<tr>";
				
				echo "<td>".$car_list[$i]->id."</td>";
				echo "<td>".$car_list[$i]->user_id."</td>";
				echo "<td>".$car_list[$i]->car_make."</td>";
				echo "<td>".$car_list[$i]->car_model."</td>";
				echo "<td>".$car_list[$i]->color."</td>";
				echo "<td><a href='?delete=".$car_list[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$car_list[$i]->id."'>edit</a></td>";
				
				echo "</tr>";
			}
		}
	
	?>

</table>