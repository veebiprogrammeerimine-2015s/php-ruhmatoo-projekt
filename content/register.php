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
	$create_employer_email = "";
	$create_employer_password = "";

	//errors
	$create_email_error = "";
	$create_password_error = "";
	$create_employer_email_error = "";
	$create_employer_password_error = "";

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
				$create_employer_email_error = "See väli on kohustuslik";
			}else{
				$create_employer_email = cleanInput($_POST["createE_email"]);
			}
			if ( empty($_POST["createE_password"]) ) {
				$create_employer_password_error = "See väli on kohustuslik";
			} else {
				if(strlen($_POST["createE_password"]) < 8) {
					$create_employer_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$create_employer_password = cleanInput($_POST["createE_password"]);
				}
			}
			if(	$create_employer_email_error == "" && $create_employer_password_error == ""){
                // tekitan parooliräsi
                $hash = hash("sha512", $create_employer_password);

				$response = $User->createEmployer($create_employer_email, $hash);

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
<p>Palume kasutada konto loomisel korrektseid andmeid!</p>
<p><strong>Tööotsija</strong> emaili kasutatakse ka edaspidi, näiteks CV saatmisel.</p>
<p><strong>Tööpakkuja</strong> peab profiilis täitma ära enda ettevõtte andmed,</p>
<p>samuti sisestama emaili kuhu pakkumised saadetakse!</p>

<p><strong>NB! Kõik väljad on kohustuslikud!</strong></p>
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
			<label for="create_email">Email</label>
			<input class="form-control input-sm" name="create_email" id="help_email" type="email" placeholder="E-post" onmouseover="helpEmail()" data-toggle="tooltip" data-placement="top" title="Teie tõene emaili aadress." value="<?php echo $create_email; ?>">
			<strong style="color: red;"><?php echo $create_email_error; ?></strong>

		</div>
		<div class="form-group" id="help_pass">
			<label for="create_password">Parool</label>
			<input class="form-control input-sm" name="create_password" id="create_pass" type="password" placeholder="Parool" onmouseover="helpPass()"  data-toggle="tooltip" data-placement="top" title="Vähemalt 8 tähemärki!">
			<strong style="color: red;"><?php echo $create_password_error; ?></strong>

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
			<label for="create_Eemail">Email</label>
			<input class="form-control input-sm" name="createE_email" id="help_Eemail" type="email" placeholder="E-post" onmouseover="helpEEmail()" data-toggle="tooltip" data-placement="top" title="Teie tõene emaili aadress."  value="<?php echo $create_employer_email; ?>">
			<strong style="color: red;"> <?php echo $create_employer_email_error; ?></strong>
		</div>
		<div class="form-group" id="help_Epass">
			<label for="create_Epassword">Parool</label>
			<input class="form-control input-sm" name="createE_password" id="create_Epass" type="password" placeholder="Parool" onmouseover="helpEPass()" data-toggle="tooltip" data-placement="top" title="Vähemalt 8 tähemärki!">
			<strong style="color: red;"> <?php echo $create_employer_password_error; ?></strong>
		</div>
		<div class="form-group">
			<input class="btn btn-default btn-sm btn-block"type="submit" name="create_employer" value="Loo konto">
		</div>

	</div>
  </div>
  </form>

</div>

<script>

	function passwordLength() {
		var pass = $("#create_pass").val();
		var epass = $("#create_Epass").val();

		if (pass.length < 8)
			document.getElementById("help_pass").className = "form-group has-error";
		else
			document.getElementById("help_pass").className = "form-group has-success";
		if (epass.length < 8)
			document.getElementById("help_Epass").className = "form-group has-error";
		else
			document.getElementById("help_Epass").className = "form-group has-success";
	}

	function helpEmail() {
			$('#help_email').tooltip('show');
	}

	function helpPass() {
			$('#create_pass').tooltip('show');
	}

	function helpEEmail() {
			$('#help_Eemail').tooltip('show');
	}

	function helpEPass() {
			$('#create_Epass').tooltip('show');
	}

	$(document).ready(function () {
		 $("#create_pass").keyup(passwordLength);
		 $("#create_Epass").keyup(passwordLength);
	});

</script>

<?php require_once("../footer.php"); ?>
