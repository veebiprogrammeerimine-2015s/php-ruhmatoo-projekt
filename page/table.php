
<?php 

    require_once("functions.php");
    require_once("../classes/Table.class.php");
    
    $Table = new Table($mysqli);
    
    if(!isset($_SESSION['logged_in_user_id'])){
        header("Location: login.php");
    }
    //kuulan, kas kasutaja tahab kustutada
    if(isset($_GET["delete"])){
        $Table->deleteContestData($_GET["delete"]);
    }

    
    //kasutaja muudab andmeid
    if(isset($_GET["update"])){
        $Table->updateContestData($_GET["contest_id"], $_GET["contest_name"], $_GET["name"]);
    }
    $contest_array = getAllData();
    
    $keyword = "";
	
    if(isset($_GET["keyword"])){
        $keyword = $_GET["keyword"];
        //otsime
        $contest_array = getAllData($keyword);
    }else{
        //näitame kõik tulemused
        $contest_array = getAllData();
    }
	
	if(isset($_GET["confirm"])){
        header("Location: confirm.php");
    }
?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Osalejad</title>

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
            <li><a href="confirm.php">Osalemise kinnitamine</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
	
	<br><br><br><br>

<!--<a href="data.php">Tagasi registreerimislehele!</a><br>
<a href="confirm.php">Kinnituslehele!</a><br> -->

<div class="container">

<br>
	<p>Siin ilmuvad tabeli kujul kõik eelregistreerunud.</p>
<br>
	<h1>Osalejad</h1>
	<form action="table.php" method="get">
		<input name="keyword" type="search" value="<?=$keyword?>">
		<input type="submit" value="Otsi"><br><br>
	</form>
	<table border=1>
	<tr>
		<th>id</th>
		<th>Kasutaja id</th>
		<th>Võistlus</th>
		<th>Osaleja nimi/klubi</th>
		<th>Kustuta</th>
		<th>Muuda</th>
		<th>Kinnita osalus</th>
	</tr>
</div>

<?php
    //osalejad ükshaaval läbi käia
    for($i = 0; $i < count($contest_array); $i++){
        
        //kasutaja tahab rida muuta
        if(isset($_GET["edit"]) && $_GET["edit"] == $contest_array[$i]->id){
            echo "<tr>";
            echo "<form action='table.php' method='get'>";
            // input mida välja ei näidata
            echo "<input type='hidden' name='contest_id' value='".$contest_array[$i]->id."'>";
            echo "<td>".$contest_array[$i]->id."</td>";
            echo "<td>".$contest_array[$i]->user_id."</td>";
            echo "<td><input name='contest_name' value='".$contest_array[$i]->contest_name."'></td>";
            echo "<td><input name='name' value='".$contest_array[$i]->name."'></td>";       
            echo "<td><a href='?table.php=".$contest_array[$i]->id."'>Katkesta</a></td>";
            echo "<td><input name='update' type='submit'></td>";
            echo "</form>";
            echo "</tr>";
        }else{
            //lihtne vaade
            echo "<tr>";
			
            echo "<td>".$contest_array[$i]->id."</td>";
            echo "<td>".$contest_array[$i]->user_id."</td>";
            echo "<td>".$contest_array[$i]->contest_name."</td>";
            echo "<td><a href='user.php?id=".$contest_array[$i]->user_id."'>".$contest_array[$i]->name."</a></td>";
			if($contest_array[$i]->user_id == $_SESSION['logged_in_user_id']){
				echo "<td><a href='?delete=".$contest_array[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$contest_array[$i]->id."'>Muuda</a></td>";
				
				echo "<td><a href='confirm.php?edit=".$contest_array[$i]->id."&user_id=".$contest_array[$i]->user_id."'>Kinnita</a></td>";
			}
            echo "</tr>";
            
        }
        
        
    }
    
?>

</table>

