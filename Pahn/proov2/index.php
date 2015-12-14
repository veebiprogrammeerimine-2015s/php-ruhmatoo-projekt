<?php
session_start();
if($_SESSION['user']!=''){header("Location:home.php");}
?>
<!DOCTYPE html>
<html><head>
<title>MySQL injection free Secure Login System - PHP Demo</title>
</head><body>
<div id="content" style="margin-top:10px;height:60%;">
<h2><u>MySQL injection free Secure Login System - PHP Demo</u></h2><br/>
<form method="POST" action="index.php" style="border:1px solid black;display:table;margin:0px auto;padding-left:10px;padding-bottom:5px;">
<table width="300" cellpadding="4" cellspacing="1">
<tr><td><td colspan="3"><strong>User Login</strong></td></tr>
<tr><td width="78">E-Mail</td><td width="6">:</td><td width="294"><input size="25" name="mail" type="text"></td></tr>
<tr><td>Password</td><td>:</td><td><input name="pass" size="25" type="password"></td></tr>
<tr><td></td><td></td><td><input type="submit" name="Submit" value="Login"></td>
</tr>
</table>
Login System provided by <a target="_blank" href='http://www.subinsb.com/2013/08/secure-injection-free-login-system-php.html'>Subins</a>
<?


include("../../config.php");
$email=$_POST['mail'];
$password=$_POST['pass'];
if(isset($_POST) && $email!='' && $password!=''){
 $sql=$dbh->prepare("SELECT * FROM users WHERE username=?");
 $sql->execute(array($email));
 while($r=$sql->fetch()){
  $p=$r['password'];
  $p_salt=$r['psalt'];
  $id=$r['id'];
 }
 $site_salt="subinsblogsalt";/*Common Salt used for password storing on site. You can't change it. If you want to change it, change it when you register a user.*/
 $salted_hash = hash('sha256',$password.$site_salt.$p_salt);
 if($p==$salted_hash){
  $_SESSION['user']=$id;
  header("Location:home.php");
 }else{
  echo "<h2>Username/Password is Incorrect.</h2>";
 }
}
?>
</form>
<!-- http://www.subinsb.com/2013/08/secure-injection-free-login-system-php.html -->
</div>
</body></html>
