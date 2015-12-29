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
	##########################
	### SEARCHER VARIABLES ###
	##########################
	$oldpassword_error = $newpassword_error = $repeatpassword_error = "";
	$oldpassword = $newpassword = $repeatpassword = "";
	$first = $last = $county = $parish = $number = "";
	$first_error = $last_error = $county_error = $parish_error = $number_error = "";
	$personal = $Profile->getPersonal($_SESSION['logged_in_user_id']);

	if(isset($_SESSION['logged_in_user_id'])) {
		if( $_SERVER["REQUEST_METHOD"] == "POST") {

			if(isset($_POST["save_personal"])){

				if (empty($_POST["first"]) ) {
					$first_error = "See väli on kohustuslik";
				} else{
					$first = cleanInput($_POST["first"]);
				}
				if (empty($_POST["last"]) ) {
					$last_error = "See väli on kohustuslik";
				} else{
					$last = cleanInput($_POST["last"]);
				}
				if (empty($_POST["county"]) ) {
					$county_error = "See väli on kohustuslik";
				} else{
					$county = cleanInput($_POST["county"]);
				}
				if (empty($_POST["parish"]) ) {
					$parish_error = "See väli on kohustuslik";
				} else{
					$parish = cleanInput($_POST["parish"]);
				}
				if (empty($_POST["number"]) ) {
					$number_error = "See väli on kohustuslik";
				} else{
					$number = cleanInput($_POST["number"]);
				}
				if($first_error == "" && $last_error == "" && $county_error == "" && $parish_error == "" && $number_error == ""){
					$response_personal = $Profile->editPersonal($_SESSION['logged_in_user_id'], $first, $last, $county, $parish, $number);
				}

			}

			if(isset($_POST["change_password"])){

				if (empty($_POST["oldpassword"]) ) {
					$oldpassword_error = "See väli on kohustuslik";
				} else{
					$oldpassword = cleanInput($_POST["oldpassword"]);
				}

				if (empty($_POST["newpassword"]) ) {
					$newpassword_error = "See väli on kohustuslik";
				} else {
					if(strlen($_POST["newpassword"]) < 8) {
						$checklength = "Uus parool peab olema vähemalt 8 tähemärki pikk!";
					} else {
					$newpassword = cleanInput($_POST["newpassword"]);
				}
			}

				if (empty($_POST["repeatpassword"]) ) {
					$repeatpassword_error = "See väli on kohustuslik";
				} else {
					$repeatpassword = cleanInput($_POST["repeatpassword"]);
				}

				if($oldpassword_error == "" && $newpassword_error == "" && $repeatpassword_error == ""){
					$oldhash = hash("sha512", $oldpassword);
					$checkresponse = $User->checkPassword($_SESSION['logged_in_user_id'], $oldhash);
					if(isset($checkresponse->success)) {
						if($newpassword != $repeatpassword){
							$checkresponse = "Paroolid ei klappinud omavahel!";
						} else {
							$newhash = hash("sha512", $newpassword);
							$passresponse = $User->changePassword($_SESSION['logged_in_user_id'], $newhash);
						}
					}
				}

			}
		}
	}



	##########################
	### EMPLOYER VARIABLES ###
	##########################
	$create_company = $create_email = $create_number = "";
	$create_company_error = $create_email_error = $create_number_error = "";
	$job_company_error = $job_email_error = $job_number_error = "";
	$job_company = $job_email = $job_number = "";
	$job_company_error1 = $job_email_error1 = $job_number_error1 = "";
	$job_company1 = $job_email1 = $job_number1 = "";
	$response = "";
	$company_check = $Profile->companyCheck($_SESSION['logged_in_user_id']);

	if(isset($_SESSION['logged_in_user_id'])) {
		if($_SESSION['logged_in_user_group'] != 1) {
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
					if (empty($_POST["create_number"]) ) {
						$create_number_error = "See väli on kohustuslik";
					}else{
						$create_number = cleanInput($_POST["create_number"]);
					}
					if($create_company_error == "" && $create_email_error == "" && $create_number_error == ""){
						$response = $Profile->createCompany($create_company, $create_email, $create_number);
					}
				}
			}
			$old_name = $company_check->name;
			if( $_SERVER["REQUEST_METHOD"] == "POST") {
					if(isset($_POST["edit_employer"])) {
					if (empty($_POST["job_company1"])) {
						$job_company_error1 = "See väli on kohustuslik!";
					} else {
						$job_company1 = cleaninput($_POST["job_company1"]);
					}

					if (empty($_POST["job_email1"])) {
						$job_email_error1 = "See väli on kohustuslik!";
					} else {
						$job_email1 = cleaninput($_POST["job_email1"]);
					}

					if (empty($_POST["job_number1"])) {
						$job_number_error1 = "See väli on kohustuslik!";
					} else {
						$job_number1 = cleaninput($_POST["job_number1"]);
					}

					if ($job_company_error1 == "" && $job_email_error1 == "" && $job_number_error1 == "") {
						$response = $Profile->editCompany($job_company1, $job_email1, $job_number1, $old_name);
					}

			}
		}
	}
}
?>

<script>
function passwordMatch() {
    var newpass = $("#newpassword").val();
    var repeatpass = $("#repeatpassword").val();

    if (newpass != repeatpass)
        document.getElementById("checking").className = "form-group has-error"
		else
				document.getElementById("checking").className = "form-group has-success"
}
function isOkay() {
var firsts = document.getElementById("first").value;
var lasts = document.getElementById("last").value;
var countys = document.getElementById("county").value;
var parishs = document.getElementById("parish").value;
var numbers = document.getElementById("number").value;
	if (firsts == 0 || lasts == 0 || countys == 0 || parishs == 0 || numbers == 0)
		document.getElementById("save_personal").className = "btn btn-success btn-sm disabled";
	else
		document.getElementById("save_personal").className = "btn btn-success btn-sm";
}

$(document).ready(isOkay);

$(document).ready(function () {
   $("#repeatpassword").keyup(passwordMatch);
	 $("#first").keyup(isOkay);
	 $("#last").keyup(isOkay);
	 $("#county").keyup(isOkay);
	 $("#parish").keyup(isOkay);
	 $("#number").keyup(isOkay);
});


</script>

<!--
########################
### SEARCHER PROFIIL ###
########################
-->
<?php if($_SESSION['logged_in_user_group'] == 1):?>
<div class="row">

	<?php if(isset($passresponse->success)): ?>

		<div class="alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<p><?=$passresponse->success->message;?></p>
		</div>

	<?php elseif(isset($passresponse->error)): ?>

		<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<p><?=$passresponse->error->message;?></p>
		</div>

	<?php elseif(isset($response_personal->success)): ?>

		<div class="alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<p><?=$response_personal->success->message;?></p>
		</div>

	<?php elseif(isset($response_personal->error)): ?>

		<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<p><?=$response_personal->error->message;?></p>
		</div>

	<?php elseif(isset($checkresponse->error)): ?>

		<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<p><?=$checkresponse->error->message;?></p>
		</div>

	<?php elseif(!empty($checklength)): ?>

		<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<p><?=$checklength;?></p>
		</div>

	<?php elseif(!empty($checkresponse)): ?>

		<div class="alert alert-danger alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
			<p><?=$checkresponse;?></p>
		</div>

	<?php endif; ?>

	<div class="col-xs-12">
	<div class="col-xs-12 col-sm-2">
	<h2>Profiil</h2>
	</div>
	<div class="col-xs-12 col-sm-10">
	<ul class="nav nav-tabs pull-right" role="tablist">
	<?php if(isset($_GET["personal"])): ?>
	<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Konto andmed</a></li>
	<li role="presentation" class="active"><a href="#personal" aria-controls="personal" role="tab" data-toggle="tab">Isiklikud andmed</a></li>
	<?php else: ?>
	<li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Konto andmed</a></li>
	<li role="presentation"><a href="#personal" aria-controls="personal" role="tab" data-toggle="tab">Isiklikud andmed</a></li>
	<?php endif; ?>
	<li role="presentation"><a href="#password" aria-controls="password" role="tab" data-toggle="tab">Muuda parooli</a></li>
	<li role="presentation"><a href="#resumes" aria-controls="resumes" role="tab" data-toggle="tab">Konto CVd</a></li>
	</ul>
</div>
</div>
	<div class="col-xs-12">
	<!-- Tab panes -->
	<div class="tab-content">

		<?php if(isset($_GET["personal"])): ?>
		<div role="tabpanel" class="tab-pane" id="profile">
		<?php else: ?>
		<div role="tabpanel" class="tab-pane active" id="profile">
		<?php endif; ?>
			<div class="col-xs-12 col-sm-4">
				<h3>Info</h3>
				<pre class="pre-scrollable">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ornare sit amet erat id convallis. In hac habitasse platea dictumst. Sed a mauris sodales, tincidunt sapien non, hendrerit enim. Suspendisse potenti. Phasellus ut dui scelerisque, ultrices ex sed, fringilla dui. Ut fermentum enim sit amet sapien tristique, quis convallis nibh dapibus. Cras accumsan massa a augue elementum facilisis. Aenean dictum mauris ut erat rutrum faucibus. Praesent ac sollicitudin eros.

Quisque rutrum egestas sem at luctus. Etiam quis magna mollis, hendrerit ex a, facilisis neque. Donec sit amet hendrerit erat. Morbi maximus egestas massa. In diam metus, molestie a blandit non, lobortis eu purus. Mauris id sapien sit amet nibh auctor luctus. Curabitur pretium mauris id ullamcorper blandit. Donec non interdum ligula. Cras sit amet magna dui.
				</pre>
			</div>

			<div class="form-horizontal col-xs-12 col-sm-8">

				<h3>Konto andmed</h3>

				<table class="table table-striped table-bordered">
					<tr>
						<td><label> Kasutajanimi </label></td>
						<td><?=$_SESSION['logged_in_user_email'];?></td>
					</tr>
					<tr>
						<td><label> Konto loodud </label></td>
						<td><?=date('d.m.Y');?></td>
					</tr>
					<tr>
						<td><label> Viimane külastatus </label></td>
						<td><?="Puudub";?></td>
					</tr>
					<tr>
						<td><label> Viimane muudatus profiilis </label></td>
						<td><?="Puudub";?></td>
					</tr>
					<tr>
						<td><label> CVde arv </label></td>
						<td><?="Puudub";?></td>
					</tr>
				</table>

			</div>
		</div>

		<?php if(isset($_GET["personal"])): ?>
			<div role="tabpanel" class="tab-pane active" id="personal">
		<?php else: ?>
		<div role="tabpanel" class="tab-pane" id="personal">
		<?php endif; ?>
			<div class="col-xs-12 col-sm-4">
				<h3>Info</h3>
				<pre class="pre-scrollable">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ornare sit amet erat id convallis. In hac habitasse platea dictumst. Sed a mauris sodales, tincidunt sapien non, hendrerit enim. Suspendisse potenti. Phasellus ut dui scelerisque, ultrices ex sed, fringilla dui. Ut fermentum enim sit amet sapien tristique, quis convallis nibh dapibus. Cras accumsan massa a augue elementum facilisis. Aenean dictum mauris ut erat rutrum faucibus. Praesent ac sollicitudin eros.

Quisque rutrum egestas sem at luctus. Etiam quis magna mollis, hendrerit ex a, facilisis neque. Donec sit amet hendrerit erat. Morbi maximus egestas massa. In diam metus, molestie a blandit non, lobortis eu purus. Mauris id sapien sit amet nibh auctor luctus. Curabitur pretium mauris id ullamcorper blandit. Donec non interdum ligula. Cras sit amet magna dui.
				</pre>
			</div>

			<div class="form-horizontal col-xs-12 col-sm-8">

				<h3>
					Isiklikud andmed
					<a href="?personal">
						<button type="button" class="btn btn-info btn-sm pull-right">
	  					<span class="glyphicon glyphicon-pencil"></span> Muuda
						</button>
					</a>
				</h3>
				<?php if(isset($_GET["personal"])): ?>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
						<table class="table table-striped table-bordered">

							<tr>
								<td><label> Eesnimi </label></td>
								<td><input id="first" type="text" name="first" class="form-control input-sm" value="<?=$first;?>"></td>
							</tr>
							<tr>
								<td><label> Perekonnanimi </label></td>
								<td><input id="last" type="text" name="last" class="form-control input-sm" value="<?=$last;?>"></td>
							</tr>
							<tr>
								<td><label> Maakond </label></td>
								<td><input id="county" type="text" name="county" class="form-control input-sm" value="<?=$county;?>"></td>
							</tr>
							<tr>
								<td><label> Vald </label></td>
								<td><input id="parish" type="text" name="parish" class="form-control input-sm" value="<?=$parish;?>"></td>
							</tr>
							<tr>
								<td><label> Telefoni number </label></td>
								<td><input id="number" type="text" name="number" class="form-control input-sm" value="<?=$number;?>"></td>
							</tr>
						</table>
						<div class="btn-group pull-right" role="group">

							<a href="profile.php" class="btn btn-danger btn-sm">
								<span class="glyphicon glyphicon-remove"></span> Katkesta
							</a>

							<button type="submit" id="save_personal" name="save_personal" class="btn btn-success btn-sm">
								<span class="glyphicon glyphicon-ok"></span> Salvesta
							</button>

						</div>
				</form>
				<?php else: ?>
				<table class="table table-striped table-bordered">
					<tr>
						<td><label> Eesnimi </label></td>
						<td><?=$personal->first;?></td>
					</tr>
					<tr>
						<td><label> Perekonnanimi </label></td>
						<td><?=$personal->last;?></td>
					</tr>
					<tr>
						<td><label> Maakond </label></td>
						<td><?=$personal->county;?></td>
					</tr>
					<tr>
						<td><label> Vald </label></td>
						<td><?=$personal->parish;?></td>
					</tr>
					<tr>
						<td><label> Telefoni number </label></td>
						<td><?=$personal->number;?></td>
					</tr>
				</table>
				<?php endif; ?>
			</div>
		</div>




		<div role="tabpanel" class="tab-pane" id="password">
			<div class="col-xs-12 col-sm-4">
				<h3>Info</h3>
				<pre class="pre">
Juhul kui soovid parooli vahetada, siis täida antud vorm ära ja parool saab edukalt muudetud
				</pre>
			</div>


			<div class="form-horizontal col-xs-12 col-sm-8">
					<h3>Muuda parooli</h3>
					<form class="form-horizontal col-xs-12" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
						<div class="form-group">
							<label for="oldpassword">Parool</label>
							<input type="password" class="form-control" name="oldpassword">
						</div>
						<div class="form-group">
							<label for="newpassword">Uus Parool</label>
							<input type="password" class="form-control" id="newpassword" name="newpassword">
						</div>
					  <div id="checking" class="form-group">
					    <label for="repeatpassword">Korda uut parooli</label>
					    <input type="password" class="form-control" id="repeatpassword" name="repeatpassword">
					  </div>
						<div class="form-group pull-right">
							<input class="btn btn-success btn-sm" type="submit" name="change_password" value="Muuda parooli">
						</div>
					</form>
			</div>

		</div>

		<div role="tabpanel" class="tab-pane" id="resumes">
			<div class="col-xs-12 col-sm-4">
				<h3>Info</h3>
				<pre class="pre-scrollable">
CVDE KIRJELDUS TULEB KA SIIA ipsum dolor sit amet, consectetur adipiscing elit. Integer ornare sit amet erat id convallis. In hac habitasse platea dictumst. Sed a mauris sodales, tincidunt sapien non, hendrerit enim. Suspendisse potenti. Phasellus ut dui scelerisque, ultrices ex sed, fringilla dui. Ut fermentum enim sit amet sapien tristique, quis convallis nibh dapibus. Cras accumsan massa a augue elementum facilisis. Aenean dictum mauris ut erat rutrum faucibus. Praesent ac sollicitudin eros.

Quisque rutrum egestas sem at luctus. Etiam quis magna mollis, hendrerit ex a, facilisis neque. Donec sit amet hendrerit erat. Morbi maximus egestas massa. In diam metus, molestie a blandit non, lobortis eu purus. Mauris id sapien sit amet nibh auctor luctus. Curabitur pretium mauris id ullamcorper blandit. Donec non interdum ligula. Cras sit amet magna dui.
				</pre>
			</div>

			<div class="form-horizontal col-xs-12 col-sm-8">
				<h3>Minu CVd
					<a href="newresume.php">
					<button type="button" class="btn btn-info btn-sm pull-right" aria-label="Plus">
  					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Uus CV
					</button>
				</a>
				</h3>
				if stmt not fetch
				Pole ühtegi CVd
				<br>
				if fetch
				for loop
			</div>
		</div>

		</div>
	</div>
</div>
<!--
########################
### EMPLOYER PROFILE ###
########################
-->
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
	<?php if($company_check->name == "" OR $company_check->email == "" OR $company_check->number == ""): ?>
	<h2>Profiil</h2>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
		<div class="form-group">
			<label for="create_company"> Ettevõtte nimi </label>
			<input class="form-control input-sm" name="create_company" type="text" placeholder="Ettevõtte nimi" value="<?php echo $create_company; ?>"> <?php echo $create_company_error; ?>
		</div>
		<div class="form-group">
			<label for="create_email"> Kontakt email </label>
			<input class="form-control input-sm" name="create_email" type="email" placeholder="Kontakt email" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?>
		</div>
		<div class="form-group">
			<label for="create_number"> Kontakt number </label>
			<input class="form-control input-sm" name="create_number" type="text" placeholder="Kontakt number" value="<?php echo $create_number; ?>"> <?php echo $create_number_error; ?>
		</div>
		<div class="form-group">
			<input class="btn btn-success btn-sm btn-block" type="submit" name="add_company" value="Sisesta">
		</div>
	</form>
	<?php elseif(isset($_GET["employeredit"])): ?>
	<h2>Profiil</h2>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	<label for="job_company1"> Ettevõtte nimi </label>
	<input name="job_company1" class="form-control" type="text" value="<?=$company_check->name;?>">
	<label for="job_email1"> Kontakt </label>
	<input name="job_email1" class="form-control" type="text" value="<?=$company_check->email;?>">
	<label for="job_number1"> Kontakt email </label>
	<input name="job_number1" class="form-control" type="text" value="<?=$company_check->number;?>">
	<br>
		<div class="form-group">
			<input class="btn btn-success btn-sm btn-block" type="submit" name="edit_employer" value="Salvesta">
		</div>

	</form>
	<?php elseif(!isset($_GET["employeredit"])): ?>
	<h2>Profiil</h2>
	<label for="job_company"> Ettevõtte nimi </label>
	<input name="job_company" class="form-control" type="text" value="<?=$company_check->name;?>" readonly>
	<label for="job_email"> Kontakt </label>
	<input name="job_email" class="form-control" type="text" value="<?=$company_check->email;?>" readonly>
	<label for="job_number"> Kontakt email </label>
	<input name="job_number" class="form-control" type="text" value="<?=$company_check->number;?>" readonly>
	<br>
	<a href="?employeredit">
	<button type="button" class="pull-right btn btn-info">
		<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Muuda
	</button>
	</a>
	<?php endif; ?>
</div>
</div>
<!--
#####################
### ADMIN PROFILE ###
#####################
-->
<?php elseif($_SESSION['logged_in_user_group'] == 3): ?>
Admin profiil

<?php endif; ?>
<!--
PROFILE END
-->
<?php
	require_once("footer.php");
?>
