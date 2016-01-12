<?php

	require_once("../config_global.php");
	$database = "if15_raoulk";
	
	function getEditData($edit_id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT boot_brand, model FROM footyboots WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i",$edit_id);
		$stmt->bind_result($boot_brand, $model);
		$stmt->execute();
		
		$boot = new StdClass();
		
		//kas sain he rea andmeid kätte
		//stmt->fetch annab ühe rea andmeid
		if($stmt->fetch()){
			//sain
			$boot->boot_brand = $boot_brand;
			$boot->model = $model;
			
		}else{
			//ei saanud
			//id ei olnud olemas, id=1231231231
			//rida on kustutatud, deleted ei ole NULL
			header("Location:table.php");
		}
		
		return $boot;
		
	
		$stmt->close();
		$mysqli->close();
		
		
	}
	
	function updateBootData($id, $boot_brand, $model){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE footyboots SET boot_brand=?, model=? WHERE id=?");
		$stmt->bind_param("ssi", $boot_brand, $model, $id);
		if($stmt->execute()){
			// sai uuendatud
			// kustutame aadressirea tühjaks
			header("Location: table.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
	}
	
	function getBootData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, boot_brand, model from footyboots WHERE deleted IS NULL");
		echo $mysqli->error;
		$stmt->bind_result($id, $boot_brand, $model);
		$stmt->execute();
		//tekitan massiivi, kus edaspidi hoian objekte
		$boot_array = array();
		
		
		//tee midagi seni, kuni saame ab'ist ühe rea andmeid
		while($stmt->fetch()){
			// seda siin sees tehakse 
			// nii mitu korda kui on ridu
			
			//tekitan objecti, kus hakkan hoidma väärtusi
			$boot = new StdClass();
			$boot->id = $id;
			$boot->boot_brand = $boot_brand;
			$boot->model = $model;
			
			
			//lisan massiivi
			array_push($boot_array, $boot);
			//var dump ütleb muutjua tüübi ja sisu
			//echo "<pre>";
			//var_dump($car_array);
			//echo "</pre><br>";
		}
		
		//tagastan massiivi, kus kõik read sees
		return $boot_array;
		
		$stmt->close();
		$mysqli->close();
	}
	
	function deleteBoot($id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE footyboots SET deleted=NOW() WHERE id=?");
		
		$stmt->bind_param("i", $id);
		if($stmt->execute()){
			//sai kustutatud
			//kustutame aadresirea tühjaks
			header("Location: table.php");
		}
		
		$stmt->close();
		$mysqli->close();
	}
	

?>