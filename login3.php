<?php require_once("header.php"); ?>
<?php require_once("functions.php"); ?>
<?php
 
 	
 	//kui kasutaja on sisseloginud, suunan data.php lehele
 	if(isset($_SESSION["logged_in_user_id"])){
 		header("Location: data.php");
 	}
 
 	
 	//login.php
 	
 	$email1_error = "";
 	$email2_error = "";
 	$password1_error = "";
 	$password2_error = "";
 
 	$firstname_error ="";
 	$lastname_error ="";
 	//muutujad andmebaasi väärtuse jaoks
 	$email1 ="";
 	$email2 ="";
 	$firstname ="";
 	$lastname ="";
 	$password1 ="";
 	$password2 ="";
 	
 	//kontrollime, et keegi vajutas input nuppu
 	if($_SERVER["REQUEST_METHOD"] == "POST"){
 		
 		//echo "Keegi vajutas nuppu"; sedasi tehakse kontroll ainult siis, kui vajutatakse login nuppu
 		//vajutas login nuppu
 		if(isset($_POST['login'])){
 			
 			
 			//kontrollin, et epost ei ole tühi
 			if ( empty($_POST["email1"]) ) {
 				$email1_error = "See väli on kohustuslik";
 			}else{
 				//kõik korras, test_input eemaldab pahatahtlikud osad
 				$email1 = test_input($_POST["email1"]);
 				}
 				
 			//kontrollin, et parool ei ole tühi
 			if ( empty($_POST["password1"]) ) {
 				$password1_error = "See väli on kohustuslik";	
 			} else {
 				$password1 = test_input($_POST["password1"]);
 			}
 		//Võib kasutaja sisse logida
 			if($password1_error == "" && $email1_error == ""){
 				echo "Võib sisse logida! Kasutajanimi on ".$email1." ja parool on ".$password1;
 				
 				$hash = hash("sha512", $password1);
 				
 				//kasutaja sisselogimise function,
 				loginUser($email1, $hash);
 			}
 			
 			
 			//*****************************************
 			//keegi vajutas registreeri nuppu
 		}elseif(isset($_POST['registreeri'])) {
 			
 			//kontrollin, et nimi pole tühi
 			if ( empty($_POST["firstname"]) ) {
 				$firstname_error = "See väli on kohustuslik";
 			}else{
 				//kõik korras, test_input eemaldab pahatahtlikud osad
 				$firstname = test_input($_POST["firstname"]);
 				}
 				
 				
 			// kontrollin et lastname pole tühi
 			if ( empty($_POST["lastname"]) ) {
 				$lastname_error = "See väli on kohustuslik";
 			}else{
 				//kõik korras, test_input eemaldab pahatahtlikud osad
 				$lastname = test_input($_POST["lastname"]);
 				}
 			
 			//kontrollin, et epost ei ole tühi
 			if ( empty($_POST["email2"]) ) {
 				$email2_error = "See väli on kohustuslik";
 			}else{
 				//kõik korras, test_input eemaldab pahatahtlikud osad
 				$email2 = test_input($_POST["email2"]);
 				}
 				
 			
 			//kontrollin, et parool ei ole tühi
 			if ( empty($_POST["password2"]) ) {
 				$password2_error = "See väli on kohustuslik";	
 			} else {
 				
 				
 				if(strlen($_POST["password2"]) < 8) {
 					$password2_error ="Peab olema vähemalt 8 sümbolit pikk!";
 				}else{
 					$password2 = test_input($_POST["password2"]);
 				}
 			}
 			
 			
 			//kontrollin, et paroolid klapiksid
 			if ($_POST["password2"] != $_POST["password3"]) {
 				$password3_error = "Paroolid ei kattu. Proovi uuesti.";	
 
 				}
 				
 				
 			if(	$email2_error == "" && $password2_error == ""){
 				
 				//räsi paroolist, mille salvestame andmebaasi
 				$hash = hash("sha512", $password2);
 				
 				echo "Võib kasutajat luua! Kasutajanimi on ".$email2." ja parool on ".$password2. "ja räsi on ".$hash;
 				
 				//kasutaja loomise function, failist function.php
 				//saadame kaasa muutujad
 				createUser($firstname, $lastname, $email2, $hash);
 			}
 			
 				
 			}
 		} 
 		
 		
 	function test_input($data) {	
 		$data = trim($data);	//võtab ära tühikud,enterid,tabid
 		$data = stripslashes($data);  //võtab ära tagurpidi kaldkriipsud
 		$data = htmlspecialchars($data);	//teeb htmli tekstiks, nt < läheb &lt
 		return $data;
 	}
 	
 	
 	
	?>

<html>
<body>	
<br><br><br><br><br><br>

<!-- ###################### -->
<!-- ####### SISU ######### -->
<!-- ###################### -->	

<div class="container">

	<div class="row">
		
		<div class="col-md-6 col-sm-5 col-sm-offset-1">
			<h1> Tere tulemast Jalgpalli Foorumisse! Loo endale kasutaja ning liitu tuhandete jalgpalli
armastajatega.</h1>
		</div>
		
		<div class="col-md-3 col-sm-4 col-sm-offset-1">
			
			<form>
			  <div class="form-group">
				<input type="email" name="email1" value="<?php echo $email1 ?>" class="form-control" id="exampleInputEmail1" placeholder="E-post"> <?php echo $email1_error; ?>
			  </div>
			  
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
						<input type="password" name="password1" class="form-control" id="exampleInputPassword1" placeholder="Password"> <?php echo $password1_error; ?>
						</div>
					</div>
					<div class="col-md-4">
					<button type="submit" class="btn btn-info hidden-xs ">Login</button>
					<button type="submit" class="btn btn-info btn-block visible-xs">Login</button>
					</div>
					
				
			  </div>
			  
			</form>
			
			<br><br>
			
			
			<form>
				<h1>CREATE NEW USER</h1>
			  <div class="form-group">
				<input type="email" class="form-control" value ="<?php echo $email2 ?>" name="email2" id="exampleInputEmail1" placeholder="Email"> <?php echo $email2_error; ?>
			  </div>
			  
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
						<input type="password" name="password2" class="form-control" id="exampleInputPassword1" placeholder="Password"><?php echo $password2_error; ?>
						<input type="text" value ="<?php echo $firstname ?>" name="firstname" class="form-control" id="exampleInputFirstName" placeholder="First name"><?php echo $firstname_error;?>
						<input type="text" value ="<?php echo $lastname ?>" name="lastname" class="form-control" id="exampleInputLastName" placeholder="Last name"><?php echo $lastname_error;?>
						</div>
					</div>
					<div class="col-md-4">
					<button type="submit" class="btn btn-info hidden-xs ">Registreeri</button>
					<button type="submit" class="btn btn-info btn-block visible-xs">Registreeri</button>
					</div>
					
				
			  </div>
			  
			</form>
			
		</div>
		
	</div>

</div>
</body>
</html>	