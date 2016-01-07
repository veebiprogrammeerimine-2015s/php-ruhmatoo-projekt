<?php
class Series {
	
	private $connection;
	private $user_id;
	
	//kui tekitan new, siis käivitatakse see funktsioon
	
	function __construct($mysqli, $user_id_from_session){
		
		$this->connection = $mysqli;
		$this->user_id = $user_id_from_session;
		
		// echo "Seriaalide haldus käivitatud, kasutaja=".$this->user_id;
		
	}
	
	function addSeries($title, $season, $description, $picture){
		
		$response = new StdClass();
		
		
		$stmt = $this->connection->prepare("SELECT id FROM series WHERE title=?");
		$stmt->bind_param("s", $title);
		$stmt->bind_result($id);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Seriaal <strong>".$title."</strong> on juba olemas!";
			
			$response->error = $error;
			
			return $response;
			
		}
		
		$stmt->close();
		
		$stmt = $this->connection->prepare("INSERT INTO series (title, season, description, picture) VALUES (?, ?, ?, ?)");
				
		
		$stmt->bind_param("ssss", $title, $season, $description, $picture);
		if($stmt->execute()) {
			
			$success = new StdClass();
			$success->message = "Successfully added new series!";
			$response->success = $success;
			
			
		}else {
			
			//midagi läks katki
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Something went wrong!".$stmt->error;
			
			$response->error = $error;
			
			
		}
		
		
		$stmt->close();
		
		return $response;
		
		
	}
	
	
	
	function createList($name){
		
		$response = new StdClass();
		
		//kas sellel kasutajal on see list
		$stmt = $this->connection->prepare("SELECT id FROM user_list WHERE user_id=? AND name=?");
		$stmt->bind_param("is", $this->user_id, $name);
		$stmt->bind_result($id);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Sellise nimega list on juba olemas!";
			
			$response->error = $error;
			
			return $response;
			
		}
		
		$stmt->close();
		
		$stmt = $this->connection->prepare("INSERT INTO user_list (user_id, name) VALUES (?,?)");
				
		
		$stmt->bind_param("is", $this->user_id, $name);
		if($stmt->execute()) {
			
			$success = new StdClass();
			$success->message = "Successfully added list!";
			$response->success = $success;
			
			
		}else {
			
			//midagi läks katki
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Something went wrong!".$stmt->error;
			
			$response->error = $error;
			
			
		}
		
		
		$stmt->close();
		
		return $response;
		
		
	}
	
	
	function addToList($episode_id, $list_id){
		
		$response = new StdClass();
		
		//kas sellel kasutajal on see list
		$stmt = $this->connection->prepare("SELECT series_list.id FROM user_list, series_list WHERE user_list.id = series_list.list_id AND series_list.episode_id=? AND user_list.id=? AND user_list.user_id=?");
		$stmt->bind_param("iii", $episode_id, $list_id, $this->user_id);
		$stmt->bind_result($id);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			
			$error = new StdClass();
			$error->id = 0;
			$error->message = "This series is already on the list!";
			
			$response->error = $error;
			
			return $response;
			
		}
		
		$stmt->close();
		
		$stmt = $this->connection->prepare("INSERT INTO series_list (episode_id, list_id) VALUES (?,?)");
				
		
		$stmt->bind_param("ii", $episode_id, $list_id);
		if($stmt->execute()) {
			
			$success = new StdClass();
			$success->message = "Series added to list!";
			$response->success = $success;
			
			
		}else {
			
			//midagi läks katki
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Something went wrong!";
			
			$response->error = $error;
			
			
		}
		
		
		$stmt->close();
		
		return $response;
		
		
	}
	
	function getUserLists(){
		
		// get all lists of logged in user
		$stmt = $this->connection->prepare("SELECT id, name FROM user_list WHERE user_id=?");
		$stmt->bind_param("i", $this->user_id);
		$stmt->bind_result($id, $name);
		$stmt->execute();
		
		$array_of_lists = array();
		while($stmt->fetch()){
			
			$list = new StdClass();
			$list->id = $id;
			$list->name = $name;
			
			array_push($array_of_lists, $list);
		}
		
		return $array_of_lists;
	}
	
	function getEpisodesInList($list_id){
		
		// get episodes in user list
		$stmt = $this->connection->prepare("SELECT series.id, series.title, series.season FROM series_list, series WHERE series_list.episode_id = series.id AND series_list.list_id=?");
		$stmt->bind_param("i", $list_id);
		$stmt->bind_result($id, $title, $season);
		$stmt->execute();
		
		$array_of_episodes = array();
		while($stmt->fetch()){
			
			$episode = new StdClass();
			$episode->id = $id;
			$episode->title = $title;
			$episode->season = $season;
			array_push($array_of_episodes, $episode);
		}
		
		return $array_of_episodes;
	
	}
	
	function deleteFromList($id){
		
		
		$stmt = $this->connection->prepare("UPDATE series_list SET deleted=NOW() WHERE series_list.id=?");
		$stmt->bind_param("i", $id);
		if($stmt->execute()){
			// sai kustutatud
			// kustutame aadressirea tühjaks
			header("Location: lists.php");
			
		}
		
		$stmt->close();
		$mysqli->close();
	
	}
	
} ?>