<?php
	require_once("../header.php");
	require_once("../functions.php");
	require_once("../classes/Series.class.php");
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	$Series = new Series($mysqli, $_SESSION["logged_in_user_id"]);
	
	if(isset($_POST["createList"])){
		if ( empty($_POST["name"]) ) {
					$name_error = "Field is empty";
				}else{
					$name = cleanInput($_POST["name"]);
				}
		if($name_error == ""){
			
			echo "List created";
			
			$add_list_response = $Series->createList($name);
		}
	}
	function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
	}
?>	
<?php 
	
	if(isset($add_list_response)){
		var_dump($add_list_response);
	}
?>
	
<form method="post">
    <input name="name" type="text">
    <input type="submit" name="createList" value="Submit">
</form>

<?php

// küsid kõik kasutaja listid
$array_of_user_lists = $Series->getUserLists();

foreach($array_of_user_lists as $list){
	echo "<h1>".$list->name.$list->id."</h1>";
	
	$episodes_in_single_list = $Series->getEpisodesInList($list->id);
	var_dump($episodes_in_single_list);
	
	foreach($episodes_in_single_list as $episode){
		echo "<p>".$episode->title."</p>";
	}
	
	
}


	// iga listi kohta küsid episoodid mis seal sees on

?>