<?php
	require_once("../functions.php");

	//variables
	$create_email = $create_password = $code = $firstname = $lastname = $school = "";

	//errors
	$create_email_error = $create_password_error = $code_error = $firstname_error = $lastname_error = $school_error = "";

	if($_SERVER["REQUEST_METHOD"] == "POST") {
	//register start
	    if(isset($_POST["create"])){
			if (empty($_POST["create_email"]) ) {
				$create_email_error = "See väli on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["create_email"]);
			}
			
			if (empty($_POST["create_password"]) ) {
				$create_password_error = "See väli on kohustuslik";
			} else {
				if(strlen($_POST["create_password"]) < 8) {
					$create_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$create_password = cleanInput($_POST["create_password"]);
				}
				
			if (empty($_POST["code"]) ) {
				$code_error = "See väli on kohustuslik";
			}else{
				$code = cleanInput($_POST["code"]);
			}
			
			if (empty($_POST["firstname"]) ) {
				$firstname_error = "See väli on kohustuslik";
			}else{
				$firstname = cleanInput($_POST["firstname"]);
			}
			
			if (empty($_POST["lastname"]) ) {
				$lastname_error = "See väli on kohustuslik";
			}else{
				$lastname = cleanInput($_POST["lastname"]);
			}
			
			if (empty($_POST["school"]) ) {
				$school_error = "See väli on kohustuslik";
			}else{
				$school = cleanInput($_POST["school"]);
			}
			
			}
			
			if($create_email_error == "" && $create_password_error == "" && $code_error == "" && $firstname_error == "" && $lastname_error == "" && $school_error == ""){
                // tekitan parooliräsi
                $hash = hash("sha512", $create_password);
                
				$response = $User->createUser($create_email, $hash, $code, $firstname, $lastname, $school);
                
            }
        }
				
	}
//register end

?>
<?php
	//Lehe nimi
	$page_title = "Konto loomine";
	//Faili nimi
	$page_file = "register.php";
?>
<?php 
	require_once("../header.php"); 

?>

	  
<?php if(isset($response->success)): ?>

<div class="alert alert-success alert-dismissible fade in" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<p><?=$response->success->message;?></p>
</div>

<?php elseif(isset($response->error)): ?>

<div class="alert alert-danger alert-dismissible fade in" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<p><?=$response->error->message;?></p>
</div>

<?php endif; ?>
		  
<div class="row">
<div class="col-xs-12 col-sm-6 col-lg-6">
  <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<div class="form-group">

		<div class="form-group">
			<h1>Registreeru</h1>
		  </div>
		  
		<div class="form-group">
			<input class="form-control input-sm" name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?>
		</div>
		
		<div class="form-group">
			<input class="form-control input-sm" name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?>
		</div>		
		
		<div class="form-group">
			<input class="form-control input-sm" name="code" type="text" placeholder="Üliõpilase kood" value="<?php echo $code; ?>"> <?php echo $code_error; ?>
		</div>
		
		<div class="form-group">
			<input class="form-control input-sm" name="firstname" type="text" placeholder="Eesnimi" value="<?php echo $firstname; ?>"> <?php echo $firstname_error; ?>
		</div>
		
		<div class="form-group">
			<input class="form-control input-sm" name="lastname" type="text" placeholder="Perekonnanimi" value="<?php echo $lastname; ?>"> <?php echo $lastname_error; ?>
		</div>
		
		
		<div class="form-group">
			<input class="form-control input-sm" name="school" type="text" placeholder="Kool" value="<?php echo $school; ?>"> <?php echo $school_error; ?>
		</div>

		<div class="form-group">
			<input class="btn btn-default btn-sm btn-block"type="submit" name="create" value="Loo konto">
		</div>
	</div>
  </form>
</div>
</div>

<?php require_once("../footer.php"); ?>
	