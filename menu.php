<?php require_once ("inc/functions.php"); ?>
<?php require_once("content/login.php"); ?>
<ul class="nav navbar-nav">
<?php if($page_file != "index.php") { ?>
<li><a href="<?=$myurl; ?>index.php">Avaleht</a></li>
<?php } else { ?>
<li class="active"><a href="<?=$myurl; ?>index.php">Avaleht</a></li>
<?php } ?>

<?php if($page_file != "jobs.php") { ?>
<li><a href="<?=$myurl; ?>content/jobs.php">Tööpakkumised</a></li>
<?php } else { ?>
<li class="active"><a href="<?=$myurl; ?>content/jobs.php">Tööpakkumised</a></li>
<?php } ?>

<?php if($page_file != "joblaw.php") { ?>
<li><a href="<?=$myurl; ?>content/joblaw.php">Tööõigusseadused</a></li>
<?php } else { ?>
<li class="active"><a href="<?=$myurl; ?>content/joblaw.php">Tööõigusseadused</a></li>
<?php } ?>

<?php if($page_file != "about.php") { ?>
<li><a href="<?=$myurl; ?>content/about.php">Meist</a></li>
<?php } else { ?>
<li class="active"><a href="<?=$myurl; ?>content/about.php">Meist</a></li>
<?php } ?>

<?php if($page_file != "contact.php") { ?>
<li><a href="<?=$myurl; ?>content/contact.php">Kontakt</a></li>
<?php } else { ?>
<li class="active"><a href="<?=$myurl; ?>content/contact.php">Kontakt</a></li>
<?php } ?>
</ul>

<?php
if(!isset($_SESSION['logged_in_user_id'])):
?>
<ul class="nav navbar-nav navbar-right">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sisene/Registreeru<span class="caret"></span></a>
			<ul class="dropdown-menu">

				<li><a style="cursor: pointer;" data-toggle="modal" data-target="#login_modal">Logi sisse</a></li>

				<?php if($page_file != "register.php") { ?>
				<li><a href="<?=$myurl; ?>content/register.php">Registreeru</a></li>
				<?php } else { ?>
				<li class="active"><a href="<?=$myurl; ?>content/register.php">Registreeru</a></li>
				<?php } ?>

			</ul>
	</li>
</ul>


<!-- Modal for login -->
<div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Logi sisse</h4>
      </div>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
      <div class="modal-body" style="height: 200px;">

				<div class="col-sm-12">

						<div class="form-group">
							<label for="email">Email</label>
							<input class="form-control input-sm" name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>">
						</div>

						<div class="form-group">
							<label for="password">Parool</label>
							<input class="form-control input-sm" name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>">
						</div>
				</div>
				<div class="col-sm-12">

						<div class="col-sm-6 checkbox" style="padding-left: 0px; margin-top: 0px;">
							<label>
								<input name="remember" type="checkbox"> Mäleta mind
							</label>
						</div>
						<div class="pull-right">
							<a href="<?=$myurl; ?>content/forgot.php">Unustasid parooli?</a>
						</div>

				</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Sulge</button>
        <input type="submit" name="login" value="Logi sisse" class="btn btn-primary btn-sm">
      </div>
			</form>
    </div>
  </div>
</div>


<?php
endif;
?>


<?php
if(isset($_SESSION['logged_in_user_id'])):
if($_SESSION['logged_in_user_group'] == 1):
?>
<ul class="nav navbar-nav navbar-right">
	<li class="dropdown">
	  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Kasutaja<span class="caret"></span></a>
	  <ul class="dropdown-menu">
			<li role="separator" class="divider"></li>
			<li class="dropdown-header">Konto</li>
			<li role="separator" class="divider"></li>

			<?php if($page_file != "profile.php") { ?>
			<li><a href="<?=$myurl; ?>content/profile.php">Profiil</a></li>
			<?php } else { ?>
			<li class="active"><a href="<?=$myurl; ?>content/profile.php">Profiil</a></li>
			<?php } ?>


			<li><a href="?logout=1">Logi välja</a></li>


	  </ul>
	</li>
</ul>
<?php
endif;
endif;
?>

<?php
if(isset($_SESSION['logged_in_user_id'])):
if($_SESSION['logged_in_user_group'] == 3):
?>
<ul class="nav navbar-nav navbar-right">
	<li class="dropdown">
	  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin<span class="caret"></span></a>
	  <ul class="dropdown-menu">
			<li role="separator" class="divider"></li>
			<li class="dropdown-header">Konto</li>
			<li role="separator" class="divider"></li>

			<li><a href="?logout=1">Logi välja</a></li>

	   <li role="separator" class="divider"></li>
	   <li class="dropdown-header">Töökohad</li>
	   <li role="separator" class="divider"></li>

			<?php if($page_file != "newjob.php") { ?>
			<li><a href="<?=$myurl; ?>content/newjob.php">Uus töökoht</a></li>
			<?php } else { ?>
			<li class="active"><a href="<?=$myurl; ?>content/newjob.php">Uus töökoht</a></li>
			<?php } ?>

			<?php if($page_file != "insert.php") { ?>
			<li><a href="<?=$myurl; ?>admin/insert.php">Asukoha andmed</a></li>
			<?php } else { ?>
			<li class="active"><a href="<?=$myurl; ?>admin/insert.php">Asukoha andmed</a></li>
			<?php } ?>

			<?php if($page_file != "editjobs.php") { ?>
			<li><a href="<?=$myurl; ?>admin/editjobs.php">Muuda töökohti</a></li>
			<?php } else { ?>
			<li class="active"><a href="<?=$myurl; ?>admin/editjobs.php">Muuda töökohti</a></li>
			<?php } ?>

		<li role="separator" class="divider"></li>
		<li class="dropdown-header">Kasutajad</li>
		<li role="separator" class="divider"></li>

			<?php if($page_file != "users.php") { ?>
			<li><a href="<?=$myurl; ?>admin/users.php">Kasutajad</a></li>
			<?php } else { ?>
			<li class="active"><a href="<?=$myurl; ?>admin/users.php">Kasutajad</a></li>
			<?php } ?>

			<?php if($page_file != "companies.php") { ?>
			<li><a href="<?=$myurl; ?>admin/companies.php">Ettevõtted</a></li>
			<?php } else { ?>
			<li class="active"><a href="<?=$myurl; ?>admin/companies.php">Ettevõtted</a></li>
			<?php } ?>
	  </ul>
	</li>
</ul>
<?php
endif;
endif;
?>
<?php
if(isset($_SESSION['logged_in_user_id'])):
if($_SESSION['logged_in_user_group'] == 2):
?>
<ul class="nav navbar-nav navbar-right">
	<li class="dropdown">
	  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tööpakkuja<span class="caret"></span></a>
	  <ul class="dropdown-menu">

			<li role="separator" class="divider"></li>
			<li class="dropdown-header">Konto</li>
			<li role="separator" class="divider"></li>

			<?php if($page_file != "profile.php") { ?>
			<li><a href="<?=$myurl; ?>content/profile.php">Profiil</a></li>
			<?php } else { ?>
			<li class="active"><a href="<?=$myurl; ?>content/profile.php">Profiil</a></li>
			<?php } ?>


			<li><a href="?logout=1">Logi välja</a></li>

			<li role="separator" class="divider"></li>
			<li class="dropdown-header">Haldamine</li>
			<li role="separator" class="divider"></li>

			<?php if($page_file != "newjob.php") { ?>
			<li><a href="<?=$myurl; ?>content/newjob.php">Uus töökoht</a></li>
			<?php } else { ?>
			<li class="active"><a href="<?=$myurl; ?>content/newjob.php">Uus töökoht</a></li>
			<?php } ?>

			<?php if($page_file != "myjobs.php") { ?>
			<li><a href="<?=$myurl; ?>content/myjobs.php">Minu tööpakkumised</a></li>
			<?php } else { ?>
			<li class="active"><a href="<?=$myurl; ?>content/myjobs.php">Minu tööpakkumised</a></li>
			<?php } ?>

			<?php if($page_file != "sentresumes.php") { ?>
			<li><a href="<?=$myurl; ?>content/sentresumes.php">Esitatud CVd</a></li>
			<?php } else { ?>
			<li class="active"><a href="<?=$myurl; ?>content/sentresumes.php">Esitatud CVd</a></li>
			<?php } ?>

	  </ul>
	</li>
</ul>
<?php
endif;
endif;
?>
