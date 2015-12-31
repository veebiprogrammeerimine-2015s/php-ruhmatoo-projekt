<?php
	//Lehe nimi
	$page_title = "Uus CV";
	//Faili nimi
	$page_file = "newresume.php";
?>
<?php
	require_once("header.php");
	require_once ("functions.php");
?>
<?php
	$resume_name = "";
	$resume_name_error = "";


	if(isset($_SESSION['logged_in_user_id'])) {
		if($_SESSION['logged_in_user_group'] == 1) {
			if( $_SERVER["REQUEST_METHOD"] == "POST") {

				if(isset($_POST["new_resume"])){
					if (empty($_POST["resume_name"]) ) {
						$resume_name_error = "See väli on kohustuslik";
					}else{
						$resume_name = cleanInput($_POST["resume_name"]);
					}

					if ($resume_name_error == "") {
						$link = time() + $_SESSION['logged_in_user_id'];
						$hashlink = hash("md5", $link);
						$response = $Resume->newResume($_SESSION['logged_in_user_id'], $resume_name, $hashlink);

					}

				}

			}
		}
	}


 ?>
<div class="row">
  <div class="col-xs-12 col-sm-4">
    <h3>Info</h3>
    <pre class="pre-scrollable">
CVDE KIRJELDUS TULEB KA SIIA ipsum dolor sit amet, consectetur adipiscing elit. Integer ornare sit amet erat id convallis. In hac habitasse platea dictumst. Sed a mauris sodales, tincidunt sapien non, hendrerit enim. Suspendisse potenti. Phasellus ut dui scelerisque, ultrices ex sed, fringilla dui. Ut fermentum enim sit amet sapien tristique, quis convallis nibh dapibus. Cras accumsan massa a augue elementum facilisis. Aenean dictum mauris ut erat rutrum faucibus. Praesent ac sollicitudin eros.

Quisque rutrum egestas sem at luctus. Etiam quis magna mollis, hendrerit ex a, facilisis neque. Donec sit amet hendrerit erat. Morbi maximus egestas massa. In diam metus, molestie a blandit non, lobortis eu purus. Mauris id sapien sit amet nibh auctor luctus. Curabitur pretium mauris id ullamcorper blandit. Donec non interdum ligula. Cras sit amet magna dui.
    </pre>
  </div>

  <div class="col-xs-12 col-sm-8">
    <h3>Uue CV loomine</h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >

			<div class="form-group">
				<label for="resume_name">CV nimi</label>
				<input type="text" class="form-control" name="resume_name">
			</div>

			<button type="submit" name="new_resume" class="btn btn-success pull-right" aria-label="Left Align">
			Edasi <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			</button>
      </div>

    </form>
  </div>
</div>
<?php require_once("footer.php"); ?>
