<?php require_once("functions.php") ?>
<?php require_once("header.php") ?>
<?php require_once("footer.php"); ?>
<?php if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if(isset($_POST["create_team"])){
            
     
            $GK = cleanInput($_POST["GK"]);
            $LB = cleanInput($_POST["LB"]);
            $CB1 = cleanInput($_POST["CB1"]);
            $CB2 = cleanInput($_POST["CB2"]);
            $RB = cleanInput($_POST["RB"]);
            $LM = cleanInput($_POST["LM"]);
            $CM1 = cleanInput($_POST["CM1"]);
            $CM2 = cleanInput($_POST["CM2"]);
            $RM = cleanInput($_POST["RM"]);
            $ST1 = cleanInput($_POST["ST1"]);
            $ST2 = cleanInput($_POST["ST2"]);
            
							}
    echo "Dreamteam edukalt lisatud!";
	
            createTeam($GK, $LB, $CB1, $CB2, $RB, $LM, $CM1, $CM2, $RM, $ST1, $ST2);
      
					
}


function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
   function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}







	?>

<html>

<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
<br>
				<br>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Dream team</h1>
            <div class="account-wall">
                <img class="profile-img" src="pildid/dreamteam"
                    alt="sveg">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"  class="form-signin">
                <input type="text" class="form-control" placeholder="Väravavaht" name="GK" required autofocus><br>
                <input type="text" class="form-control" placeholder="Vasakkaitse" name="LB" required autofocus><br>
				<input type="text" class="form-control" placeholder="Keskkaitsja 1" name="CB1" required autofocus><br>
                <input type="text" class="form-control" placeholder="Keskkaitsja 2" name="CB2" required autofocus><br>
                <input type="text" class="form-control" placeholder="Paremkaitse" name="RB" required autofocus><br>
                <input type="text" class="form-control" placeholder="Vasakäär" name="LM" required autofocus><br>
                  
                        <input type="text" class="form-control" placeholder="Keskkaitsja 1" name="CM1" required autofocus><br>
                        <input type="text" class="form-control" placeholder="Keskkaitsja 2" name="CM2" required autofocus><br>
                        <input type="text" class="form-control" placeholder="Paremäär" name="RM" required autofocus><br>
                        <input type="text" class="form-control" placeholder="Ründaja vasakäär" name="ST1" required autofocus><br>
                        <input type="text" class="form-control" placeholder="Ründaja paremäär" name="ST2" required autofocus><br>
                    
            
                <input class="btn btn-lg btn-primary btn-block" name="create_team" type="submit" value="Loo dreamteam">
				<br>
				<br>
				<br>
			
                
                
                </form>
            </div>
            
        </div>
    </div>
</div>
  </body>
  </html>