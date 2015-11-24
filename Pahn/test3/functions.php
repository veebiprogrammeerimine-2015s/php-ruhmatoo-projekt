<?php
/**
 * Created by PhpStorm.
 * User: JaanMartin
 * Date: 16.11.2015
 * Time: 9:32
 */
//db
require_once("../../config_global.php");

//connecting to db
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}