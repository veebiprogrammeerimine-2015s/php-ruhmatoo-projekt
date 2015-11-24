<?php
/**
 * Created by PhpStorm.
 * User: JaanMartin
 * Date: 15.11.2015
 * Time: 20:49
 * If logged in if is set from index.php arrive here
 */
//get functions
require_once("functions.php");

//if logged in stay otherwise goto index.php
if(!isset($_SESSION["id_from_db"])){
    header("Location: index.php");
    exit();
}

//if user wants to log out, goto index.php
if(isset($_GET["logout"])){
    session_destroy();

    header("Location: index.php");
    exit();

?>
<p>
    Tere, <?=$_SESSION["user_email"];?>
    <a href="?logout=1"> Logi välja</a>
</p>
