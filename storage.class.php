<?php 
require_once("../config_global.php");
	
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
class itemCreate{    private $connection;
	
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
        $stmt = $this->connection->prepare("INSERT INTO merchandise (price_added, item_weight, item_name, item_length, item_height, item_width,) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $merchandiseprice, $merchandiseweight, $merchandisename, $merch_length, $merch_height, $merch_width);
		
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
?>