<?php
  require_once 'includes/config.php';

  if(isset($_SESSION["id_from_db"])) {
    if($_SESSION["is_admin"] == 1) {
      header("Location: admin.php");
    } else {
      header("Location: index.php");
    }
	}

  $email_e=$password_e=$create_email_e=$create_password_e="";
  $email=$password=$create_email=$create_password="";

  //
  // **** LOGI SISSE *****
  //
	if (isset($_POST["login"])) {
		if (empty($_POST["email"])) {
			$email_e = "See väli on kohustuslik";
		} else {
      // cleanInput - turvalisus
			$email = cleanInput($_POST["email"]);
		}
		if (empty($_POST["password"])) {
			$password_e = "See väli on kohustuslik";
		} else {
			$password = cleanInput($_POST["password"]);
		}

    // Vigu polnud, siis ...
		if ($password_e == "" && $email_e == "") {

			$password_hash = hash("sha512", $password);

      $login_response = (new User($db))->loginUser($email, $password_hash);

			if (isset($login_response->success)){

        // Kasutaja andmed Admin/User lehe jaoks
				$_SESSION["id_from_db"] = $login_response->success->user->id;
				$_SESSION["user_email"] = $login_response->success->user->email;
        $_SESSION["is_admin"] = $login_response->success->user->admin;

        if ($_SESSION["is_admin"] == 1) {

          header("Location: admin.php");

        } else {

          header("Location: index.php");

        }

				// lõpetame PHP laadimise
				exit();
			}

		}
	}

  //
  // ** LOO KASUTAJA *****
  //
  if (isset($_POST["create"])) {

		if (empty($_POST["create_email"])) {
			$create_email_e = "See väli on kohustuslik";
		} else {
			$create_email = cleanInput($_POST["create_email"]);
		}

		if (empty($_POST["create_password"])) {
			$create_password_e = "See väli on kohustuslik";
		} else {

			if(strlen($_POST["create_password"]) < 8) {
				$create_password_e = "Peab olema vähemalt 8 tähemärki pikk!";
			} else {
				$create_password = cleanInput($_POST["create_password"]);
			}
		}

		if ($create_email_e == "" && $create_password_e == "") {
			$password_hash = hash("sha512", $create_password);

			// Create and call method on same line PHP 5.4
			$create_response = (new User($db))->createUser($create_email, $password_hash);
    }
  }

  // funktsioon, mis eemaldab kõikvõimaliku üleliigse tekstist
  function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=no">
<title>Login</title>
<link rel="stylesheet" href="css/md-css.min.css">
<link rel="stylesheet" href="css/md-icons.min.css">

</head>
<body material centered fluid>
  <h3 class="text-center" style="margin-top: 18%;">
  <?php

    if(isset($create_response)) {
      if(isset($create_response->error)) {
        echo $create_response->error->message;
      } else if(isset($create_response->success)) {
        echo $create_response->success->message;
      }
    } else if(isset($login_response->error)) {
      echo $login_response->error->message;
    }

  ?>
  </h3>
    <form style="margin-right: 25px;display:inline-block" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <h4>Login</h4>
      <div control>
        <label>Username</label><?= $email_e?>
        <input type="text" name="email" placeholder="Username">
      </div>
      <div control>
        <label>Password</label><?= $password_e?>
        <input type="password" name="password" placeholder="Password">
      </div>
      <div control>
        <button type="submit" name="login" bg-blue-grey400 ripple-color="tealA400">Log In</button>
      </div>
    </form>

    <form style="display: inline-block" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <h4>Create</h4>
      <div control>
        <label>Username</label><?= $create_email_e?>
        <input type="text" name="create_email" placeholder="Username">
      </div>
      <div control>
        <label>Password</label><?= $create_password_e?>
        <input type="password" name="create_password" placeholder="Password">
      </div>
      <div control>
        <button type="submit" name="create" bg-blue-grey400 ripple-color="tealA400">Create user</button>
      </div>
    </form>

</body>
</html>
