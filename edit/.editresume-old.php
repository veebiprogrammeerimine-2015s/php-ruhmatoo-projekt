<?php
	//Lehe nimi
	$page_title = "CV muutmine";
	//Faili nimi
	$page_file = "editresume.php";
?>
<?php
	require_once("../header.php");
	require_once ("../inc/functions.php");

?>
<?php

  $personal = $Profile->getPersonal($_SESSION['logged_in_user_id']);
  $firstname = $lastname = $county = $parish = $email = $number = $workexp = $positives = $additional = $school = "";
  $firstname_error = $lastname_error = $county_error = $parish_error = $email_error = $number_error = $workexp_error = $positives_error = $additional_error = $school_error = "";
	$current = $_SERVER['PHP_SELF'];
	$path = pathinfo($current);
	$file_to_trim = $path['basename'];
	$trimmed = rtrim($file_to_trim, ".php");
	$cvid = $Resume->thisResume($trimmed);
	$getPrimary = $Resume->getPrimary($cvid->id);
	#var_dump($file_to_trim);


  $primary_name = $primary_start = $primary_end = $primary_info = "";
  $primary_name_error = $primary_start_error = "";

	if(isset($_SESSION['logged_in_user_id'])) {
		if($_SESSION['logged_in_user_group'] == 1) {
			if(isset($_GET["delete"])) {
				$Resume->deletePrimary($_GET["delete"], $_SESSION['logged_in_user_id'], $file_to_trim);
			}
		}
	}

  if(isset($_SESSION['logged_in_user_id'])) {
    if($_SESSION['logged_in_user_group'] == 1) {
      if( $_SERVER["REQUEST_METHOD"] == "POST") {

				if(isset($_POST["update"])) {
					if (empty($_POST["primary_name"]) ) {
						$primary_name_error = "See väli on kohustuslik";
					}else{
						$primary_name = cleanInput($_POST["primary_name"]);
					}
          if (empty($_POST["primary_start"]) ) {
						$primary_start_error = "See väli on kohustuslik";
					}else{
						$primary_start = cleanInput($_POST["primary_start"]);
					}
          $primary_end = cleanInput($_POST["primary_end"]);
          $primary_info = cleanInput($_POST["primary_info"]);

					if ($primary_name_error == "" && $primary_start_error == "") {
					$Resume->editPrimary($_POST["primary_id"], $_POST["primary_name"], $_POST["primary_start"], $_POST["primary_end"], $_POST["primary_info"], $_SESSION['logged_in_user_id'], $file_to_trim);
					}
				}

        if(isset($_POST["new_primary"])){
          if (empty($_POST["primary_name"]) ) {
						$primary_name_error = "See väli on kohustuslik";
					}else{
						$primary_name = cleanInput($_POST["primary_name"]);
					}
          if (empty($_POST["primary_start"]) ) {
						$primary_start_error = "See väli on kohustuslik";
					}else{
						$primary_start = cleanInput($_POST["primary_start"]);
					}
          $primary_end = cleanInput($_POST["primary_end"]);
          $primary_info = cleanInput($_POST["primary_info"]);

          if ($primary_name_error == "" && $primary_start_error == "") {
						$response = $Resume->newPrimary($cvid->id, $primary_name, $primary_start, $primary_end, $primary_info, $file_to_trim);

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

			<div class="panel-group" id="accordion1">

				<!-- Personal -->
				<div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="headingTwo">
			      <h4 class="panel-title">
			        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#personal" aria-expanded="false" aria-controls="personal">
			          Isiklikud andmed
			        </a>
			      </h4>
			    </div>
			    <div id="personal" class="panel-collapse collapse" role="tabpanel" aria-labelledby="personal">
			      <div class="panel-body">

							<table class="table table-striped table-bordered">
								<tr>
									<td><label> Eesnimi </label></td>
									<td><?=$personal->first;?></td>
								</tr>
								<tr>
									<td><label> Perekonnanimi </label></td>
									<td><?=$personal->last;?></td>
								</tr>
								<tr>
									<td><label> Maakond </label></td>
									<td><?=$personal->county;?></td>
								</tr>
								<tr>
									<td><label> Vald </label></td>
									<td><?=$personal->parish;?></td>
								</tr>
								<tr>
									<td><label> Telefoni number </label></td>
									<td><?=$personal->number;?></td>
								</tr>
							</table>

			      </div>
			    </div>
			  </div>

				<!-- Education -->
		    <div class="panel panel-default">

		        <div class="panel-heading">
		             <h4 class="panel-title">
		                 <a data-toggle="collapse" data-parent="#accordion3" href="#education">
		                 Hariduskäik
		                 </a>
		             </h4>
		        </div>

		        <div id="education" class="panel-collapse collapse">
		            <div class="panel-body">

		                <div class="panel-group" id="accordion2">

		                    <div class="panel panel-default">
		                        <div class="panel-heading">
		                             <h4 class="panel-title">
		                                <a data-toggle="collapse" data-parent="#accordion2" href="#type1">
		                                    Põhiharidus
		                                </a>
		                              </h4>
		                        </div>
		                        <div id="type1" class="panel-collapse collapse">
		                            <div class="panel-body">
																	<table class="table table-hover table-condensed table-striped">
																		<thead>
																			<tr>
																				<th>Kool</th>
																				<th>Algus</th>
																				<th>Lõpp</th>
																				<th>Lisainfo</th>
																				<th>Admin</th>
																			</tr>
																		</thead>
																		<tbody>
																			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
																			<?php
																			for($i = 0; $i < count($getPrimary); $i++) {
																				if(isset($_GET["edit"]) && $_GET["edit"] == $getPrimary[$i]->id) {
																					#echo '<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);" method="post">';
																					echo '<input type="hidden" name="primary_id" value="'.$getPrimary[$i]->id.'">';
																					echo '<tr>
																							 <td><input class="form-control" type="text" name="primary_name" value="'.$getPrimary[$i]->school.'"></td>
																							 <td><input class="form-control" type="text" name="primary_start" value="'.$getPrimary[$i]->start.'"></td>
																							 <td><input class="form-control" type="text" name="primary_end" value="'.$getPrimary[$i]->end.'"></td>
																							 <td><input class="form-control" type="text" name="primary_info" value="'.$getPrimary[$i]->info.'"></td>';
																					echo '<td>';

																					echo '<button type="submit" name="update" class="btn btn-success btn-xs">
																										<span class="glyphicon glyphicon-ok"></span> Salvesta
																									</button>';
																					echo '<a href="'.$file_to_trim.'" class="btn btn-warning btn-xs">
																										<span class="glyphicon glyphicon-remove"></span> Katkesta
																									</a>';

																					echo '</td>';
																					echo '</tr>';
																					#echo '</form>';
																				} else {
																					echo '<tr>
																							 <td>'.$getPrimary[$i]->school.'</td>
																							 <td>'.$getPrimary[$i]->start.'</td>
																							 <td>'.$getPrimary[$i]->end.'</td>
																							 <td>'.$getPrimary[$i]->info.'</td>';
																					echo '<td><div class="btn-group" role="group">';

																					echo '<a href="?edit='.$getPrimary[$i]->id.'" class="btn btn-info btn-sm">
																									<span class="glyphicon glyphicon-pencil"></span> Muuda
																								</a>';
																					echo '<a href="?delete='.$getPrimary[$i]->id.'" class="btn btn-danger btn-sm">
																									<span class="glyphicon glyphicon-remove"></span> Kustuta
																								</a>';
																					echo '</div></td>';
																					echo '</tr>';
																				}
																			}


																			?>
																		</form>
																		</tbody>
																	</table>
                                  <h3>Lisa uus</h3>
                                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for="primary_name">Kooli nimi</label>
                                        <input type="text" class="form-control" name="primary_name">
                                      </div>
                                    </div>
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <div class="col-sm-6" style="padding-right: 0px;">
                                          <label for="primary_start">Algus</label>
                                          <input type="text" class="form-control" name="primary_start">
                                        </div>
                                        <div class="col-sm-6" style="padding-right: 0px;">
                                          <label for="primary_end">Lõpp</label>
                                          <input type="text" class="form-control" name="primary_end">
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-xs-12">
                                      <textarea class="form-control" rows="2" name="primary_info" type="text"></textarea>
                                      <br>
                                      <button type="submit" name="new_primary" class="btn btn-success pull-right" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Lisa
                                      </button>
                                    </div>
                                  </div>

                                  </form>

																</div>
		                        </div>
		                    </div>

		                    <div class="panel panel-default">
		                        <div class="panel-heading">
		                            <h4 class="panel-title">
		                                <a data-toggle="collapse" data-parent="#accordion2" href="#type2">
		                                    Keskharidus
		                                </a>
		                            </h4>
		                        </div>
		                        <div id="type2" class="panel-collapse collapse">
		                            <div class="panel-body">Panel 3.2</div>
		                        </div>
		                    </div>

												<div class="panel panel-default">
														<div class="panel-heading">
																<h4 class="panel-title">
																		<a data-toggle="collapse" data-parent="#accordion2" href="#type3">
																				Kutseharidus
																		</a>
																</h4>
														</div>
														<div id="type3" class="panel-collapse collapse">
																<div class="panel-body">Panel 3.2</div>
														</div>
												</div>

		                </div>
		            </div>

		        </div>
		    </div>
				<!-- Experience (Work and courses) -->

				<!-- Additional (Positives, add. info) -->

		</div>



			<button type="button" class="btn btn-success pull-right" aria-label="Left Align">
			Edasi <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			</button>
      </div>

    </form>
  </div>
</div>

<?php require_once("../footer.php"); ?>
