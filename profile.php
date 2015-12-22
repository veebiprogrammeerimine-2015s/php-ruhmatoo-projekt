<?php
	require_once("functions.php");
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
		exit();
	}
	
	$modify_fname = "";
	$modify_sname = "";
	$modify_country = "";
	$modify_profilepic = "";
	
	$target_dir = "profile_pics/";
	$target_file = $target_dir.$_SESSION["logged_in_user_id"].".jpg";
	
	if(isset($_POST["submit"])) {
	
	
	
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } 	else {
			echo "File is not an image.";
        $uploadOk = 0;
    }

	// Check if file already exists
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 1024000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			
			// see koht ab'i salvestamiseks
			
			header("Location: profile.php");
			
		} else {
			echo "Sorry, there was an error uploading your file.";
		}

	}
}
	// kustuta pilt
	
	if(isset($_GET["delete"])){
		
		unlink($target_file);
		
		header("Location: profile.php");
		
	}
	
	if(isset($_POST["modify"])){
				if ( empty($_POST["modify_fname"]) ) {
					echo "Test";
				}else{
					$modify_fname = cleanInput($_POST["modify_fname"]);
				}
				if ( empty($_POST["modify_sname"]) ) {
					echo "Test2";
				}else{
					$modify_sname = cleanInput($_POST["modify_sname"]);
				}
				if ( empty($_POST["modify_country"]) ) {
					echo "Test3";
				} else {
					$modify_country = cleanInput($_POST["modify_country"]);
					}
				}

				$create_response = $User->modifyUser($modify_fname, $modify_sname, $modify_country);
					
				
		
?>
<?php if(isset($_SESSION["login_success_message"])): ?>
	
	<p style="color:green;" >
		<?=$_SESSION["login_success_message"];?>
	</p>

<?php 
	//kustutan selle sõnumi pärast esimest näitamist
	unset($_SESSION["login_success_message"]);
	
	endif; ?>

<h2> Name </h2>
	<input name="first_name "placeholder="Firstname">
<h2> Surname </h2>
	<input name="surname "placeholder="Surname">
<h2> Country </h2>
	<input name="country "placeholder="Country">
	<br><br><br>
	<input type="submit" name="submit_modify" value="Submit">


	<h2>Profile picture</h2>

<?php if (file_exists($target_file)): ?>

<div style="
	width: 200px; 
	height: 200px; 
	background-image:url(<?=$target_file;?>); 
	background-position: center center; 
	background-size: cover;" ></div>

	<a href="?delete=1">Delete profile picture</a>

<?php else: ?>

<form action="profile.php" method="post" enctype="multipart/form-data">
    Upload picture (1MB ja png, jpg, gif):
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

<?php endif; ?>