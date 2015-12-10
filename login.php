<?php
	//load header
	require_once("header.php");
?> 
<!--main code start here --> 

<?php
//laeme funktsiooni failis
	require_once("functions.php");
	//*******************//
	//***Kuhu suunata?***//
	//*******************//
	//kontrollin, kas kasutaja on sisseloginud
	/*if(isset($_SESSION["id_from_db"])){
		// suunan data lehele
		header("Location: data.php");
		exit();
	}*/
	
	// muuutujad errorite jaoks
	$personalcode_error = $password_error = $gender_error = $insurance_error = $name_error = $age_error = $email_error = "";
	// muutujad väärtuste jaoks
	$personalcode = $password = $gender = $insurance = $name = $age = $email = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		// Sisse logimine
		if(isset($_POST["login"])){
			//isikukood
			if(empty($_POST["email"])){
				$email_error = "See väli on kohustuslik";
			}else{
				// puhastame muutuja võimalikest üleliigsetest sümbolitest
				$email = cleanInput($_POST["email"]);
			}
			//parool
			if(empty($_POST["password"])){
				$password_error = "See väli on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}
			
			// Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){

				$password_hash = hash("sha512", $password);
				// käivitan funktsiooni
				$login_response = $User->loginUser($email, $password_hash);
				if(isset($login_response->success)){
					//läks edukalt, peab sessiooni salvestama
					$_SESSION["id_from_db"] = $login_response->success->user->id;
					$_SESSION["un_from_db"] = $login_response->success->user->email;
					$_SESSION["role_from_db"] = $login_response->success->user->role;
					//***********************************//
					//**suunamine peale sisse logimist?**//
					//***********************************//
					/*header("Location:data.php");
					//lõpetame php laadimise
					exit();*/
				}
			}
		}
	}
  // funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
?>
<!-- main code start here -->  

<html>
<head>
	
</head>
<body>

<?php if(isset($login_response->error)):?>
<p style="color:red;"><?=$login_response->error->message;?></p>
<?php elseif(isset($login_response->success)):?>
<p style="color:green;"><?=$login_response->success->message;?></p>
<?php endif;?>
	
<div class="container">
<div class="row">
<div class="page-header">
<h1>Logi sisse</h1>
</div>
<form class="form-horizontal" role="form" method="post" action="#">
 
<div class="form-group">
<font style="color:red"><?php echo $email_error; ?></font>
<label for="email" class="col-sm-2 control-label">Email:</label>
<div class="col-sm-6">
<input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php if(isset($_POST["email"])){echo $email;} ?>">
</div>
</div>

<div class="form-group">
<font style="color:red"><?php echo $password_error; ?></font>
<label for="passwd" class="col-sm-2 control-label">Parool:</label>
<div class="col-sm-6">
<input type="password" name="password" class="form-control" id="passwd" placeholder="Parool">
</div>
</div>


<div class="form-group">
<div class="col-sm-offset-2 col-sm-10">
<button type="submit" class="btn btn-primary" name="login" id="login">Logi sisse</button>
</div>
</div>
</form>

</div><!-- end for class "row" -->
</div><!-- end for class "container" -->
</body>
<!-- bootstrap -->
</html>

<!-- main code end here ---->  
<?php
	//load footer
	require_once("footer.php");	
?> 
    