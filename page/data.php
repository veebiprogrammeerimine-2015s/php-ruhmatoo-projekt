<?php
    //kõik, mis on seotud andmetabelitega, lisamine ja tabeli kujul esitamine
    require_once("functions.php");
    
    //kui kasutaja on sisse logitud, suuna teisele lehele
    //kontrollin, kas sessiooni muutuja on olemas 
    if(!isset($_SESSION['logged_in_user_id'])){
        header("Location: login.php");
    }
    
    //aadressireale tekkis ?logout=1
    if(isset($_GET["logout"])){
        //kustutame sessiooni muutujad
        session_destroy();
        header("Location: login.php");
    }
    
    //muutuja väärtused
    $contest = $name = $m = "";
    $contest_error = $name_error = "";
    //echo $_SESSION['logged_in_user_id'];
    

     //valideeri väljad
        if($_SERVER["REQUEST_METHOD"] == "POST"){
        
            if(isset($_POST["add_competitor"])){
                
                if ( empty($_POST["contest"]) ) {
                    $contest_error = "Võistluse nimi on kohustuslik!";
                }else{
       
				$contest = cleanInput($_POST["contest"]);
			}
            if ( empty($_POST["name"]) ) {
                   $name_error = "Nimi/klubi on kohustuslik!";
                }else{
       
				$name = cleanInput($_POST["name"]);
			}
            
            //erroreid ei olnud, käivitan funktsiooni, mis sisaldab andmebaasi
            
            if($contest_error == "" && $name_error == ""){
                //m on message, mille saadame function.php failist
                $m = createContest($contest, $name);
                if($m != ""){
                    //teeme vormi tühjaks
                    $contest = "";
                    $name = "";
                }
            }
            
        }
    }
        
    function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
    }
    
    //küsime tabeli kujul andmed
    getAllData();
    
    
?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Registreerimine</title>

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
            <li><a href="table.php">Registreerimine</a></li>
            <li><a href="interests.php">Huvialad</a></li>
			<li><a href="table.php">Osalejad</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
	
	<br><br><br><br>

	<div class="container">
		Tere, <?=$_SESSION['logged_in_user_email'];?> <br><a href="?logout=1">Logi välja</a><br>
		
		<p>Siin on võimalik eelregistreerida võistlustele. Tuleb sisestada võistluse nimi ja enda nimi või klubi.</p>

		<h2>Eelregistreerimine võistlustele</h2>
		  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
			<label>Võistlus</label>
			<input id="contest" name="contest" type="text"  value="<?=$contest;?>"> <?=$contest_error; ?><br><br>
			<label>Nimi/klubi</label>
			<input id="name" name="name" type="" value="<?=$name; ?>"> <?=$name_error; ?><br><br>
			<input type="submit" name="add_competitor" value="Lisa">
			<p style="color:green;"><?=$m;?></p>
			
		  </form>
	</div>
  <?php
    //lehe nimi
    $page_title="Registreeri";
    
    //faili nimi
    $page_file_name="data.php";
?>
