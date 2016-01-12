<?php require_once("headernav.php"); ?>
<?php require_once("functions.php") ?>
<?php

	$create_email_error = "";
	$create_password_error = "";
	$firstname_error = "";
	$lastname_error = "";
	$create_email = "";
	$create_password = "";
	$firstname="";
	$lastname="";



if(isset($_POST["create"])){
				if ( empty($_POST["create_email"]) ) {
					$create_email_error = "See väli on kohustuslik";
				}else{
					$create_email = cleanInput($_POST["create_email"]);
				}
				if ( empty($_POST["create_password"]) ) {
					$create_password_error = "See väli on kohustuslik";
				} else {
					if(strlen($_POST["create_password"]) < 8) {
						$create_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
					}else{
						$create_password = cleanInput($_POST["create_password"]);
					}
							
				}
					if (empty ($_POST["firstname"])){
				$firstname_error = "See väli on kohustuslik!";
			}else{
				$firstname = test_input($_POST["firstname"]);
			}
			
			if (empty ($_POST["lastname"])){
				$lastname_error = "See väli on kohustuslik!";
			}else{
				$lastname = test_input($_POST["lastname"]);
			}	
					
					
				
				if(	$create_email_error == "" && $create_password_error == "" && $firstname_error == "" && $lastname_error == ""){
					
					// räsi paroolist, mille salvestame ab'i
					$hash = hash("sha512", $create_password);
					
					echo "Võib kasutajat luua! Kasutajanimi on ".$create_email." ja parool on ".$create_password." ja räsi on ".$hash .$firstname.$lastname;
					
					// kasutaja loomise fn, failist functions.php,
					// saadame kaasa muutujad
					createUser($create_email, $hash, $firstname, $lastname);
					
				}
		} // create if end
	
  // funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
   function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}




?>


<html>

<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Registreeri</h1>
            <div class="account-wall">
                <img class="profile-img" src="pildid/jalgpall.ico"
                    alt="sveg">
                <form class="form-signin">
                <input type="text" class="form-control" placeholder="Email" name="create_email" required autofocus> <?php echo $create_email_error; ?> <br>
                <input type="text" class="form-control" placeholder="Eesnimi" name="firstname" required autofocus> <?php echo $create_password_error; ?> <br>
				<input type="text" class="form-control" placeholder="Perekonnanimi" name="lastname" required autofocus> <?php echo $firstname_error;?> <br>
                <input type="password" class="form-control" name="parool2" placeholder="Parool" required> <?php echo $lastname_error;?> <br>
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Registreeri</button>
					
                
                
                </form>
            </div>
            
        </div>
    </div>
</div>
  </body>
  </html>