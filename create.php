<?php
    require_once("functions.php");    
    //kui kasutaja on sisse logitud, suuna teisele lehele
    //kontrollin kas sessiooni muutuja olemas
    if(isset($_SESSION['logged_in_user_id'])){
        header("Location: data.php");
    }
	$page_title="Kasutaja loomine";
	$page_file_name="create.php";
	
	$errormessage = "";
	$create_email_error = "";
	$create_password_error = "";
	$create_email = "";
	$create_password = "";
    // *********************
    // ** LOO KASUTAJA *****
    // *********************
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["create"])){
		
			if ( empty($_POST["create_email"]) ) {
				$create_email_error = "See väli on kohustuslik";
			}else{
				$create_email = cleanInput($_POST["create_email"]);
			}
			
			if ( empty($_POST["create_password"]) ) {
				$create_password_error = "See väli on kohustuslik";
			} else {
				if(strlen($_POST["create_password"]) < 8) {
					$create_password_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}else{
					$create_password = cleanInput($_POST["create_password"]);
				}
			}
			
			if(	$create_email_error == "" && $create_password_error == ""){
				//echo hash("sha512", $create_password);
				//echo "Kasutaja loodud! Kasutajanimi on ".$create_email." ja parool on ".$create_password;
                
                // tekitan parooliräsi
                $hash = hash("sha512", $create_password);
                
                //functions.php's funktsioon
                createUser($create_email, $hash);
                
                
            }
        } 
}
	
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }

?>
<br><br>
<?php require_once ("header.php"); ?>

    <div class="container-fluid">
        <div class="row"  id="body">
            <div class="col-sm-offset-1 col-sm-6">
				<h1>Loo kasutaja</h1>

				  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
					<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
					<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?>	<br><br>
					<input type="submit" name="create" value="Create user">
				  </form>
					<?php if(isset($response->success)): ?>
					<p><?=$response->success->message?></p>
					  
					<?php elseif(isset($response->error)): ?>
					<p><?=$response->error->message?></p>
					  
					<?php endif; ?>
             </div>
        </div>
    </div> 

<?php require_once ("footer.php"); ?>