<!DOCTYPE html>

<html lang="en">
  <head>
	<link rel="stylesheet" type="text/css" href="header.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eesti post</title>


    <!-- Bootstrap -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" >

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" >
<link rel="stylesheet" href="style.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<base target="_self">
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
		  <a class="navbar-brand" href="tiitelleht.html">Eesti post</a>
		  <a class='navbar-brand-logout' href='?logout=1'>Logi välja</a>		</div>
	</nav>
	<br><br><br>



  <div id="login" align="center">
  <h2">Logi sisse</h2>
    
  <form action="/~janekos/tunnitööd/veebiprogrameerimine/php-ruhmatoo-projekt/login.php" method="post" >
  	<input name="email" type="email" placeholder="E-post" value=""> <br><br>
  	<input name="password" type="password" placeholder="Parool" value=""> <br><br>
  	<input type="submit" name="login" value="Log in">
  </form>
  </div>
			<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
			<!-- Include all compiled plugins (below), or include individual files as needed -->
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" ></script>
		<footer>
			<p>Kontakt     E-post: name@gmail.com     Tel. number: +372 5348 7792</p>
		</footer>
	</body>
</html>