<?php

	$page_title = "Kasutajate autod";
	$file_name = "user_car.php";
	
?>

<?php
	
	require_once("header.php")

?>
<?php
	
	require_once("functions.php");
	
	
	$car_list = getCarDataUsers();


?>

<table border=1 >
	<tr>
		
		<th>Email</th>
		<th>Mark</th>
		<th>Mudel</th>
		<th>Värv</th>
		
	</tr>
	
	<?php
	
		for($i = 0; $i < count($car_list); $i++){
			
				echo "<tr>";
				
				
				echo "<td>".$car_list[$i]->email."</td>";
				echo "<td>".$car_list[$i]->model."</td>";
				echo "<td>".$car_list[$i]->make."</td>";
				echo "<td>".$car_list[$i]->color."</td>";
				
				
				echo "</tr>";
		}
	
	?>

</table>