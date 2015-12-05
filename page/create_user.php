<?php	

	require_once("functions.php");

	$user_group_error = "";
	$first_name_error = "";
	$last_name_error = "";
	$create_user_email_error = "";
	$create_user_password_error = "";
	$company_name_error = "";
	$company_description_error = "";
	
	$user_group = ""
	$first_name = "";
	$last_name = "";
	$create_user_email = "";
	$create_user_password = "";
	$company_name = "";
	$company_description = "";
	$user_confirmed = "";
	$user_created = "";
	$user_deleted = "";
	
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if(isset($_POST["create_user"])){

			if(empty($_POST["user_group"])) {
				$user_group_error = "Ei saa olla tühi";
			} else {
				$user_group = cleanInput($_POST["user_group"]);
			}
			
			if(empty($_POST["create_user_email"])) {
				$create_user_email_error = "Ei saa olla tühi";
			} else {
				$create_user_email = cleanInput($_POST["create_user_email"]);
			}
			
			if(empty($_POST["create_user_password"])) {
				$create_user_password_error = "Ei saa olla tühi";
			} elseif(strlen($_POST["create_user_password"]) < 8) {
					$create_user_password_error = "Peab olema vähemalt 8 sümbolit pikk";
			} else {
				$create_user_password = cleanInput($_POST["create_user_password"]);
			}
			
			if(empty($_POST["first_name"])) {
				$first_name_error = "Ei saa olla tühi";
			} else {
				$first_name = cleanInput($_POST["first_name"]);
			}
			
			if(empty($_POST["last_name"])) {
				$last_name_error = "Ei saa olla tühi";
			} else {
				$last_name = cleanInput($_POST["last_name"]);
			}
			
			if($_POST["user_group"] == "ettev6te") {
				
				if(empty($_POST["company_name"])) {
					$company_name_error = "Ei saa olla tühi";
				} else {
					$company_name = cleanInput($_POST["company_name"]);
				}
				
				if(empty($_POST["company_description"])) {
					$company_description_error = "Ei saa olla tühi";
				} else {
					$company_description = cleanInput($_POST["company_description"]);
				}
				
			}
			
			if($user_group_error = "" && $create_user_email_error == "" && $create_user_password_error == "" && $first_name_error == "" && $last_name_error == ""){
				echo hash("sha512", $create_user_password);
				echo $first_name." ".$last_name." võib kasutaja luua! Kasutajanimi on ".$create_user_email." ja parool on ".$create_user_password;
				
				$hash = hash("sha512", $create_user_password);
				
				$create_response = $User->createUser($create_user_email, $hash);
				
			}
		}
	}
	
	function cleanInput($data){
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
	}

?>
<?php
	
	$page_title = "Create User";
	$page_file = "create_user.php"
	
?>
<?php require_once("../header.php"); ?>
		<h2>Loo kasutaja</h2>
		
		<?php if(isset($create_response->error)):?>
			<p style="color:red;">
				<?=$create_response->error->message;?>
			</p>
		<?php elseif(isset($create_response->success)): ?>
			<p style="color:green;">
				<?=$create_response->success->message;?>
			</p>
		<?php endif; ?>
		
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<select id="user_group" name="user_group">
				<option value="">[ Kasutaja ]</option>
				<option value="ajakirjanik"<?=$user_group == "ajakirjanik" ? "selected='selected'" : ""?>>Ajakirjanik</option>
				<option value="ettev6te"<?=$user_group == "ettev6te" ? "selected='selected'" : ""?>>Ettevõte</option>
			</select>* <?=echo $user_group_error;?><br><br>
			<input name="create_user_email" type="email" placeholder="E-post" value="<?php echo $create_user_email; ?>">* <?php echo $create_user_email_error; ?> <br><br>
			<input name="create_user_password" type="password" placeholder="Parool">* <?php echo $create_user_password_error; ?> <br><br>	
			<input name="first_name" type="text" placeholder="Eesnimi" value="<?php echo $first_name; ?>">* <?php echo $first_name_error; ?> <br><br>
			<input name="last_name" type="text" placeholder="Perekonnanimi" value="<?php echo $last_name; ?>">* <?php echo $last_name_error; ?> <br><br>
			
			
			<input name="company_name" type="text" placeholder="Ettevõtte nimi" value="<?php echo $company_name; ?>">* <?php echo $company_name_error; ?> <br><br>
			<input name="company_description" type="text" placeholder="Ettevõtte kirjeldus" value="<?php echo $company_description; ?>">* <?php echo $company_description_error; ?> <br><br>
			
			
			<input name ="create_user" type="submit" value="Loo kasutaja">
		</form>
<?php require_once("../footer.php"); ?>