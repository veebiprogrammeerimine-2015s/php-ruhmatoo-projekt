<?php
	require_once("functions.php");
	require_once("header.php");
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	//data.php
	// siia pääseb ligi sisseloginud kasutaja
	//kui kasutaja ei ole sisseloginud,
	//siis suuunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	



	
?>
<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?>
	<a href="?logout=1"> Logi välja </a> 
</p>
<br>
<a href="data.php"><h2>Tagasi teemade lehele</h2></a>
<br>
<h2>Postitused Eesti jalgpallist</h2>

<form action="table.php" method="get" >
	<input type="search" name="keyword" value="">
	<input type="submit" value="Otsi">
</form>




<table border=1>
	<tr>
		<th>ID</th>
		<th>USER ID</th>
		<th>Koht/Teenus</th>
		<th>Kuupäev</th>
		<th>Tagasiside</th>
		<th>Hinne 1-9</th>
		<th>Kustuta</th>
		<th>Muuda</th>
		

	</tr>

<body>

<html>


<h2>Lisa postitus</h2>


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	
	
	<label for="Date">Kuupäev</label><br>
	<input id="date" name="date" type="text" value=""> <br><br>
	
	<label for="Teema">Lisa arvamus</label><br>
	<input id="teema" name="teema" type="text" value=""> <br><br>
	<input type="submit" name="add_review" value="Lisa">
	
</form>
<a href="../table.php"><h2>Loe teiste postitusi</h2></a>
</body>
</html>


