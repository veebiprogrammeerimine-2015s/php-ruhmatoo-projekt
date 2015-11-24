<?php
/**
 * Created by PhpStorm.
 * User: JaanMartin
 * Date: 16.11.2015
 * Time: 9:32
 * index login page
 */
//adding db
require_once("functions.php");

//if signed in goto
if(isset($_SESSION["id_from_db"])){
    // if signed in go to
    header("Location: userpage.php");
}

?>
<!DOCTYPE html>
    <html>
<head>
    <title>Kasutaja logimine</title>
</head>
<body>
<h2>Log in</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
    <input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
    <input type="submit" name="login" value="Log in">
</form>

<h2>Create user</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
    <input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
    <input type="submit" name="create" value="Create user">
</form>

</body>
</html>
