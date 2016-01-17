<?php
//Logi kasutaja välja
$_SESSION['login'] = false;
$_SESSION['owner'] = false;
$_SESSION['owner_name'] = false;
//Refreshime headeriga
header('Location: index.php?page=index');
?>