<?php
/**
 * Created by PhpStorm.
 * User: JaanMartin
 * Date: 13.11.2015
 * Time: 22:57
 */
session_start();
require_once("../../config_global.php");
require_once("user.class.php");



// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Uus instants klassist User
$User = new User($mysqli);
?>