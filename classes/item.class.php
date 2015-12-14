<?php 
require_once(__DIR__.'/../functions/functions.php');

class getMerchandiseid{
	/* 	
		Item name, imageid, and item id from database,
		To read items names from db so that there can be a image add button
	*/
	private $connection;
	
	function __construct($connection){
        $this->connection = $connection;
	}
	function getMerchandiseId(){
		
		
		$stmt = $this->connection->prepare("SELECT id, item_name, image from merchandise ");
		$stmt->bind_result($merchid_from_db, $merchname_from_db, $merchimage_from_db);
		$stmt->execute();
		$array = array();
		while($stmt->fetch()){
			
			$imageadd = new StdClass();
			$imageadd->id = $merchid_from_db;
			$imageadd->image = $merchimage_from_db;
			$imageadd->name = $merchname_from_db;
			
			array_push($array, $imageadd);
			}
		return $array;
	}
}
	
	/*
	Setting an image name to a merchandise item
	*/
class setMerchandiseImage{
	private $connection;
	
	function __construct($connection){
        $this->connection = $connection;
	}
	function setMerchandiseImage($merchid, $imagename){
		$response = new StdClass();
		$stmt = $this->connection->prepare("UPDATE merchandise SET image=? WHERE ID=? ");
		$stmt->bind_param("si", $imagename, $merchid);
		
		if($stmt->execute()){
			
			
			$success = new StdClass();
			$success->message = "Andmed uuendatud";
			$response->success = $success;
			
			
		} else {
			#echo($stmt->error);
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Hiireke läks katki";
			$response->error = $error;
			
		}
        $stmt->close();

        return $response;
	}
}
