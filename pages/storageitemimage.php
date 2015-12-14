<?php
/*
	So... if anything is broken yell at Jaan 
	Adding an image to an item, so that the shopping part would function normally
*/
	require_once(__DIR__."/../functions/functions.php");
	require_once(__DIR__."/../classes/item.class.php");
	$page_title = "Add image to item";
	$page_file_name = "storageitemimage.php";
	if(isset($_GET["logout"])){
        session_destroy();
        header("Location: /../index.php");
    }

?>

<?php require_once(__ROOT__."/header.php");?>

<?php

$setMerchandiseImage = new setMerchandiseImage($connection);
if(isset($_POST["select"])){
	$target_dir = (__ROOT__."/pildid/");
	$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}
	
	
	// Check if file already exists
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	
	
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
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
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
	if ($uploadOk ==1){
		$merchid = (int)$_POST["select"];
		$imagename = $_FILES["fileToUpload"]["name"];
		$response = $setMerchandiseImage->setMerchandiseImage($merchid, $imagename);
		
	}else{
		echo "SMTH IS BROKEN HERE";
	}
}

$getMerchandiseId = new getMerchandiseId($connection);
$imageAdd_array = $getMerchandiseId->getMerchandiseId();


?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-9">
		
			<table class="table table-hover">
				<tr>
					<th>Toote ID</th>
					<th>Tootenimi</th>
					<th>Tootepild</th>
				</tr>
				<?php 
				for($i = 0; $i < count($imageAdd_array); $i++){
					echo '<form action="/pages/storageitemimage.php" method="post" enctype="multipart/form-data">';
					echo "<tr> <td>".$imageAdd_array[$i]->id."</td> ";
					echo "<td>".$imageAdd_array[$i]->name."</td>"; 
					echo "<td>".$imageAdd_array[$i]->image."</td>";
					echo '<td><input type="file" name="fileToUpload" id="fileToUpload"></td>';
					echo '<input type="hidden" name="select" value="'.$imageAdd_array[$i]->id.'">';
					echo '<td><input class="btn btn-info btn-block" type="submit" name="submit"  value="Upload Image"></td></tr>';
					echo "</form>";
				}
				?>
			</table>
		
		</div>	
	</div>
</div>


<?php if(isset($response->success)):	 ?>
				
				<p><?=$response->success->message;?></p>
				
				<?php	elseif(isset($response->error)): ?>
				
				<p><?=$response->error->message;?></p>
				
				<?php	endif; ?>
<?php require_once(__ROOT__."/footer.php"); ?>
