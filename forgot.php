<?php
	$page_title = "Unustasid parooli?";
	$page_file = "forgot.php";
?>
<?php
	require_once("header.php"); 
	require_once ("functions.php");
	
	if(isset($_SESSION['logged_in_user_id'])) {
		header("Location: index.php");
		exit ();
	}
	
	$email = "";
	$email_error = "";
	$response = "";
	/*$link = time();
	$randstr = randStrGen(8);

	
	if( $_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["send"])){
			if (empty($_POST["email"])) {
				$email_error = "E-posti lahter ei tohi olla tühi!";
			} else {
				$email = cleanInput($_POST["email"]);
			}
			if($email_error == ""){
                $linkhash = hash("md5", $link);
				
				$newpage = fopen("recover/".$hash.".php", "w");
				$content = "Siia tuleb uue parooli input\n";
				fwrite($newpage, $content);
				$content = "Submit\n";
				fwrite($newpage, $content);
				fclose($newpage);
				
				
				
				$hash = hash("sha512", $randstr);
				
                $response = $User->forgotPassword($email, $linkhash);
            
            }
		}
	}*/
	
	
?>
<h3>Päring - uus pw ja hash + link - email pw - lingile vajutades muudab uue pw vana vastu ja suunab profiilile - kustutab lingi</h3>
<div class="row">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
 <div class="col-sm-4">
    <div class="input-group">
      <input type="email" name="email" class="form-control" placeholder="Email">
      <span class="input-group-btn">
        <input class="btn btn-success" type="submit" name="send" value="Saada">
      </span>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</form>
</div>

<?php require_once("footer.php"); ?>