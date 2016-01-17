<?php
	
	require_once("../configglobal.php");
	$database = "if15_kertkulp";
	
	function getSingleCarData($edit_id){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("SELECT model, make, color FROM add_car WHERE id=? AND deleted IS NULL");
		$stmt->bind_param("i", $edit_id);
		$stmt->bind_result($model, $make, $color);
		$stmt->execute();
		
		$car = new Stdclass();
		
		if($stmt->fetch()){
			
			$car->model = $model;
			$car->make = $make;
			$car->color = $color;
			
			
			
		}else{
			header("Location: cars.php");
		}
		
		return $car;
		
		$stmt->close();
		$mysqli->close();
	
	}
	
	require_once("../configglobal.php");
	$database = "if15_kertkulp";
	
	
	
	function updateCar($id, $model, $make, $color){
	
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("UPDATE add_car SET model=?, make=?, color=? WHERE id=?");
		$stmt->bind_param("sssi", $model, $make, $color, $id );
		
		
		if($stmt->execute()){
			echo "jee";
			
		}
		
		
		$stmt->close();
		$mysqli->close();
	}
	
	
?>