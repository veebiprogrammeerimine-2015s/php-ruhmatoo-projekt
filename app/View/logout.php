<?php
//Logi kasutaja välja
$_SESSION['login'] = false;
$_SESSION['owner'] = false;
//Refreshime headeriga
header('Location: index.php?page=index');
?>