<?php require_once("header.php"); ?>
<?php require_once("functions2.php"); 

$email = "";
$password = "";

if (isset($_SESSION["logged_in_user_id"])){
       header("Location: data.php");

 
if($_SERVER["REQUEST_METHOD"] == "POST"){
       if(isset($_POST['login'])){
       
             $hash = hash("sha512", $password1);
            loginUser($email1, $hash);
        }
    }

}
?>

<html>

<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Logi sisse</h1>
            <div class="account-wall">
                <img class="profile-img" src="pildid/jalgpall.ico"
                    alt="sveg">
                <form class="form-signin">
                <input type="email" class="form-control" name="email1" placeholder="Email" required autofocus> <br>
                <input type="password" class="form-control" name="parool2" placeholder="Parool" required> <br>
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Logi sisse</button>
                <label class="checkbox pull-left">
                    <input type="checkbox" value="remember-me">
                    Jäta mind meelde
                </label>
                
                </form>
            </div>
            <a href="register.php" class="text-center new-account">Loo kasutaja </a>
        </div>
    </div>
</div>

