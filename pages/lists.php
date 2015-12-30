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
<?php var_dump($add_list_response);?>
	
<form method="post">
    <input name="name" type="text">
    <input type="submit" name="createList" value="Submit">
</form>
