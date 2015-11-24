<?php
function cleanInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
require_once("../../config_global.php");
require_once("user.class.php");
session_start();


/*// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);*/
//}
$conn = new mysqli($servername, $server_username, $server_password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$User = new User($conn);
?>
