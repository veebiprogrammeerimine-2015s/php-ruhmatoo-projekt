<html lang="en">
<?php	require_once("page/functions.php");	?>
<?php

$keyword = "";
$movie_category = "";
if(isset($_GET["logout"])){


	//session_destroy();

	header("Location: login.php");
}

if(isset($_GET["keyword"])){
	$keyword = $_GET["keyword"];
	//echo $keyword;
	$array_of_results = $user->getSearchData($keyword);
}

$movie_category = "";

?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Videolaenutus</title>

    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <!-- ################################################################################################################################ -->
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Videolaenutus</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="main.php">Avaleht <span class="sr-only"></span></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Videod <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="movies.php?=Cat_Action">Action</a></li>
            <li><a href="movies.php?=Cat_Komöödia">Komöödia</a></li>
            <li><a href="movies.php?=Cat_Seiklus">Seiklus</a></li>
            <li><a href="movies.php?=Cat_Draama">Draama</a></li>
            <li><a href="movies.php?=Cat_Animatsioon">Animatsioon</a></li>
            <li><a href="movies.php?=Cat_Biograafia">Biograafia</a></li>
			<li><a href="movies.php?=Cat_Krimi">Krimi</a></li>
			<li><a href="movies.php?=Cat_Fantaasia">Fantaasia</a></li>
			<li><a href="movies.php?=Cat_Ajalugu">Ajalugu</a></li>
			<li><a href="movies.php?=Cat_Thriller">Thriller</a></li>
			<li><a href="movies.php?=Cat_Ulme">Ulme</a></li>
			<li><a href="movies.php?=Cat_Sport">Sport</a></li>
			<li><a href="movies.php?=Cat_War">Sõda</a></li>
			<li><a href="movies.php?=Cat_Muusikal">Muusikal</a></li>
			<li><a href="movies.php?=Cat_Õudukad">Õudukad</a></li>
          </ul>
        </li>
      </ul>
	  <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Kasutaja nimi <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="settings.php">Seadmed</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="?logout=1">Logi välja</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-right" role="search" method="get">
        <div class="form-group">
          <input type="search" name="keyword" value="<?=$keyword;?>" class="form-control" placeholder="Otsi">
        </div>
        <button type="submit" class="btn btn-default">Otsi</button>
      </form>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<!-- ################################################################################################################################ -->

<!-- ################################################################################################################################ -->

<table border="1"></td>
	<tr>
		<!--<th>id</th>-->
		<th>Name</th>
		<th>Category</th>
		<th>Year</th>
		<th>Director</th>
	</tr>
	<?php
	if(isset($_GET["keyword"])){
		for($i = 0; $i < count($array_of_results); $i++){
				echo "<tr>";
				echo "<td>".$array_of_results[$i]->name."</td>";
				echo "<td>".$array_of_results[$i]->category."</td>";
				echo "<td>".$array_of_results[$i]->year."</td>";
				echo "<td>".$array_of_results[$i]->director."</td>";
				echo "</tr>";
		}
	}
	?>
</table>

