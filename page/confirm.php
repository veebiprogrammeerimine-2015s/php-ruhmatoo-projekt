<?php
	require_once("functions.php");
	require_once("../classes/Confirm.class.php");
	
	$Confirm = new Confirm($mysqli);
	
	if(isset($_GET["confirm"])) {
			
		$Confirm->saveNewEntry($_GET["confirm"],$_GET["user_id"]);
		
	}
	
	$Confirm->getAllData($_GET["confirm"],$_GET["user_id"]);
	
	

?>
<a href="data.php">Tagasi registreerimislehele!</a><br>
<a href="table.php">Tagasi tabeli juurde!</a><br>

<h1>Tulemused ja kommentaarid</h1>
<form action="confirm.php" method="get">
    
</form>
<table border=1>
<tr>
    
    <th>Võistlus</th>
    <th>Osaleja nimi</th>
    <th>Tulemus</th>
    <th>Hinda võistlust</th>
    <th>Kommentaarid</th>
</tr>