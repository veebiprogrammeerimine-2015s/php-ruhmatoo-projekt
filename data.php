<?php
   require_once("functions.php");
   if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: main.php");
		
	}
	//kasutaja tahab v�lja logida
	if(isset($_GET["logout"])){
		//addressireal on olemas muutuja logout
		//kustutame k�ik sessioonimuutujad
		session_destroy();
		header("Location: main.php");
	}
   $post="";
   $post_error= "";
   if($_SERVER["REQUEST_METHOD"] == "POST") {

   
		if(isset($_POST["add_post"])){

			if ( empty($_POST["post"])) {
				$post_error = "See v�li on kohustuslik";
			}else{
        
				$post = cleanInput($_POST["post"]);
			}

			
     
			if($post_error == "") {
				echo "Salvestatud!";
				$msg= createPost($post);
				
				if($msg !=""){
					//�nnestus, teeme inputi v�ljad t�hjaks
					$post="";
					
					
					echo $msg;
				}
				
			}
		}		
   
	   
	 
	   
	   
   }
   $target_dir = "profile_pics/";
	$target_file = $target_dir.$_SESSION["logged_in_user_id"].".jpg";
	if(isset($_POST["submit"])) {
	
	
	
	
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	if(isset($_POST["submit"])) {
		
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size - 500000 = ~500kB
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
				
				//see koht ab'i salvestamiseks
				
				header("Location: data.php");
				
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
		
	} // endif post submit
	
	
}

	if(isset($_GET["delete"])){
		
		unlink($target_file);
		
		header("Location: data.php");
	}
   function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
	
	
   
 ?> 
 <a href="poststable.php">Posituste vaatamine</a>

 <p>Tere, <?=$_SESSION["logged_in_user_id"];?>
	<a href="?logout=1"> Logi v�lja <a>
</p>

<h2>Lisa postitus </h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="post">Postitus</label><br>
  	<input id="post" name="post" type="text"  value="<?php echo $post; ?>"> <?php echo $post_error; ?><br><br>
	
  	<input type="submit" name="add_post" value="Salvesta">
  </form>
	<h2>Pildi lisamine</h2>

<?php if (file_exists($target_file)): ?>

<div style="
	width: 200px;
	height: 200px;
	background-image: url(<?=$target_file;?>);
	background-position: center center;
	background-size: cover;"></div>

	<a href="?delete=1">Kustuta pilt</a>
	
<?php else: ?>	
	
	
<form action="data.php" method="post" enctype="multipart/form-data">
    Lae �les pilt (1MB ja png, jpg, gif)
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

<?php endif; ?>

<?php

	$file_array=scandir($target_dir);
	var_dump($file_array);
	for($i= 0; $i < count($file_array); $i++){
		
		echo "<a href=''".$target_dir.$file_array[$i]."'>".$file_array[$i]."</a><br>";
		
	}
?>