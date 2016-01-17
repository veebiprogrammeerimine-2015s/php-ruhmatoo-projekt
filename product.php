<?php
require_once("header.php");
require_once("postmenu.php");
?>



<?php

	
	// siia lisame auto nr märgite vormi
	//laeme funktsiooni failis
	require_once("function.php");
	
	//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		// suunan login lehele
		header("Location: home.php");
	echo "on vaja registreerida ikka!";
	}
	
	//login välja, aadressireal on ?logout=1
	if(isset($_GET["logout"])){
		//kustutab kõik sessiooni muutujad
		session_destroy();
		
		header("Location: home.php");
	
	}
?>


<?php
$product_name = $product_year = $product_problem = $product_name_error = $product_year_error = $product_problem_error = "";
	
	// et ei ole tühjad
	// clean input
	// salvestate
	
	if(isset($_POST["create_ok"])){
		if ( empty($_POST["product_name"]) ) {
			$product_name_error = "See väli on kohustuslik";
	      }else{
			$product_name = cleanInput($_POST["product_name"]);
		}
		
		if ( empty($_POST["product_year"]) ) {
			$product_year_error = "See väli on kohustuslik";
	      }else{
			$product_year = cleanInput($_POST["product_year"]);
		}
		
		if ( empty($_POST["product_problem"]) ) {
			$product_problem_error = "See väli on kohustuslik";
	       }else{
			$product_problem = cleanInput($_POST["product_problem"]);
		}
		
		if(	$product_name_error == "" && $product_year_error == "" && $product_problem_error == "" ){
			
			// functions.php failis käivina funktsiooni
			// msq on message funktsioonist mis tagasi saadame
			$msg3 = createProduct($product_name, $product_year, $product_problem);
			
			if($msg3 != ""){
				//salvestamine õnnestus
				// teen tühjaks input value'd
				$product_name = "";
				$product_year = "";
				$product_problem = "";
								
				echo $msg3;
				
			}
			
		}
   } // create if end

function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  return $data;
  }
	
?>


<html>
<p>
	<?=$_SESSION["email_from_db"];?>
	<a href="?logout=1"> Logi valja</a>
</p>

 <h2>Lisa parandus</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="product_name">Nimetus</label><br>
	<input id="product_name" name="product_name" type="text" value="<?=$product_name; ?>"> <?=$product_name_error; ?><br><br>
	  <label for="product_year" >Aasta</label><br>
	<input id="product_year" name="product_year" type="text" value="<?=$product_year; ?>"> <?=$product_year_error; ?><br><br>
	  <label for="product_problem">Probleem</label><br>
	<input id="product_problem" name="product_problem" type="text" value="<?=$product_problem; ?>"> <?=$product_problem_error; ?><br><br>
  	<input type="submit" name="create_ok" value="Salvesta">
  </form>
</html>

<?php require_once("user_profi/data.php");?>
 
<?php require_once("header.php");?>
<?php require_once("foother.php");?>