<?php
require_once("../functions.php");

?>
<h1>paride sisestamine</h1>
<table border= 1>
	<tr>
		
		<th>Pargi id</th>
		<th>korvi number</th>
		<th>PAR</th>
	<tr>
<?php
	for($i = 1; $i <= $nr_of_baskets;);{
		echo "<form action=table.php method='post'>";
		echo "<td>".$game_id."</td>";
		echo "<td>".'1'."</td>";
		echo "<td><input name='park_name'>"."</td>";
		echo "<td><input type='submit' name='add_par' value='Add'>"."</td>";
		echo "</form";
	echo "</tr>";  

	}

?>