<?php
	require_once("functions.php");
	require_once("OfferManager.class.php");
	require_once("header.php");
	
	$OfferManager = new OfferManager($mysqli, $_SESSION["logged_in_user_id"]);
	
		
	if($_SESSION["logged_in_user_group_id"] == "2"){
		header("Location: requests.php");
	}

	
	//$page_file_name="data.php";
	$text_type = $subject = $target_group = $description = $source = $length = $offer_deadline = $work_deadline = $output = $m = "";
	$text_type_error = $subject_error = $target_group_error = $description_error = $source_error = $length_error = $offer_deadline_error_1 = $offer_deadline_error_2 = $work_deadline_error_1 = $work_deadline_error_2 = $output_error = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		if(isSet($_POST["add_new_order"])){
			
			if(empty($_POST["text_type"])){
				$text_type_error = "Teksti tüüp on kohustuslik";
			}else{
				$text_type = cleanInput($_POST["text_type"]);
			}
			
			if(empty($_POST["subject"])){
				$subject_error = "Teema on kohustuslik";
			}else{
				$subject = cleanInput($_POST["subject"]);
			}
			
			if(empty($_POST["target_group"])){
				$target_group_error = "Sihtgrupp on kohustuslik";
			}else{
				$target_group = cleanInput($_POST["target_group"]);
			}
			
			if(empty($_POST["description"])){
				$description_error = "Kirjeldus on kohustuslik";
			}else{
				$description = cleanInput($_POST["description"]);
			}
			
			if(empty($_POST["source"])){
				$source_error = "Allikas on kohustuslik";
			}else{
				$source = cleanInput($_POST["source"]);
			}
			
			if(empty($_POST["length"])){
				$length_error = "Maht on kohustuslik";
			}else{
				$length = cleanInput($_POST["length"]);
			}
			
			if(empty($_POST["offer_deadline"])){
				$offer_deadline_error_1 = "Tähtaeg on kohustuslik";
			}else{
				if($_POST["offer_deadline"] < date("Y-m-d H:i:s")){
					$offer_deadline_error_2 = "Kuupäev peab olema tulevikus";
				}else{
					$offer_deadline = cleanInput($_POST["offer_deadline"]);
				}
			}
			
			if(empty($_POST["work_deadline"])){
				$work_deadline_error_1 = "Tähtaeg on kohustuslik";
			}else{
				if($_POST["work_deadline"] < date("Y-m-d H:i:s")){
					$work_deadline_error_2 = "Kuupäev peab olema tulevikus";
				}else{
					$work_deadline = cleanInput($_POST["work_deadline"]);
				}
			}
			
			if(empty($_POST["output"])){
				$output_error = "Ilmumiskoht on kohustuslik";
			}else{
				$output = cleanInput($_POST["output"]);
			}
			
			if ($text_type_error == "" && $subject_error == "" && $target_group_error == "" && $description_error == "" && $source_error == "" && $length_error == "" && $offer_deadline_error_1 == "" && $offer_deadline_error_2 == "" && $work_deadline_error_1 == "" && $work_deadline_error_2 == "" && $output_error == ""){
				$m = $OfferManager->createNewOrder($text_type, $subject, $target_group, $description, $source, $length, $offer_deadline, $work_deadline, $output);
				if($m != ""){
					$text_type = "";
					$subject = "";
					$description = "";
					$target_group = "";
					$source = ""; 
					$length = "";
					$offer_deadline = "";
					$work_deadline = "";
					$output = "";
				}
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

Kasutaja: <?=$_SESSION['logged_in_user_email'];?> <a href="?logout=1" style="text-decoration:none">[logi välja]</a>

<h2>Tellimuse esitamine</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<select id="text_type" name="text_type">
		<option value="">[ Teksti tüüp ]</option>
		<option value="uudislugu"<?=$text_type == "uudislugu" ? "selected='selected'" : ""?>>Uudislugu</option>
		<option value="pressiteade"<?=$text_type == "pressiteade" ? "selected='selected'" : ""?>>Pressiteade</option>
		<option value="reklaamtekst"<?=$text_type == "reklaamtekst" ? "selected='selected'" : ""?>>Reklaamtekst</option>
		<option value="blogipostitus"<?=$text_type == "blogipostitus" ? "selected='selected'" : ""?>>Blogipostitus</option>
		<option value="uudiskiri"<?=$text_type == "uudiskiri" ? "selected='selected'" : ""?>>Uudiskiri</option>
	</select>* <?=$text_type_error;?><br><br>
	<input id="subject" name="subject" type="text" placeholder="Teema" value="<?=$subject;?>">* <?=$subject_error;?><br><br>
	<textarea style="resize:none" id="description" name="description" rows="10" cols="28" placeholder="Kirjeldus"><?=$description;?></textarea>* <?=$description_error;?><br><br>
	<input id="target_group" name="target_group" type="text" placeholder="Sihtgrupp" value="<?=$target_group;?>">* <?=$target_group_error;?><br><br>
	<input id="source" name="source" type="text" placeholder="Allikas" value="<?=$source;?>">* <?=$source_error;?><br><br>
	<input id="length" name="length" type="number" placeholder="Maht (tähemärgid)" value="<?=$length;?>">* <?=$length_error;?><br><br>
	<input id="offer_deadline" name="offer_deadline" type="datetime" value="<?=$offer_deadline;?>">* <?=$offer_deadline_error_1;?><?=$offer_deadline_error_2;?><br><br>
	<input id="work_deadline" name="work_deadline" type="datetime" value="<?=$work_deadline;?>">* <?=$work_deadline_error_1;?><?=$work_deadline_error_2;?><br><br>
	<input id="output" name="output" type="text" placeholder="Ilmumiskoht" value="<?=$output;?>">* <?=$output_error;?><br><br>
	<input name="add_new_order" type="submit" value="Lisa uus tellimus">
	<p style="color:green;"><?=$m;?></p>
</form>

<a href="requests.php">Tellimuste tabel</a>