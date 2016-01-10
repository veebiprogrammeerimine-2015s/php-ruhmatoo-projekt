<?php

require_once("header.php");
require_once("functions.php");

if(isset($_SESSION['logged_in_user_id'])){
    header("Location: data.php");
}
	$email_error = "";
	$password_error = "";
	$email = "";
	$password = "";

	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
    // *********************
    // **** LOGI SISSE *****
    // *********************
		if(isset($_POST["login"])){
			
			if ( empty($_POST["email"]) ) {
				$email_error = "See väli on kohustuslik";
			}else{
				
        // puhastame muutuja võimalikest üleliigsetest sümbolitest
				$email = cleanInput($_POST["email"]);
			}
			if ( empty($_POST["password"]) ) {
				$password_error = "See väli on kohustuslik";
			}else{
				$password = cleanInput($_POST["password"]);
			}
			
		// Kui oleme siia jõudnud, võime kasutaja sisse logida
			if($password_error == "" && $email_error == ""){
				//echo "Võib sisse logida! Kasutajanimi on ".$email." ja parool on ".$password;
			
                $hash = hash("sha512", $password);
                
                loginUser($email, $hash);
            
            }
		} // login if end
        
    }
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
    <br><br>

	<!-- Sisu -->
    <div class="container-fluid">
        <div class="row"  id="body">
            <div class="col-sm-offset-1 col-sm-6">
                <h1>Tere tulemast Mikupea kodulehele!</h1>
            </div>
            <div class="col-sm-offset-1 col-sm-3">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
					<div class="form-group">
						<input name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" value="<?php echo $email; ?>"> <?php echo $email_error; ?>
					</div>
				  

					<div class="row">
					
						<div class="col-lg-8">
							<div class="form-group">
								<input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" value="<?php echo $password; ?>"> <?php echo $password_error; ?>
							</div>
						</div>
						
						<div class="col-lg-4 hidden-sm hidden-md">
							<button name="login" type="submit" class="btn btn-info btn-block">Logi sisse</button><br>
                            <button type="submit" class="btn btn-info">Loo</button>
						</div>
						
						<div class="col-lg-4 hidden-lg hidden-xs pull-right">
							<button type="submit" class="btn btn-info">Logi sisse</button>
						</div>
						
					</div>
				   
				</form>
            </div>
                    
        </div>
    </div>
	
<?php	require_once("footer.php"); ?>
