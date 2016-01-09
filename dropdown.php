<?php

class dropdown {
	
	private $connection;
	private $user_id;
	
	function __construct($mysqli, $user_id_from_session){

		$this->connection = $mysqli;
		$this->user_id = $user_id_from_session;
		
		echo " kasutaja=".$this->user_id;
	}
	
	
	function createDropdown(){
	
		$html = '';
		$html .= '<select name="new_dd_selection">';
		
		//$html .= '<option selected>1</option>';
		//$stmt = $this->connection->prepare("SELECT id, name FROM interests");
		$stmt = $this->connection->prepare("SELECT animals.lid, animals.animal_name FROM animals LEFT JOIN
		vets ON animals.animal_name = vets.a_animal_name WHERE vets.aid IS NULL OR animals.lid != ?");
		$stmt->bind_param("i", $this->user_id);
		$stmt->bind_result($id, $name);
		$stmt->execute();
		
		while($stmt->fetch()){
			
			$html .= '<option value="'.$id.'">'.$name.'</option>';
			
		}
		
		
		$html .= '</select>';
		return $html;		
	
	}
	
}	
	
	
	
	
	
	
	
	
	
?>