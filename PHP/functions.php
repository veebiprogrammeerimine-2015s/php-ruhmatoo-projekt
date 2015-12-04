<?php
require_once("../../configglobal.php");
$database = "if15_kaurkal";


<!--######################-->
<!--# MySQL info saamine #-->
<!--######################-->

//loome uue funktsiooni, et kysida andmebaasist andmeid (BarData)
function getBarData(){
	
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	$stmt=$mysqli->prepare("SELECT id, bar_name, number_plate, color FROM car_plates"); #MINGI INF, MIDA ANDMEBAASIST KÜSITAKSE
	$stmt->bind_result($id, $user_id, $number_plate, $color_from_Databeiss);
	$stmt->execute();
	
	//tyhi massiiv, kus hoiame objekte (1 rida andmeid)
	$array = array();

	
	
	//te tsyklit nii mitu korda, kuni saad andmebaasist ühe rea andmeid
	while($stmt->fetch()){
		//loon objekti iga while tsykli kord
		$car = new StdClass();
		$car->id1 = $id;
		$car->user_id1 = $user_id;
		$car->number_plate1 = $number_plate;
		$car->color1 = $color_from_Databeiss;

		
		array_push($array, $car);
		//echo "<pre>";
		//var_dump($array);
		//echo "</pre>";
		// var_dump annab infi, mis string/int jne on, echo "<pre>" jätab vormingu alles	
	}
	$stmt->close();
	$mysqli->close();
	return $array;
}

<!--##########################-->
<!--# MySQL info kustutamine #--> 	(vist pole meile seda vaja tglt)
<!--##########################-->

function deleteCar($id_to_be_deleted){
	$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("UPDATE car_plates SET deleted=NOW() WHERE id=?");
	$stmt->bind_param("i", $id_to_be_deleted);
	if($stmt->execute()){
		header("Location: table.php");
	}
	$stmt->close();
	$mysqli->close();
	
}

?>