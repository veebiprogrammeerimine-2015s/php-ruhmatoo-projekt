<?php
	require_once("functions.php");
	//data.php
	// siia pääseb ligi sisseloginud kasutaja
	//kui kasutaja ei ole sisseloginud,
	//siis suuunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	

?>
<div align =left>
<br>
<p><a href="data.php" class="btn btn-primary" role="button">Tagasi teemade lehele</a></p>
<br>

<h2>Postitused Eesti jalgpallist</h2>

<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <h1 class="text-left login-title">Otsing</h1>
            <div class="account-wall">
                  <form class="form-signin" action="table.php" method="get">
                <input type="search" class="form-control" name="keyword" placeholder="Email"><br>
                <input name="login" class="btn btn-lg btn-primary btn-block" type="submit" value="Logi sisse">
                </form>
            </div>
        </div>
    </div>
</div>


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

	<div class="container">
		<div class="row">
			<div class="col-sm-4 col-md-4">
				<h1 class="text-left login-title">Postita</h1>
				<div class="account-wall">
					<form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
					<input type="password" class="form-control" name="password" placeholder="Arvamus"><br>
					<input name="postita" class="btn btn-lg btn-primary btn-block" type="submit" value="Postita"><br>
					</form>
		</div>
	</div>

<p><a href="table.php" class="btn btn-primary" role="button">Loe teiste postitatud teemasid</a></p>
</body>
</html>
</div>

