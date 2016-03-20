<?php

	$page_title = "Profiil";
	$page_file = "profile.php";

	require_once ("../inc/functions.php");
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
	$first = $last = $born = $county = $parish = $number = "";
	$first_error = $last_error = $born_error = $county_error = $parish_error = $number_error = "";
	$personal = $Profile->getPersonal($_SESSION['logged_in_user_id']);
	$my_resume = $Resume->getResumes($_SESSION['logged_in_user_id']);

	if(isset($_SESSION['logged_in_user_id'])) {
		if(isset($_GET['delete'])) {
			$Resume->deleteResume($_GET['delete'], $_SESSION['logged_in_user_id']);
		}
	}


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
				if (empty($_POST["born"]) ) {
					$born_error = "See väli on kohustuslik";
				} else{
					$born = cleanInput($_POST["born"]);
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
					$response_personal = $Profile->editPersonal($_SESSION['logged_in_user_id'], $first, $last, $born, $county, $parish, $number);
				} else {
					$response = new StdClass();
					$error = new StdClass();
					$error->id = 1;
					$error->message = "Palun täida kõik väljad!";
					$response->error = $error;
					$_SESSION['response'] = $response;
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
require_once("../header.php");
?>


<!--
########################
### SEARCHER PROFIIL ###
########################
-->

<?php if(isset($_SESSION['response']->success)): ?>

<div class="alert alert-success alert-dismissible fade in" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<p><?=$_SESSION['response']->success->message;?></p>
</div>

<?php elseif(isset($_SESSION['response']->error)): ?>

<div class="alert alert-danger alert-dismissible fade in" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<p><?=$_SESSION['response']->error->message;?></p>
</div>

<?php
	endif;
	unset($_SESSION['response']);
?>

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

	<div class="col-sm-3">
		<h3>Profiil</h3>
	  <ul class="nav nav-pills nav-stacked">
	    <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Konto</a></li>
	    <li role="presentation"><a href="#personal" class="active" aria-controls="personal" role="tab" data-toggle="tab">Isiklikud andmed</a></li>
	    <li role="presentation"><a href="#password" aria-controls="password" role="tab" data-toggle="tab">Muuda parooli</a></li>
	    <li role="presentation"><a href="#resumes" aria-controls="resumes" role="tab" data-toggle="tab">Minu CVd</a></li>
	  </ul>
	</div>

	<!-- Tab panes -->
	<div class="tab-content">

		<div role="tabpanel" class="tab-pane active" id="profile">


			<div class="form-horizontal col-xs-12 col-sm-9">

				<h3>Konto andmed</h3>

				<ul class="list-group">
					<li class="list-group-item"><label> Kasutajanimi: </label> <?=$_SESSION['logged_in_user_email'];?></li>
					<li class="list-group-item"><label> Konto loodud: </label> </li>
					<li class="list-group-item"><label> Viimane külastatus: </label> </li>
					<li class="list-group-item"><label> Viimane muudatus profiilis: </label> </li>
					<li class="list-group-item"><label> CVde arv: </label> <?=count($my_resume);?> </li>
				</ul>

			</div>
		</div>

		<div role="tabpanel" class="tab-pane" id="personal">

			<div class="form-horizontal col-xs-12 col-sm-9">

				<h3>
					Isiklikud andmed
					<a href="?personal#personal">
						<button type="button" class="btn btn-info btn-sm pull-right">
	  					<span class="glyphicon glyphicon-pencil"></span> Muuda
						</button>
					</a>
				</h3>
				<?php if(isset($_GET["personal"])): ?>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
						<ul class="list-group">

								<li id="firsts" class="list-group-item">
									<label> Eesnimi: </label>
									<input id="first" type="text" name="first" class="form-control input-sm" value="<?=$personal->first;?>">
								</li>
								<li id="lasts" class="list-group-item">
									<label> Perekonnanimi: </label>
									<input id="last" type="text" name="last" class="form-control input-sm" value="<?=$personal->last;?>">
								</li>
								<li id="borns" class="list-group-item">
									<label> Sünniaeg: </label>
									<input id="born" type="date" name="born" class="form-control input-sm" value="<?=$personal->born;?>">
								</li>
								<li id="countys" class="list-group-item">
									<label> Maakond: </label>
									<input id="county" type="text" name="county" class="form-control input-sm" value="<?=$personal->county;?>">
								</li>
								<li id="parishs" class="list-group-item">
									<label> Vald: </label>
									<input id="parish" type="text" name="parish" class="form-control input-sm" value="<?=$personal->parish;?>">
								</li>
								<li id="numbers" class="list-group-item">
									<label> Telefoni number: </label>
									<input id="number" type="text" name="number" class="form-control input-sm" value="<?=$personal->number;?>">
								</li>

						</ul>
						<div class="btn-group pull-right" role="group">

							<a href="profile.php#personal" class="btn btn-danger btn-sm">
								<span class="glyphicon glyphicon-remove"></span> Katkesta
							</a>

							<button type="submit" id="save_personal" name="save_personal" class="btn btn-success btn-sm">
								<span class="glyphicon glyphicon-ok"></span> Salvesta
							</button>

						</div>
				</form>
				<?php else: ?>
					<ul class="list-group">
						<li class="list-group-item"><label> Eesnimi: </label> <?=$personal->first;?></li>
						<li class="list-group-item"><label> Perekonnanimi: </label> <?=$personal->last;?></li>
						<li class="list-group-item"><label> Sünniaeg: </label> <?=$personal->born;?></li>
						<li class="list-group-item"><label> Maakond: </label> <?=$personal->county;?></li>
						<li class="list-group-item"><label> Vald: </label> <?=$personal->parish;?></li>
						<li class="list-group-item"><label> Telefoni number: </label> <?=$personal->number;?></li>
					</ul>
				<?php endif; ?>
			</div>
		</div>




		<div role="tabpanel" class="tab-pane" id="password">

			<div class="form-horizontal col-xs-12 col-sm-9">
					<h3>Muuda parooli</h3>
					<form class="form-horizontal col-xs-12" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
						<div class="form-group">
							<label for="oldpassword">Vana parool</label>
							<input type="password" class="form-control" name="oldpassword">
						</div>
						<div class="form-group">
							<label for="newpassword">Uus parool</label>
							<input type="password" class="form-control" id="newpassword" name="newpassword" data-toggle="tooltip" data-placement="left" title="Parool peab olema vähemalt 8 tähemärki pikk!">
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

			<div class="form-horizontal col-xs-12 col-sm-9">
				<h3>Minu CVd
					<a href="newresume.php">
					<button type="button" class="btn btn-info btn-sm pull-right" aria-label="Plus">
  					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Uus CV
					</button>
				</a>
				</h3>


							<div class="list-group">

								<?php
									for($i = 0; $i < count($my_resume); $i++) {
										echo '<div class="list-group-item">
												 <h4 class="list-group-item-heading">'.$my_resume[$i]->name.'
												 	<div class="btn-group pull-right">

														<a class="btn btn-info btn-sm" href="'.$myurl."edit/".$my_resume[$i]->link.'.php">
															<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Muuda
														</a>
														<a class="btn btn-danger btn-sm" onclick="confirmDelete('.$my_resume[$i]->id.')">
															<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Kustuta
														</a>

													 </div>
												</h4>';
										echo '<p class="list-group-item-text">'.$my_resume[$i]->inserted.'</p>';
										echo '</div>';
										}
								?>

							</div>

			</div>
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

<script>

	var hash = document.location.hash;
	var prefix = "";
	if (hash) {
	$('.nav-pills a[href='+hash.replace(prefix,"")+']').tab('show');
	}

	$('.nav-pills a').on('shown.bs.tab', function (e) {
	window.location.hash = e.target.hash.replace("#", "#" + prefix);
	});

	function passwordMatch() {
    var newpass = $("#newpassword").val();
    var repeatpass = $("#repeatpassword").val();

    if (newpass != repeatpass)
        document.getElementById("checking").className = "form-group has-error"
		else
				document.getElementById("checking").className = "form-group has-success"
	}

	function passwordLength() {
		var pass = $("#newpassword").val();

		if (pass.length < 8)
			$('#newpassword').tooltip('show');
		else
			$('#newpassword').tooltip('hide');
	}

	function isOkay() {
		var firsts = document.getElementById("first").value;
		var lasts = document.getElementById("last").value;
		var countys = document.getElementById("county").value;
		var parishs = document.getElementById("parish").value;
		var numbers = document.getElementById("number").value;

		if (firsts == 0 || lasts == 0 || countys == 0 || parishs == 0 || numbers == 0)
			document.getElementById("save_personal").className = "btn btn-success btn-sm disabled";
			if(firsts == 0)
				document.getElementById("firsts").className = "list-group-item has-error";
			if(lasts == 0)
				document.getElementById("lasts").className = "list-group-item has-error";
			if(countys == 0)
				document.getElementById("countys").className = "list-group-item has-error";
			if(parishs == 0)
				document.getElementById("parishs").className = "list-group-item has-error";
			if(numbers == 0)
				document.getElementById("numbers").className = "list-group-item has-error";
		else if (firsts != 0 && lasts != 0 && countys != 0 && parishs != 0 && numbers != 0)
			document.getElementById("save_personal").className = "btn btn-success btn-sm";
			if(firsts != 0)
				document.getElementById("firsts").className = "list-group-item has-success";
			if(lasts != 0)
				document.getElementById("lasts").className = "list-group-item has-success";
			if(countys != 0)
				document.getElementById("countys").className = "list-group-item has-success";
			if(parishs != 0)
				document.getElementById("parishs").className = "list-group-item has-success";
			if(numbers != 0)
				document.getElementById("numbers").className = "list-group-item has-success";
		}

		function confirmDelete(id) {

			var start = new Date().getTime();
			var confirmation = confirm("Kas oled kindel, et soovid kustutada?");
			var dt = new Date().getTime() - start;

			for(var i=0; i < 10 && !confirmation && dt < 50; i++){
					start = new Date().getTime();
					confirmation = confirm("Kas oled kindel, et soovid kustutada?");
					dt = new Date().getTime() - start;
			}
			if(dt < 50)
				 window.location = "?delete="+id;
			else if(dt > 150 && confirmation == true)
				window.location = "?delete="+id;
		};


	$(document).ready(function () {
	   $("#repeatpassword").keyup(passwordMatch);
		 $("#newpassword").keyup(passwordLength);
		 $("#first").ready(isOkay);
		 $("#first").keyup(isOkay);
		 $("#last").keyup(isOkay);
		 $("#county").keyup(isOkay);
		 $("#parish").keyup(isOkay);
		 $("#number").keyup(isOkay);
	});


</script>

<!--
PROFILE END
-->
<?php
	require_once("../footer.php");
?>
