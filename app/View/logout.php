<?php
//Logi kasutaja välja
$_SESSION['login'] = false;
//Refreshime headeriga
header('Location: index.php?page=index');
?>