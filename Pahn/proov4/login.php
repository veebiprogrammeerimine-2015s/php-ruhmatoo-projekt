<?php
session_start();
require_once("functions.php");
//variables


$stmt = $conn->prepare ("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password);

$username = $_POST["userindex"];
$password = $_POST["userpass"];
$stmt->execute();


?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <input name="userindex" type="email" placeholder="E-post" value="<?php echo $username; ?>"> <br><br>
    <input name="userpass" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <br><br>
    <input type="submit" name="login" value="Log in">
</form>
<?
echo $username;
echo $password;
?>
