<!DOCTYPE html>
<html><head></head>
<body>
<?
session_start();
if($_SESSION['user']==''){
 header("Location:login.php");
}else{
 include("../../config.php");
 $sql=$dbh->prepare("SELECT * FROM users WHERE id=?");
 $sql->execute(array($_SESSION['user']));
 while($r=$sql->fetch()){
  echo "<center><h2>Hello, ".$r['username']."</h2>";
  echo "<a href='logout.php'>Log Out</a></center>";
 }
}
?>
</body>
</html>
