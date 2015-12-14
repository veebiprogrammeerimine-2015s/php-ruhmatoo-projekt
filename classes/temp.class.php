<?php
class getItem{
	private $connection;
	
	function __construct($connection){
        $this->connection = $connection;
	}
	function getItem($id_into_db){
		
		$stmt = $this->connection->prepare("SELECT price_added, item_weight, item_name, item_length, item_height, item_width, image from merchandise WHERE id=?");
		$stmt->bind_param("i", $id_into_db);
		$stmt->bind_result($price_added_from_db, $item_weight_from_db, $item_name_from_db, $item_length_from_db, $item_height_from_db, $item_width_from_db, $image_from_db);
		$stmt->execute();
		$array = array();
		while($stmt->fetch()){
			
			$Item = new StdClass();
			$Item->item_name = $item_name_from_db;
			$Item->price_added = $price_added_from_db;
			$Item->item_length = $item_length_from_db;
			$Item->item_width = $item_width_from_db;
			$Item->item_height = $item_height_from_db;
			$Item->item_weight = $item_weight_from_db;
			$Item->item_image = $image_from_db;
			array_push($array, $Item);
			
			}
			
		return $array;
	}
}
?>