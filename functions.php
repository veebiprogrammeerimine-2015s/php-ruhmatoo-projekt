<?php 
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
require_once("../config_global.php");
require_once("user.class.php");
require_once("storage.class.php");
require_once("userpage.class.php");



session_start();

	$connection = new mysqli($servername, $server_username, $server_password, $dbname);
	
	$userCreate = new userCreate($connection);
	$userLogin = new userLogin($connection);
	$storageCreate = new storageCreate($connection);
	$userEdit = new userEdit($connection);

	?>