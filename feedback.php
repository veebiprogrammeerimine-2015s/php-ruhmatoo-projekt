<?php
	require("navigation.html");
	require_once("functions.php");
 if(!isset($_SESSION["logged_in_user_id"])){
  header("Location: login.php");
  
 } 
 
  $feedback_name = "";
  $feedback_name_error = "";
  $feedback = "";
  $feedback_error = "";
  $feedback_email = "";
  $feedback_email_error = "";
  
  if(isset($_POST["feedbk"])){
   if ( empty($_POST["fbname"]) ) {
     $feedback_name_error = "See väli on kohustuslik";
    }else{
     $feedback_name = cleanInput($_POST["fbname"]);
    }
   if ( empty($_POST["fbemail"]) ) {
     $feedback_email_error = "See väli on kohustuslik";
    }else{
     $feedback_email = cleanInput($_POST["fbemail"]);
    }
   if ( empty($_POST["feedback"]) ) {
     $feedback_error = "See väli on kohustuslik";
    }else{
     $feedback = cleanInput($_POST["feedback"]);
    }
  }  
  if($feedback_email_error  == "" && $feedback_name_error  == "" && $feedback_error  == ""){
    $message = feedBack($feedback_name, $feedback_email, $feedback);
    
    if($message != ""){
     $feedback_name = "";
     $feedback_email = "";
     $feedback = "";
     echo $message;
     
    }
   }
?>

<head>
  <title>LOOMAKLIINIK - Log in</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="materialize.min.css">
<link rel="stylesheet" href="style.css">
</head>

<p>
 Tere, <?=$_SESSION["logged_in_user_email"];?> 
 <a href="?logout=1"> Logi välja <a> 
</p>

<form class="col s12" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method="post">

<h2> Tagasiside</h2>
 <div class="row">
 <div class="input-field col s4">
   <label for="fbname">Nimi</label>
   <input id="fbname" type="text" name="fbname" class="validate" value="<?php echo $feedback_name; ?>"> <?php echo $feedback_name_error; ?>
 </div>
 </div>

 <div class="row">
 <div class="input-field col s4">
  <label for="email">E-mail</label>
  <input name="fbemail" type="email" value="<?php echo $feedback_email; ?>"> <?php echo $feedback_email_error; ?>
   </div>
  </div>
 <div class="row">
 <div class="input-field col s4">
 <label for="problem">Kommentaar</label>
 <textarea id="feedback"  class="materialize-textarea" name="feedback" col=40 rows=8 value="<?php echo $feedback; ?>"> <?php echo $feedback_error; ?> </textarea>
 </div>
 </div>

<div class="waves-effect waves-light btn">
<input type="submit" name ="feedbk" value="Anna tagasiside" />
</div>
</form>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="materialize.min.js"></script>


