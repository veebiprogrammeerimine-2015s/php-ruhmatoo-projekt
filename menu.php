<ul class="nav navbar-nav">
<?php if($page_file != "home.php") { ?>
<li><a href="home.php">Avaleht</a></li>
<?php } else { ?>
<li class="active"><a href="home.php">Avaleht</a></li>
<?php } ?>

<?php if($page_file != "jobs.php") { ?>
<li><a href="jobs.php">Tööpakkumised</a></li>
<?php } else { ?>
<li class="active"><a href="jobs.php">Tööpakkumised</a></li>
<?php } ?>

<?php if($page_file != "joblaw.php") { ?>
<li><a href="joblaw.php">Tööõigusseadused</a></li>
<?php } else { ?>
<li class="active"><a href="joblaw.php">Tööõigusseadused</a></li>
<?php } ?>

<?php if($page_file != "about.php") { ?>
<li><a href="about.php">Meist</a></li>
<?php } else { ?>
<li class="active"><a href="about.php">Meist</a></li>
<?php } ?>

<?php if($page_file != "contact.php") { ?>
<li><a href="contact.php">Kontakt</a></li>
<?php } else { ?>
<li class="active"><a href="contact.php">Kontakt</a></li>
<?php } ?>
</ul>
<?php
if(isset($_SESSION['logged_in_user_id'])):
if($_SESSION['logged_in_user_group'] == 3):
?>
<ul class="nav navbar-nav navbar-right">
	<li class="dropdown">
	  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
	  <ul class="dropdown-menu">
			<?php if($page_file != "data.php") { ?>
			<li><a href="data.php">Uus töökoht</a></li>
			<?php } else { ?>
			<li class="active"><a href="data.php">Uus töökoht</a></li>
			<?php } ?>

			<?php if($page_file != "insert.php") { ?>
			<li><a href="insert.php">Asukoha andmed</a></li>
			<?php } else { ?>
			<li class="active"><a href="insert.php">Asukoha andmed</a></li>
			<?php } ?>
	  </ul>
	</li>
</ul>
<?php 
endif;
endif;
?>