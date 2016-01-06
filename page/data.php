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

<?php 
    // lehe nimi
    $page_title = "Registreerimine";

?>

<?php
    require_once("../header.php");
?>

<br><br>

	<div class="container">
		<div class="row">
			<div class="box">
				<div class="col-lg-12">
		
					<hr>
                    <h2 class="intro-text text-center">Tere, <?=$_SESSION['logged_in_user_email'];?>!
                    </h2>
					<hr>
					<p class="text-center">Soovid ülevaadet oma võistlustest, siis pane võistlused kirja, et oleks hea hiljem kokkuvõtet teha.</p>
					

					  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
						<label>Võistlus</label>
						<input id="contest" name="contest" type="text"  value="<?=$contest;?>"> <?=$contest_error; ?><br><br>
						<label>Nimi/klubi</label>
						<input id="name" name="name" type="" value="<?=$name; ?>"> <?=$name_error; ?><br><br>
						<input type="submit" name="add_competitor" value="Lisa">
						<p style="color:green;"><?=$m;?></p>
					  </form>
					  
				</div>
			</div>
		</div>
	</div>

<?php require_once("../footer.php"); ?> 
