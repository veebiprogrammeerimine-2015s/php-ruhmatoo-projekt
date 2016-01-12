<?php require_once("header.php"); ?>
<?php require_once("functions.php") ?>
<?php

$email2 = "";
$name = "";
$password2 = "";



if($_SERVER["REQUEST_METHOD"] == "POST"){
       if(isset($_POST['registreeri'])){
        
             $hash = hash("sha512", $password2);
            createUser($email2, $name, $hash);
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
            <h1 class="text-center login-title">Registreeri</h1>
            <div class="account-wall">
                <img class="profile-img" src="pildid/jalgpall.ico"
                    alt="sveg">
                <form class="form-signin">
                <input type="text" class="form-control" placeholder="Email" name="email2" required autofocus> <br>
                <input type="text" class="form-control" placeholder="Nimi" name="name" required autofocus> <br>
                <input type="password" class="form-control" name="parool2" placeholder="Parool" required> <br>
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Registreeri</button>
					
                
                
                </form>
            </div>
            
        </div>
    </div>
</div>
  </body>
  </html>