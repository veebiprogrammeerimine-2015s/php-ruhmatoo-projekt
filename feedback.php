<?php
	require_once("functions.php");

	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
	}	
?>

<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?> 
	<a href="?logout=1"> Logi välja <a> 
</p>

<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">

<h2> Tagasiside</h2>
<p>
Nimi: <input type="text" name="nameis" size="20" /> 
</p>
<p>
Email:<input type="text" name="visitormail" size="20" />
</p>
<br />
<h3 align="left">Kommentaar</h3> 
<p align="left">
<textarea name="feedback" rows="6" cols="30" placeholder="Kuidas loomal läheb?"></textarea>
</p>
<p align="left">
<input type="submit" value="Anna tagasiside" />
</p>
</form>