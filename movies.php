<?php 
	require_once("page/header.php"); 
	require_once("page/functions.php");
?>

<p>
<h1>Filmid</h1>
<table border=1>
	<tr>
		<th>Filmi nimi</th>
		<th>Aasta</th>
		<th>Režissöör</th>
		<th>Vaata filmi</th>
	</tr>
</p>

<?php

	$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	$movie_array=$user->getCategory($url);
	
	for($i = 0;$i < count($movie_array);$i++){
		echo "<tr>";
			echo "<td>".$movie_array[$i]->Name."</td>";
			echo "<td>".$movie_array[$i]->Year."</td>";
			echo "<td>".$movie_array[$i]->Director."</td>";
			echo "<td><a href='?watch=".$movie_array[$i]->Name."'>Vaata</a></td>";
			echo "</tr>";
		
	
	}
	
	
?>






<?php require_once("page/footer.php"); ?>