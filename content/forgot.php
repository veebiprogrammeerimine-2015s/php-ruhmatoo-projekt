<?php
	$page_title = "Unustasid parooli?";
	$page_file = "forgot.php";
?>
<?php
	require_once("../header.php");
	require_once ("../inc/functions.php");

	if(isset($_SESSION['logged_in_user_id'])) {
		header("Location: index.php");
		exit ();
	}

	$email = "";
	$email_error = "";
	$keyresponse = "";
	$checkresponse = "";
	$response = "";
	$key = "";
	$emailcheck = "";
	$link = time();
	$newpass = randStrGen(10);

	#if (isset($_GET["key"]) && isset($_GET["email"])){
		$key = cleanInput($_GET["key"]);
		$emailcheck = cleanInput($_GET["email"]);

		if ($key != "" && $emailcheck != "") {
			$keyresponse = $User->checkKey($emailcheck, $key);

			if(isset($keyresponse->success)) {
				$usedIP = $_SERVER['REMOTE_ADDR'];
				$getpw = $User->getPass($emailcheck, $key, $usedIP);
			}
		}
	#}


	if( $_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["send"])){
			if (empty($_POST["email"])) {
				$email_error = "E-posti lahter ei tohi olla tühi!";
			} else {
				$email = cleanInput($_POST["email"]);
			}
			if($email_error == ""){

                $hash = hash("md5", $link);
				$httplink = "http://ntb.devweb.eu/forgot.php?key=".$hash."&email=".$email;
				$checkresponse = $User->checkEmail($email);
				if(isset($checkresponse->success)) {
					$clientIP = $_SERVER['REMOTE_ADDR'];
					$pwhash = hash("sha512", $newpass);
					$response = $User->forgotPassword($email, $hash, $pwhash, $clientIP);

					if(isset($response->success)) {
					//Message
					$msg = "Teie konto ".$email." parooli taastamine.\n\nJuhul kui Teie pole soovinud taastada parooli, siis ignoreerige antud kirja.\n\nKui aga soovisite parooli taastada, siis käituge järgnevalt:\n1. Vajutage järgnevale lingile, et aktiveerida uus parool: ".$httplink."\n2. Logige sisse meilis antud parooliga\n3. Muutke profiilis parooli!\n\nUus parool: ".$newpass."\n\nTegemist on automaatse emailiga, palume mitte vastata!\n\nLugupidamisega,\nNoorte Tööbörs\nwww.ntb.ee";

					//Send mail
					mail($email,"[NTB] Konto ".$email." parooli taastamine",$msg);

					}
				}

            }
		}

	}


?>
<h3>Unustasid parooli?</h3>

<?php if(isset($response->success)): ?>

<div class="alert alert-success alert-dismissible fade in" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<p><?=$response->success->message;?></p>
</div>

<?php elseif(isset($response->error)): ?>

<div class="alert alert-danger alert-dismissible fade in" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<p><?=$response->error->message;?></p>
</div>

<?php elseif(isset($checkresponse->error)): ?>

<div class="alert alert-danger alert-dismissible fade in" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<p><?=$checkresponse->error->message;?></p>
</div>

<?php elseif(isset($getpw->success)): ?>

<div class="alert alert-success alert-dismissible fade in" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<p><?=$getpw->success->message;?></p>
</div>

<?php elseif(isset($getpw->error)): ?>

<div class="alert alert-danger alert-dismissible fade in" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<p><?=$getpw->error->message;?></p>
</div>

<?php elseif(isset($keyresponse->error)): ?>

<div class="alert alert-danger alert-dismissible fade in" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
	<p><?=$keyresponse->error->message;?></p>
</div>

<?php endif; ?>

<div class="row">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
 <div class="col-sm-4">
    <div class="input-group">
      <input type="email" name="email" class="form-control" placeholder="Email">
      <span class="input-group-btn">
        <input class="btn btn-success" type="submit" name="send" value="Saada">
      </span>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</form>
</div>

<?php require_once("../footer.php"); ?>
