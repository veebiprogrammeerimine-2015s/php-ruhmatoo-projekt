<?php
//laeme funktsiooni failis
	require_once("functions.php");
	

	//kontrollin, kas kasutaja on sisseloginud
	if(isset($_SESSION["id_from_db"])){
		// kui on,suunan data lehele
		header("Location: index.php");
		exit();
	}
	//muutujad väärtuste jaoks
	$create_email_error = $create_age_error = $create_name_error = $create_insurance_error = $create_gender_error = $create_personalcode_error = $create_password_error = "";
	//muutujad errorite joks
	$create_email = $create_age = $create_name = $create_insurance = $create_gender = $create_personalcode = $create_password = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		//Kasutaja loomine
		if(isset($_POST["create"])){
			//isikukood
			if ( empty($_POST["create_personalcode"]) ) {
				$create_personalcode_error = "See väli on kohustuslik";
			}else{
				$create_personalcode = cleanInput($_POST["create_personalcode"]);
			}
			//parool
			if ( empty($_POST["create_password"]) ) {
				$create_password_error = "See väli on kohustuslik";
			} else {
				if(strlen($_POST["create_password"]) < 8) {
					$create_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$create_password = cleanInput($_POST["create_password"]);
				}
			}
			//kasutajanimi
			if(empty($_POST["create_email"])){
				$create_email_error = "See väli on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["create_email"]);
			}
			//nimi
			if(empty($_POST["create_name"])){
				$create_name_error = "See väli on kohustuslik";
			}else{
				$create_name = cleanInput($_POST["create_name"]);
			}
			//vanus
			if(empty($_POST["dob"])){
				$create_age_error = "See väli on kohustuslik";
			}else{
				$create_age =  $_POST['dob'];
			}
			//sugu
			if(empty($_POST["create_gender"])){
				$create_gender_error = "See väli on kohustuslik";
			}else{
				$create_gender = $_POST["create_gender"];
			}
			//kindlustus
			if(empty($_POST["create_insurance"])){
				$create_insurance_error = "See väli on kohustuslik";
			}else{
				$create_insurance = $_POST["create_insurance"];
			}
			
			//võib kasutaja teha
			if(	$create_personalcode_error == "" && $create_password_error == "" && $create_email_error == "" && $create_name_error == "" && $create_age_error == "" && $create_gender_error == "" && $create_insurance_error == ""){
				$password_hash = hash("sha512", $create_password);
				
				if($create_insurance == "yes"){
					$create_insurance = 1;
				}else{
					$create_insurance = 0;
				}
				
			
				//käivitame funktsiooni
				$create_response = $User->createUser($create_personalcode, $password_hash, $create_email, $create_name, $create_age, $create_gender, $create_insurance);
				header("Location:login.php");
				//lõpetame php laadimise
				exit();
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
<?php
	//load header
	require_once("header.php");
?>
<html>
<head>
	
</head>
<body>

<?php if(isset($create_response->error)):?>
<p style="color:red;"><?=$create_response->error->message;?></p>
<?php elseif(isset($create_response->success)):?>
<p style="color:green;"><?=$create_response->success->message;?></p>
<?php endif;?>
	
<div class="container">
<div class="row">
<div class="page-header">
<h1>Registreeru</h1>
</div>
<form class="form-horizontal" role="form" method="post" action="#">
 
<div class="form-group">
<font style="color:red"><?php echo $create_personalcode_error; ?></font>
<label for="create_personalcode" class="col-sm-2 control-label">Isikukood:</label>
<div class="col-sm-6">
<input type="number" name="create_personalcode" class="form-control" id="create_personalcode" placeholder="Isikukood" value="<?php if(isset($_POST["create_personalcode"])){echo $create_personalcode;} ?>">

</div>
</div>

<div class="form-group">
<font style="color:red"><?php echo $create_email_error; ?></font>
<label for="create_email" class="col-sm-2 control-label">Email:</label>
<div class="col-sm-6">
<input type="email" name="create_email" class="form-control" id="create_email" placeholder="Email" value="<?php if(isset($_POST["create_email"])){echo $create_email;} ?>">
</div>
</div>
 
<div class="form-group">
<font style="color:red"><?php echo $create_name_error; ?></font>
<label for="create_name" class="col-sm-2 control-label">Ees- ja perekonnanimi:</label>
<div class="col-sm-6">
<input type="text" name="create_name" class="form-control" id="create_name" placeholder="Ees- ja perekonnanimi" value="<?php if(isset($_POST["create_name"])){echo $create_name;} ?>">
</div>
</div>

<div class="form-group">
<font style="color:red"><?php echo $create_password_error; ?></font>
<label for="passwd" class="col-sm-2 control-label">Parool:</label>
<div class="col-sm-6">
<input type="password" name="create_password" class="form-control" id="passwd" placeholder="Parool">
</div>
</div>
 
<div class="form-group">
<font style="color:red"><?php echo $create_gender_error; ?></font>
<label for="" class="col-sm-2 control-label">Sugu:</label>
<div class="col-sm-6">
<label class="radio-inline">
<input type="radio" name="create_gender" id="gender1" value="m"<?php if($_POST["create_gender"] == "m"){checked;}?>>Mees
</label>
<label class="radio-inline">
<input type="radio" name="create_gender" id="gender2" value="f"<?php if($_POST["create_gender"] == "f"){checked;}?>>Naine
</label>
 
</div>
</div>
 
<div class="form-group">
<font style="color:red"><?php echo $create_age_error; ?></font>
<label for="datepicker" class="col-sm-2 control-label">Sünnikuupäev:</label>
<div class="col-sm-6">
<input type="text" name="dob" class="form-control datepicker" id="datepicker" placeholder="Sünnikuupäev" value="<?php if(isset($_POST["dob"])){echo $create_age;} ?>">
</div>
</div>

<div class="form-group">
<font style="color:red"><?php echo $create_insurance_error; ?></font>
<label for="" class="col-sm-2 control-label">Kas ravikindlustus on olemas?:</label>
<div class="col-sm-6">
<label class="radio-inline">
<input type="radio" name="create_insurance" id="insurance1" value="yes" <?php if($_POST["create_insurance"] == "yes"){checked;}?>>Jah
</label>
<label class="radio-inline">
<input type="radio" name="create_insurance" id="insurance2" value="no"<?php if($_POST["create_insurance"] == "no"){checked;}?>>Ei
</label>

</div>
</div>

<div class="form-group">
<div class="col-sm-offset-2 col-sm-10">
<button type="submit" class="btn btn-primary" name="create" id="register">Loo kasutaja</button>
</div>
</div>
</form>

</div><!-- end for class "row" -->
</div><!-- end for class "container" -->
</body>
<!-- bootstrap -->
</html>
<?php
	//load footer
	require_once("footer.php");
?>