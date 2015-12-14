<?php
/**
 * Created by PhpStorm.
 * User: JaanMartin
 * Date: 15.11.2015
 * Time: 20:43
 * page for signing in and logging out also registering
 */

//functions to load db
require_once("functions.php");

//if signed in
if(isset($_SESSION["id_from_db"])){
    // if signed in go to
    header("Location: userpage.php");
}

// errors
$email_error = "";
$password_error = "";
$create_email_error = "";
$create_password_error = "";

// values
$email = "";
$password = "";
$create_email = "";
$create_password = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {

    //login if
    if (isset($_POST["login"])) {

        if (empty($_POST["email"])) {
            $email_error = "See väli on kohustuslik";
        } else {
            // prevent injection
            $email = cleanInput($_POST["email"]);
        }

        if (empty($_POST["password"])) {
            $password_error = "See väli on kohustuslik";
        } else {
            $password = cleanInput($_POST["password"]);
        }

        // if here log in
        if ($password_error == "" && $email_error == "") {
            echo "Võib sisse logida! Kasutajanimi on " . $email . " ja parool on " . $password;

            $password_hash = hash("sha512", $password);

            // class in user.class.php
            $login_response = $User->loginUser($email, $password_hash);

            //kasutaja on sisse logitud
            if (isset($login_response->success)) {


                $_SESSION["id_from_db"] = $login_response->success->user->id;
                $_SESSION["user_email"] = $login_response->success->user->email;

                header("Location: data.php");

                //******************************
                //********* OLULINE ************
                //******************************

                // lõpetame PHP laadimise
                exit();


            }


        }

    } // login if end
}

// mysql strip

function cleanInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Log in</h2>

<?php if(isset($login_response->error)): ?>

    <p style="color:red;">
        <?=$login_response->error->message;?>
    </p>

<?php elseif(isset($login_response->success)): ?>

    <p style="color:green;">
        <?=$login_response->success->message;?>
    </p>

<?php endif; ?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?><br><br>
    <input name="password" type="password" placeholder="Parool" value="<?php echo $password; ?>"> <?php echo $password_error; ?><br><br>
    <input type="submit" name="login" value="Log in">
</form>

<h2>Create user</h2>

<?php if(isset($create_response->error)): ?>

    <p style="color:red;">
        <?=$create_response->error->message;?>
    </p>

<?php elseif(isset($create_response->success)): ?>

    <p style="color:green;">
        <?=$create_response->success->message;?>
    </p>

<?php endif; ?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
    <input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?><br><br>
    <input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
    <input type="submit" name="create" value="Create user">
</form>
</body>
</html>
