<?php require_once ("inc/functions.php"); ?>
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
if(isset($_SESSION['logged_in_user_id'])):
if($_SESSION['logged_in_user_group'] == 3):
?>
<ul class="nav navbar-nav navbar-right">
	<li class="dropdown">
	  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin<span class="caret"></span></a>
	  <ul class="dropdown-menu">
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
