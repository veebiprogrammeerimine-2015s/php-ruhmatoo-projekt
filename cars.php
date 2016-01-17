<?php

	$page_title = "Autod";
	$file_name = "cars.php";
	
?>

<?php
	
	require_once("header.php")

?>
<?php
	
	require_once("functions.php");
	require_once("edit_functions.php");
	
	if(isset($_POST["update"])){
		
		updateCar($_POST["model"], $_POST["make"], $_POST["color"]);
	}
	
	if(isset($_GET["delete"])){
		
		deleteCar($_GET["delete"]);
		
	}
	
	
	$car_list = getCarData();


?>

<table border=1 >
	<tr>
		<th>id</th>
		<th>Mark</th>
		<th>Mudel</th>
		<th>Värv</th>
		<th>X</th>
		<th>edit</th>
	</tr>
	
	<?php
	
		for($i = 0; $i < count($car_list); $i++){
			
			if(isset($_GET["edit"]) && $car_list[$i]->id == $_GET["edit"]){
				
				echo "<tr>";
				echo "<form action='cars.php' method='post'>";
				echo "<td>".$car_list[$i]->id."</td>";
				echo "<td><input name='model' value='".$car_list[$i]->model."'></td>";
				echo "<td><input name='make' value='".$car_list[$i]->make."'></td>";
				echo "<td><input name='color' value='".$car_list[$i]->color."'></td>";
				echo "<td><input type='submit' name='update'></td>";
				echo "<td><a href='cars.php'>cancel</a></td>";
				echo "</form>";
				echo "</tr>";
				
			}else{
			
				echo "<tr>";
				
				echo "<td>".$car_list[$i]->id."</td>";
				echo "<td>".$car_list[$i]->model."</td>";
				echo "<td>".$car_list[$i]->make."</td>";
				echo "<td>".$car_list[$i]->color."</td>";
				echo "<td><a href='?delete=".$car_list[$i]->id."'>X</a></td>";
				echo "<td><a href='edit.php?edit=".$car_list[$i]->id."'>edit</a></td>";
				
				echo "</tr>";
			}
		}
	
	?>

</table>