
<?php
	require_once("functions.php");
	require_once("../classes/Confirm.class.php");
	
	$Confirm = new Confirm($mysqli);
	//$array = getAllData();
	
	if(isset($_GET["edit"])) {
			
		$Confirm->saveNewEntry($_GET["edit"],$_SESSION['logged_in_user_id']);
		
		//$contest_array = $Confirm->getAllData($_GET["user_id"]);
		//var_dump($contest_array);
		
	}
	$contest_array = $Confirm->getAllData();
	
	if(isset($_GET["update"])){
		$Confirm->updateConfirmData($_GET["confirm_id"], $_GET["result"], $_GET["grade"], $_GET["run_comment"]);
		
		header("Location: confirm.php");
		exit();
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
            <li><a href="confirm.php">Tulemused ja kommentaarid</a></li>
			<li><a href="table.php">Osalejad</a></li>
			
			
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
	
	<br><br><br><br>
	<div class="container">
		<!-- <a href="data.php">Tagasi registreerimislehele!</a><br>
		// <a href="table.php">Tagasi tabeli juurde!</a><br> -->
		
		<br><br>
		<p>Siin saab kirja panna võistluste tulemused ja lisada kommentaare võistluse kohta.</p>


		<h1>Tulemused ja kommentaarid</h1>
		<form action="confirm.php" method="get">
			
		</form>
		<table border=1>

		<tr>
			
			<th>Osaleja nimi</th>
			<th>Võistlus</th>
			<th>Tulemus</th>
			<th>Hinda võistlust</th>
			<th>Kommentaarid</th>
		</tr>
	<div>
	
	
<?php
    //osalejad ükshaaval läbi käia
    for($i = 0; $i < count($contest_array); $i++){ //SIIN ON MIDAGI VALESTI? 
	//tabelis ainult esimesel viskab selle rea ette kinnituslehel
        //if($contest_array[$i]->user_id == aadressieal){
        //kasutaja tahab rida muuta
        if(isset($_GET["edit_confirm"]) && $_GET["edit_confirm"] == $contest_array[$i]->id){
            echo "<tr>";
            echo "<form action='confirm.php' method='get'>";
            
            echo "<td>".$contest_array[$i]->user."</td>";
            echo "<td>".$contest_array[$i]->contest_name."</td>";
			echo "<input type='hidden' name='confirm_id' value='".$contest_array[$i]->id."' type='text'>";
			echo "<td><input name='result' type='text' value='".$contest_array[$i]->result."'></td>";
			echo "<td><input name='grade' type='text' value='".$contest_array[$i]->grade."'></td>";
			echo "<td><input name='run_comment' type='text' value='".$contest_array[$i]->run_comment."'></td>";
            echo "<td><input name='update' type='submit'></td>";
            echo "</form>";
            echo "</tr>";
        }else{
            //lihtne vaade
            echo "<tr>";
            echo "<td>".$contest_array[$i]->user."</td>";
            echo "<td>".$contest_array[$i]->contest_name."</td>";
            echo "<td>".$contest_array[$i]->result."</td>";
			echo "<td>".$contest_array[$i]->grade."</td>";
            echo "<td>".$contest_array[$i]->run_comment."</td>";
            
			if($contest_array[$i]->user_id == $_SESSION['logged_in_user_id']){
            echo "<td><a href='?delete=".$contest_array[$i]->id."'>X</a></td>";
            echo "<td><a href='?edit_confirm=".$contest_array[$i]->id."'>Muuda</a></td>";
            }
            echo "</tr>";
            
        }
        
    }
    
?>

</table>