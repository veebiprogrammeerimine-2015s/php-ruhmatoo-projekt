<?php 
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
define('__ROOT__', dirname(dirname(__FILE__)));  
require_once(dirname(__ROOT__).'/config_global.php');
session_start();

	$connection = new mysqli($servername, $server_username, $server_password, $dbname);
	
	?>