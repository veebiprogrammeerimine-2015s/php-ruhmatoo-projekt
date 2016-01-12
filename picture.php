<?php 
require_once ("header.php"); 
require_once("functions.php");
$name = "";

$target_dir = "pic/";
	
	//faili nimi oleks kasutada id .jpg
	$target_file = $target_dir.$_POST['name'].".jpg";
	
	//kas kasutajal on pilt olemas?
	if (file_exists($target_file)){
		
		$profile_image_url=$target_file;
		
	}
	
	$uploadOk = 1;
	
	$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
	
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "Fail on pilt - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "Fail ei ole pilt.";
			$uploadOk = 0;
		}
	
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Vabandust! Fail on juba olemas.";
			$uploadOk = 0;
		}
		
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 1024000) {
			echo "Vabandust! Su fail on liiga suur.";
			$uploadOk = 0;
		}
		
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
			echo "Vabandust! Ainult JPG, JPEG, PNG & GIF failid on lubatud.";
			$uploadOk = 0;
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Vabandust! Sinu pilti ei laetud üles.";
			
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üles laetud.";
				header("Location: data.php");
				exit();
				
			} else {
				echo "Vabandust! Sinu faili laadimisel tekkis viga.";
			}
		}
	}

?>

<form action="picture.php" method="post" enctype="multipart/form-data">
    <h1>Vali kassile pilt</h1>
    <label> Nimi</label>
    <input type="text" name="name">
    <label>Vanus</label>
    <input type="int" name="age">
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
    
</form>

<?