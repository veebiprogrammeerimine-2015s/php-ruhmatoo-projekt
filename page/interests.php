<?php
    // kõik mis seotud andmetabeliga, lisamine ja tabeli kujul esitamine
    require_once("functions.php");
    require_once("../classes/InterestManager.class.php");
    
    
    if(!isset($_SESSION['logged_in_user_id'])){
        header("Location: login.php");
    }
 
    //****************
    //****HALDUS******
    //****************

    
    $InterestManager = new InterestManager($mysqli, $_SESSION['logged_in_user_id']);
    
    if(isset($_GET["new_interest"])){
        $add_interest_response = $InterestManager->addInterest($_GET["new_interest"]);
    }
    
    if(isset($_GET["dropdown_interest"])){
        $add_user_interest_response = $InterestManager->addUserInterest($_GET["dropdown_interest"]);
    }

?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Huvid</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Jooks24</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="data.php">Registreerimine</a></li>
            <li><a href="confirm.php">Tulemused ja kommentaarid</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
	
	<br><br><br><br>

	<div class="container">

		<br>
		Kui tegeled peale jooksmise veel millegagi, siis siin saab muud huvid kirja panna.
		<br>
		<h2>Lisa huviala</h2>
		<?php if(isset($add_interest_response->error)): ?>
		  
		  <p style="color:red"><?=$add_interest_response->error->message;?></p>
		<?php elseif(isset($add_interest_response->success)): ?>

		<p style="color:green;">
			<?=$add_interest_response->success->message;?>
		</p>
		  <?php endif; ?>
		<form>
			<input name="new_interest"> <br><br>
			<input type="submit" value="Lisa">
		</form>

		<h2>Minu huvialad</h2>
		<?php if(isset($add_user_interest_response->error)): ?>
		  
		  <p style="color:red"><?=$add_user_interest_response->error->message;?></p>
		<?php elseif(isset($add_user_interest_response->success)): ?>

		<p style="color:green;">
			<?=$add_user_interest_response->success->message;?>
		</p>
		  <?php endif; ?>
			<form>
			<?=$InterestManager->createDropdown();?>
			<input type="submit" value="Lisa">
		</form>

		<h2>Loetelu</h2>
		<?=$InterestManager->getUserInterests();?>
	</div>

   
