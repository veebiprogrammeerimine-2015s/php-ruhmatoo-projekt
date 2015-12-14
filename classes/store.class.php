<?php 
require_once(__DIR__.'/../functions/functions.php');

class getStoreItems{
	private $connection;
	
	function __construct($connection){
        $this->connection = $connection;
	}
	function getStoreItems(){
		
		
		$stmt = $this->connection->prepare("SELECT id, image, item_name, price_added from merchandise WHERE deleted IS NULL");
		$stmt->bind_result($id_from_db, $image_from_db, $name_from_db, $price_from_db);
		$stmt->execute();
		$array = array();
		while($stmt->fetch()){
			
			$inStore = new StdClass();
			$inStore->id = $id_from_db;
			$inStore->image = $image_from_db;
			$inStore->name = $name_from_db;
			$inStore->item_price = $price_from_db;
			array_push($array, $inStore);
			}
		return $array;
	}
}
