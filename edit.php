<?php
	require_once("functions.php");
	require_once("edit_functions.php");
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
	
	if(isSet($_GET["edit_id"])) {
			
		echo $_GET["edit_id"] ;
		
		// id oli aadressireal
		// tahaks ühte rida kõige uuemaid andmeid kus id on $_GET["edit_id"]
		
		$posts = getEditData($_GET["edit_id"]);
		//var_dump($car);
		
		}else{
			
			//ei olnud aadressireal
			echo "Viga";
			// ****edasi lehte ei laeta
			// die();
			//suuname kasutaja table.php lehele
			header("Location: eestijalgpall2.php");
			
		}
		
		if(isSet($_POST["update_post"])) {
			// vajutas muuda nuppu
			// plate ja color tulevad vormist, id tuleb adressirealt
		updatePosts($_POST["id"], $_POST["post"]);
			
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
				<h1 class="text-left login-title">Muuda arvamust</h1>
				<div class="account-wall">
					<form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
					<input type="hidden" name="id" value="<?=$_GET["edit_id"];?>">
					<input type="text" class="form-control" name="post" placeholder="Arvamus" value="<?=$posts->post;?>">
					<input name="update_post" class="btn btn-lg btn-primary btn-block" type="submit" value="Muuda"><br>
					
					</form>
		</div>
	</div>

</body>
</html>





