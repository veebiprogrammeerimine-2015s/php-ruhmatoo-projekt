<?php
  require_once 'includes/config.php';

// CLEAR THE INFORMATION FROM THE $_SESSION ARRAY
$_SESSION = array();

// IF THE SESSION IS KEPT IN COOKIE, FORCE SESSION COOKIE TO EXPIRE
if (isset($_COOKIE[session_name()]))
{
   $cookie_expires  = time() - date('Z') - 3600;
   setcookie(session_name(), '', $cookie_expires, '/');
}

// TELL PHP TO ELIMINATE THE SESSION
session_destroy();

// REDIRECT TO THE HOME PAGE
header("Location: index.php");
exit();
?>
