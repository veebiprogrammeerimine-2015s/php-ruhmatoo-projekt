<?php 
require_once(__DIR__.'/../functions/functions.php');
	
class storageCreate {
    private $connection;
	
	function __construct($connection){
        $this->connection = $connection;
		}

	function createStorage($storage_name, $storage_address){

		$response = new StdClass();
		
        $stmt = $this->connection->prepare("SELECT id FROM storage_data WHERE name=?");
		#echo($this->connection->error);
		$stmt->bind_param("s", $storage_name);
		$stmt->bind_result($id);
		$stmt->execute();
		if($stmt->fetch()){
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Lao nimi/aadress on juba kasutusel";
			$response->error = $error;
			
			return $response;
			
		}
		$stmt->close();
        $stmt = $this->connection->prepare("INSERT INTO storage_data (name, address, created) VALUES (?,?,?)");
        $stmt->bind_param("sss", $storage_name, $storage_address, time());
		
        if($stmt->execute()){
			
			$success = new StdClass();
			$success->message = "Ladu edukalt lisatud";
			
			$response->success = $success;
			
			
		} else {
			echo($stmt->error);
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Hiireke läks katki";
			$response->error = $error;
			
		}
        $stmt->close();
        return $response;
    }
		
}
class itemCreate{    
	private $connection;
	
	function __construct($connection){
        $this->connection = $connection;
		}

	function createItem($merchandiseprice, $merchandiseweight, $merchandisename, $merch_length, $merch_height, $merch_width){
		
		$response = new StdClass();
		
		$stmt = $this->connection->prepare("SELECT id FROM merchandise WHERE item_name=?");
		#echo($this->connection->error);
		$stmt->bind_param("s", $merchandisename);
		$stmt->bind_result($merchandiseid);
		$stmt->execute();
		if($stmt->fetch()){
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Tootenimi on kasutusel";
			$response->error = $error;
			
			return $response;
			
		}
		$stmt->close();
		$stmt = $this->connection->prepare("INSERT INTO merchandise(price_added, item_weight, item_name, item_length, item_height, item_width) VALUES (?,?,?,?,?,?)");
		echo($this->connection->error);
		$stmt->bind_param("iisiii", $merchandiseprice, $merchandiseweight, $merchandisename, $merch_length, $merch_height, $merch_width);
		
		if($stmt->execute()){
			
			$success = new StdClass();
			$success->message = "Toode edukalt lisatud";
			
			$response->success = $success;
			
			
		} else {
			echo($stmt->error);
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Hiireke läks katki";
			$response->error = $error;
			
		}
		$stmt->close();
		return $response;
    }
		
}
class getAllItems{
	private $connection;
	
	function __construct($connection){
        $this->connection = $connection;
	}
	function getAllItems($keyword=""){
		
		if($keyword == ""){
			//ei otsi
			$search = "%%";
		}else{
			//otsime
			$search = "%".$keyword."%";
		}
		$stmt = $this->connection->prepare("SELECT price_added, item_weight, item_name, item_length, item_height, item_width, id, image from merchandise WHERE deleted IS NULL AND (item_name LIKE ?)");
		$stmt->bind_param("s", $search);
		$stmt->bind_result($price_added_from_db, $item_weight_from_db, $item_name_from_db, $item_length_from_db, $item_height_from_db, $item_width_from_db, $id_from_db, $image_from_db);
		$stmt->execute();
		$array = array();
		while($stmt->fetch()){
			
			$table = new StdClass();
			$table->id = $id_from_db;
			$table->item_name = $item_name_from_db;
			$table->price_added = $price_added_from_db;
			$table->item_length = $item_length_from_db;
			$table->item_width = $item_width_from_db;
			$table->item_height = $item_height_from_db;
			$table->item_weight = $item_weight_from_db;
			$table->item_image = $image_from_db;
			array_push($array, $table);
			
			}
			
		return $array;
	}
}
class deleteItems{
	private $connection;
	
	function __construct($connection){
        $this->connection = $connection;
		}
	function deleteItems($item_id){
		
		// uuendan välja deleted, lisan praeguse date'i
		$stmt = $this->connection->prepare("UPDATE merchandise SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $item_id);
		$stmt->execute();
		
		// tühjendame aadressirea
		header("Location:/../pages/storageitems.php");
		
		$stmt->close();
	}
}
class updateItems{
	private $connection;
	
	function __construct($connection){
        $this->connection = $connection;
		}
	function updateItems($price_added_to_db, $item_weight_to_db, $item_name_to_db, $item_length_to_db, $item_height_to_db, $item_weight_to_db, $id_to_db){

		$stmt = $this->connection->prepare("UPDATE merchandise SET price_added=?, item_weight=?, item_name=?, item_length=?, item_height=?, item_width=? WHERE id=?");
		$stmt->bind_param("iisiiii",$price_added_to_db, $item_weight_to_db, $item_name_to_db, $item_length_to_db, $item_height_to_db, $item_weight_to_db, $id_to_db);
		$stmt->execute();
		
		// tühjendame aadressirea
		header("Location:/../pages/storageitems.php");
		
		$stmt->close();

	}
}
class getStorage{
	private $connection;
	
	function __construct($connection){
        $this->connection = $connection;
		}
	function getStorage(){
		
		$stmt = $this->connection->prepare("SELECT id, name from storage_data");
		$stmt->bind_result($storage_id_from_db, $storage_name_from_db);
		$stmt->execute();
		$array = array();
		while($stmt->fetch()){
			
			$storage = new StdClass();
			
			$storage->id = $storage_id_from_db;
			$storage->name = $storage_name_from_db;
			
			array_push($array, $storage);
			
		}
		return $array;
	}
}
?>