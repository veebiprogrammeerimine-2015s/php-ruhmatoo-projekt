<?php
ob_start();
session_start();

$db = new PDO("mysql:dbname=blog;host=127.0.0.1", "root", "" );
$disqus = "richardaasa";

//set the error reporting attribute
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//set timezone
date_default_timezone_set('Europe/Tallinn');

//load classes as needed
function __autoload($class) {

   $class = strtolower($class);

	//if call from within assets adjust the path
   $classpath = 'classes/'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	}

	//if call from within admin adjust the path
   $classpath = '../classes/'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	}

	//if call from within admin adjust the path
   $classpath = '../../classes/'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	}

}

?>
