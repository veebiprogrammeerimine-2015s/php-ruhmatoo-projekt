<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Avaleht</title>

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


<div class="container">
<?php
    //lehe nimi
    $page_title="Avaleht";
    
    //faili nimi
    $page_file_name="home.php";
?>

<br><br><br><br>

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
            <li><a href="home.php">Avaleht</a></li>
            <li><a href="login.php">Logi sisse</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
	
<p class="center">Uusaasta lubadus läks meelest? Pane end proovile ja registreeri võistlusele, sest pole halba ilma on valesti valitud riietus.</p>

<img class="img-responsive img-border img-center" src="dets2015.jpg" alt="">

</div>

		<div class="container">
			<footer class="text-center"> <!-- Jalus -->
				
				<p>Jooks24, 2015</p> 
			</footer>
		</div>
</html>
=======
<?php
    //lehe nimi
    $page_title="Avaleht";
    
    //faili nimi
    $page_file_name="home.php";
?>
<?php
    require_once("../header.php");
?>

<h2>Jooks24 on mõeldud kõikidele jooksusõpradele. See on abistav ja informeeriv sait, mis hõlmab kõikvõimalikke Eestis toimuvaid jooksuüritusi ning nendele registreerumist ja hiljem ka kogemuste kirjeldust!</h2>

<?php
    require_once("../footer.php");
?> 
>>>>>>> e517b961873c1cca8fe1fa834a06fea62c0d4896
