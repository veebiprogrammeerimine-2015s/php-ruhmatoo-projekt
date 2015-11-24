<?php
	require_once("functions.php");
	$page_title = "Avaleht";
	$page_file_name = "index.php";
if(isset($_GET["logout"])){
        session_destroy();
        header("Location: index.php");
    }

?>

<?php require_once("header.php"); ?>
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
						<h1>Hello, world!</h1>
						<p>...</p>
						<p><a class="btn btn-success pull-right" href="#" role="button">Learn more</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php require_once("footer.php"); ?>
