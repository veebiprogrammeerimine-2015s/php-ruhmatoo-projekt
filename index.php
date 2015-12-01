<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/functions/functions.php");
	$page_title = "Avaleht";
	$page_file_name = "index.php";
	if(isset($_GET["logout"])){
        session_destroy();
        header("Location: index.php");
    }

?>

<?php require_once("header.php");?>
    <div class="container-fluid">
		<div class="row">
			<div class="col-sm-6 col-sm-push-6">
				<br>
				<br>
				<br>
				<ul class="nav nav-tabs">
					<li role="presentation" class="active"><a href="#home">Home</a></li>
					<li role="presentation"><a href="#profile">Profile</a></li>
					<li role="presentation"><a href="#messages">Messages</a></li>
				</ul>
			</div>
			<div class="col-sm-6 col-sm-pull-6">
				<br>
				<br>
				<br>
				<div class="jumbotron">
					<div class="container">
						<h1>Tere maailm!</h1>
						<div class="row">
							<div class="col-xs-12 col-sm-6">
							<p>Täname, et olete tulnud meie imelisele leheküljele kas soovite äkki sisse ka logida?</p>
							<p><a class="btn btn-success pull-left" href="/pages/login.php" role="button">Logi sisse</a></p>
							</div>
						
							<div class="col-xs-12 col-sm-6">
							<p>Või soovite te luua endale kasutaja</p>
							<p><a class="btn btn-success" href="/pages/create.php" role="button">Loo kasutaja</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?require_once (__ROOT__.'/smth.php');?>

<?php require_once("footer.php"); ?>
