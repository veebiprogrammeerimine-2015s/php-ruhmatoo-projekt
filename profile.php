<?php
	//Lehe nimi
	$page_title = "Profiil";
	//Faili nimi
	$page_file = "profile.php";
	require_once("header.php");
	require_once("functions.php");
?>

<?php 
	if(!isset($_SESSION['logged_in_user_id'])) {
	header("Location: noaccess.php");
	exit();
	}
?>

<?php
	$create_company = $create_email ="";
	$create_company_error = $create_email_error = "";
	$response = "";
	$company_check = $Profile->companyCheck($_SESSION['logged_in_user_id']);

	if( $_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_POST["add_company"])){
			if (empty($_POST["create_company"]) ) {
				$create_company_error = "See väli on kohustuslik";
			}else{
				$create_company = cleanInput($_POST["create_company"]);
			}
			if (empty($_POST["create_email"]) ) {
				$create_email_error = "See väli on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["create_email"]);
			}
			if($create_company_error == "" && $create_email_error == ""){
				$response = $Profile->createCompany($create_company, $create_email);
			}
		}
	}
?>

<?php if($_SESSION['logged_in_user_group'] == 1):?>
Otsija profiil

<?php elseif($_SESSION['logged_in_user_group'] == 2): ?>
<div class="row">
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
<div class="col-xs-12 col-sm-4">
	<h2>Info</h2>
	<pre class="pre-scrollable">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ornare sit amet erat id convallis. In hac habitasse platea dictumst. Sed a mauris sodales, tincidunt sapien non, hendrerit enim. Suspendisse potenti. Phasellus ut dui scelerisque, ultrices ex sed, fringilla dui. Ut fermentum enim sit amet sapien tristique, quis convallis nibh dapibus. Cras accumsan massa a augue elementum facilisis. Aenean dictum mauris ut erat rutrum faucibus. Praesent ac sollicitudin eros.

Quisque rutrum egestas sem at luctus. Etiam quis magna mollis, hendrerit ex a, facilisis neque. Donec sit amet hendrerit erat. Morbi maximus egestas massa. In diam metus, molestie a blandit non, lobortis eu purus. Mauris id sapien sit amet nibh auctor luctus. Curabitur pretium mauris id ullamcorper blandit. Donec non interdum ligula. Cras sit amet magna dui.
	</pre>
</div>
<div class="form-horizontal col-xs-12 col-sm-8">
	<?php if($company_check->name == ""): ?>
	<div class="form-group">
		<h2>Profiil</h2>
	</div>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
		<div class="form-group">
			<label for="create_company"> Ettevõtte nimi </label>
			<input class="form-control input-sm" name="create_company" type="text" placeholder="Ettevõtte nimi" value="<?php echo $create_company; ?>"> <?php echo $create_company_error; ?>
		</div>
		<div class="form-group">
			<label for="create_email"> Ettevõtte email </label>
			<input class="form-control input-sm" name="create_email" type="email" placeholder="Ettevõtte email" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?>
		</div>
		<div class="form-group">
			<input class="btn btn-success btn-sm btn-block" type="submit" name="add_company" value="Sisesta">
		</div>
	</form>
	
	<?php else: ?>
	<div class="form-group">
		<h2>Profiil</h2>
	</div>
	<label for="job_company"> Ettevõtte nimi </label>
	<input name="job_company" class="form-control" type="text" value="<?=$company_check->name;?>" readonly><br>
	<label for="job_email"> Ettevõtte email </label>
	<input name="job_email" class="form-control" type="text" value="<?=$company_check->email;?>" readonly>
	<?php endif; ?>
</div>
</div>
<?php elseif($_SESSION['logged_in_user_group'] == 3): ?>
Admin profiil

<?php endif; ?>

<?php
	require_once("footer.php");
?>