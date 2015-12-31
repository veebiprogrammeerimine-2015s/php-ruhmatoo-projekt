<?php
	//Lehe nimi
	$page_title = "Avaleht";
	//Faili nimi
	$page_file = "home.php";
?>

<?php
	require_once("../inc/functions.php");

	//variables
	$create_email = "";
	$create_password = "";


	//errors
	$create_email_error = "";
	$create_password_error = "";

	if( $_SERVER["REQUEST_METHOD"] == "POST") {
	//register start
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
			if(	$create_email_error == "" && $create_password_error == ""){
                // tekitan parooliräsi
                $hash = hash("sha512", $create_password);

				$response = $User->createUser($create_email, $hash);

            }
        }

		if(isset($_POST["create_employer"])){
			if ( empty($_POST["createE_email"]) ) {
				$create_email_error = "See väli on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["createE_email"]);
			}
			if ( empty($_POST["createE_password"]) ) {
				$create_password_error = "See väli on kohustuslik";
			} else {
				if(strlen($_POST["createE_password"]) < 8) {
					$create_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$create_password = cleanInput($_POST["createE_password"]);
				}
			}
			if(	$create_email_error == "" && $create_password_error == ""){
                // tekitan parooliräsi
                $hash = hash("sha512", $create_password);

				$response = $User->createEmployer($create_email, $hash);

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
	require_once("../menu.php");
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


<div class="col-xs-12 col-sm-6">
<h1>Info</h1>
<p>Kui soovid kasutajat luua siis suundu paremale!</p>
<p>Kui aga konto olemas siis palun logi sisse!</p>

<p>Kõik väljad on kohustuslikud!</p>
<p></p>
</div>

<div class="col-xs-12 col-sm-6">
  <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<div class="form-group">
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#applicant" aria-controls="applicant" role="tab" data-toggle="tab">Tööotsija</a></li>
		<li role="presentation"><a href="#employer" aria-controls="employer" role="tab" data-toggle="tab">Tööandja</a></li>
	  </ul>
	</div>
  <!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="applicant">

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
			<input class="btn btn-default btn-sm btn-block"type="submit" name="create" value="Loo konto">
		</div>


  </div>
    <div role="tabpanel" class="tab-pane" id="employer">

		<div class="form-group">
			<h1>Registreeru tööandjaks</h1>
		  </div>
		<div class="form-group">
			<input class="form-control input-sm" name="createE_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?>
		</div>
		<div class="form-group">
			<input class="form-control input-sm" name="createE_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?>
		</div>
		<div class="form-group">
			<input class="btn btn-default btn-sm btn-block"type="submit" name="create_employer" value="Loo konto">
		</div>

	</div>
  </div>
  </form>
</div>

<?php require_once("../footer.php"); ?>
