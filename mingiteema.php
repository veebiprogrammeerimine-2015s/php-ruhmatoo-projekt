<?php
	require_once("functions.php");
	require_once("header.php");
	//data.php
	// siia pääseb ligi sisseloginud kasutaja
	//kui kasutaja ei ole sisseloginud,
	//siis suuunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	//kasutaja tahab välja logida
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	
	$arvamus = "";
	$arvamus_error = "";
	
	
	// keegi vajutas nuppu numbrimärgi lisamiseks
	if(isset($_POST["add_post"])){
		
		//echo $_SESSION["logged_in_user_id"];
		
		// valideerite väljad
		
		
			if ( empty($_POST["arvamus"]) ) {
			$arvamus_error = "*See väli on kohustuslik*";
		}else{
			$arvamus = cleanInput($_POST["arvamus"]);
		}
		
		
		// mõlemad on kohustuslikud
		if($arvamus_error == ""){
			//salvestan ab
			// message funktsioonist
			$msg = addPost($arvamus);
			
			if($msg != ""){
				//õnnestus, teeme inputi väljad tühjaks
				
				$arvamus = "";
				
				
				echo $msg;
				
			}
			
		}
		
	}
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
?>

<html>


<div class="container">
		<div class="row">
			<div class="col-md-7 col-sm-3 col-sm-offset-2">
				<h1 class="text-left login-title">Teie arvamus</h1>
				<div class="account-wall">
					<form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
					<input type="text" class="form-control" name="arvamus" placeholder="Arvamus" value="<?php echo $arvamus; ?>"> <?php echo $arvamus_error; ?><br><br>
					<input name="add_post" class="btn btn-lg btn-primary btn-block" type="submit" value="Postita"><br>
					<p><a href="eestijalgpall2.php" class="btn btn-primary" role="button">Loe teiste postitatud teemasid</a></p>
					</form>
		</div>
	</div>

</body>
</html>





