<?php
	require_once("../header.php"); 	
	require_once("functions.php");
?>


<?php
	$review_list = getreviews();
?>


<html lang="et">
<head>
<meta charset="utf-8">
<title>Toetajad</title>
<body>


<table border=1 >
		<tr>
			<th>Asutus</th>
			<th>Info</th>
			<th>Koduleht</th>
			
		</tr>

		<?php
			for($i = 0; $i < count($review_list); $i++){
				echo "<tr>";
				echo "<td>".$sponsors[$i]->bar."</td>";
				echo "<td>".$sponsors[$i]->info."</td>";
				echo "<td>".$sponsors[$i]->url."</td>";
			}
		?>

</table>
</body>
</html>
<?php require_once("../footer.php") ?>