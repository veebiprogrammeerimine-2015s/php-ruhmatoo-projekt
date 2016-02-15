<?php
	require_once("header.php"); 	
	require_once("functions.php");
?>

<?php
	$review_list = getreviews();
?>

<!DOCTYPE html>
<html lang="et">
<head>
<meta charset="utf-8">
<title>Top10</title>
<body>


<table border=1 >
		<tr>
			<th>Arvustaja number</th>
			<th>Arvustuse kuup�ev</th>
			<th>Asutus</th>
			<th>Kokteilid</th>
			<th>Teeninduse �ldhinne</th>
			<th>Atmosf��ri �ldhinne</th>
			<th>Hinnatase</th>		
			<th>�ldine koondhinne</th>
			<th>Lisainfo</th>
		</tr>

		<?php
			for($i = 0; $i < count($review_list); $i++){
				echo "<tr>";
				echo "<td>".$review_list[$i]->user_id."</td>";
				echo "<td>".$review_list[$i]->date."</td>";
				echo "<td>".$review_list[$i]->bar."</td>";
				echo "<td>".$review_list[$i]->cocktails."</td>";
				echo "<td>".$review_list[$i]->service."</td>";
				echo "<td>".$review_list[$i]->interior."</td>";
				echo "<td>".$review_list[$i]->prices."</td>";
				echo "<td>".$review_list[$i]->score."</td>";
				echo "<td>".$review_list[$i]->info."</td>";
			}
		?>

</table>
</body>
</html>
<?php require_once("footer.php") ?>