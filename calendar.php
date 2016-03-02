<?php

$db = new PDO("mysql:dbname=blog;host=127.0.0.1", "root", "" );
//set the error reporting attribute
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $db->query("SELECT * FROM blog_posts");

$results=$stmt->fetchAll(PDO::FETCH_ASSOC);
print json_encode($results);

?>
