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


  $primary_name = $primary_start = $primary_end = $primary_info = $primary_type = "";
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
					$primary_type = cleanInput($_POST["primary_type"]);

					if ($primary_name_error == "" && $primary_start_error == "") {
					$Resume->editPrimary($_POST["primary_id"], $primary_name, $primary_start, $primary_end, $primary_info, $primary_type, $_SESSION['logged_in_user_id'], $file_to_trim);
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
					$primary_type = cleanInput($_POST["primary_type"]);

          if ($primary_name_error == "" && $primary_start_error == "") {
						$response = $Resume->newPrimary($cvid->id, $primary_name, $primary_start, $primary_end, $primary_info, $primary_type, $file_to_trim);

					}

        }

      }
    }
  }
 ?>


<div class="row">
  <!--<div class="col-xs-12 col-sm-4">
    <h3>Info</h3>
    <pre class="pre-scrollable">
CVDE KIRJELDUS TULEB KA SIIA ipsum dolor sit amet, consectetur adipiscing elit. Integer ornare sit amet erat id convallis. In hac habitasse platea dictumst. Sed a mauris sodales, tincidunt sapien non, hendrerit enim. Suspendisse potenti. Phasellus ut dui scelerisque, ultrices ex sed, fringilla dui. Ut fermentum enim sit amet sapien tristique, quis convallis nibh dapibus. Cras accumsan massa a augue elementum facilisis. Aenean dictum mauris ut erat rutrum faucibus. Praesent ac sollicitudin eros.

Quisque rutrum egestas sem at luctus. Etiam quis magna mollis, hendrerit ex a, facilisis neque. Donec sit amet hendrerit erat. Morbi maximus egestas massa. In diam metus, molestie a blandit non, lobortis eu purus. Mauris id sapien sit amet nibh auctor luctus. Curabitur pretium mauris id ullamcorper blandit. Donec non interdum ligula. Cras sit amet magna dui.
    </pre>
  </div>-->

  <div class="col-xs-12 col-sm-12">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >

				<!-- Personal -->
				<div id="personal">
			  	<h3>Isiklikud andmed</h3>
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

				<!-- Education -->
						<div id="education">
		             <h3>
									 Hariduskäik
										<button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#new_school">
                          <span class="glyphicon glyphicon-plus"></span> Uus kool
                    </button>
								 </h3>
										<table class="table table-hover table-condensed table-striped table-responsive">
											<thead>
												<tr>
													<th>Kool</th>
													<th>Algus</th>
													<th>Lõpp</th>
													<th>Lisainfo</th>
													<th>Tüüp</th>
													<th>Admin</th>
												</tr>
											</thead>
											<tbody>
												<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
												<?php
												for($i = 0; $i < count($getPrimary); $i++) {
													if(isset($_GET["edit"]) && $_GET["edit"] == $getPrimary[$i]->id) {
														$current_type = $Resume->currentTypeDropdown($getPrimary[$i]->id);
														echo '<input type="hidden" name="primary_id" value="'.$getPrimary[$i]->id.'">';
														echo '<tr>
																 <td><input class="form-control" type="text" name="primary_name" value="'.$getPrimary[$i]->school.'"></td>
																 <td><input class="form-control" type="text" name="primary_start" value="'.$getPrimary[$i]->start.'"></td>
																 <td><input class="form-control" type="text" name="primary_end" value="'.$getPrimary[$i]->end.'"></td>
																 <td><input class="form-control" type="text" name="primary_info" value="'.$getPrimary[$i]->info.'"></td>
																 <td>'.$current_type.'</td>';
														echo '<td>';

														echo '<div class="btn-group" role="group">';
														echo '<button type="submit" name="update" class="btn btn-success btn-sm">
																			<span class="glyphicon glyphicon-ok"></span> Salvesta
																		</button>';
														echo '<a href="'.$file_to_trim.'" class="btn btn-warning btn-sm">
																			<span class="glyphicon glyphicon-remove"></span> Katkesta
																		</a>';
														echo '</div>';
														echo '</td>';
														echo '</tr>';

													} else {
														echo '<tr>
																 <td>'.$getPrimary[$i]->school.'</td>
																 <td>'.$getPrimary[$i]->start.'</td>
																 <td>'.$getPrimary[$i]->end.'</td>
																 <td>'.$getPrimary[$i]->info.'</td>
																 <td>'.$getPrimary[$i]->type.'</td>';
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
										<!-- Modal -->
										<div class="modal fade" id="new_school" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										  <div class="modal-dialog" role="document">
										    <div class="modal-content">
													<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
										      <div class="modal-header">
										        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										        <h4 class="modal-title" id="myModalLabel">Lisa uus kool</h4>
										      </div>
										      <div class="modal-body" style="height: 300px;">
														<div class="col-sm-12">
				                      <div class="col-sm-6">

				                        <div class="form-group">
				                          <label for="primary_name">Kooli nimi *</label>
				                          <input type="text" class="form-control" name="primary_name">
				                        </div>
				                      </div>
															<div class="col-sm-6">

																<label for="primary_type">Kooli tüüp *</label>

																	<?=$Resume->typeDropdown();?>

																</div>
				                      <div class="col-sm-12">
				                        <div class="form-group">
				                          <div class="col-sm-6" style="padding-left: 0px;">
				                            <label for="primary_start">Algus *</label>
				                            <input type="text" class="form-control" name="primary_start">
				                          </div>
				                          <div class="col-sm-6" style="padding-right: 0px;">
				                            <label for="primary_end">Lõpp</label>
				                            <input type="text" class="form-control" name="primary_end">
				                          </div>
				                        </div>
				                      </div>
				                      <div class="col-xs-12">
																<label for="primary_info">Lisainfo</label>
				                        <textarea class="form-control" rows="4" name="primary_info" type="text"></textarea>
				                      </div>

													</div>
										      </div>
										      <div class="modal-footer">
														<button type="button" class="btn btn-danger" data-dismiss="modal">
															<span class="glyphicon glyphicon-remove"></span> Katkesta
														</button>

														<button type="submit" name="new_primary" class="btn btn-success">
															<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Lisa
														</button>
										      </div>
													</form>
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
