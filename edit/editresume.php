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
	$getCourses = $Resume->getCourses($cvid->id);
	$getWorkexp = $Resume->getWorkexp($cvid->id);
	$getLanguages = $Resume->getLanguages($cvid->id);

  $primary_name = $primary_start = $primary_end = $primary_info = $primary_type = "";
  $primary_name_error = $primary_start_error = "";

	$course_trainer = $course_name = $course_duration = $course_info = $course_year = "";
	$course_name_error = "";

	$work_company = $work_name = $work_content = $work_info = $work_start = $work_end = "";
	$work_company_error = $work_name_error = $work_content_error = $work_start_error = "";

	$add_positive = "";
	$add_info = "";

	if(isset($_SESSION['logged_in_user_id'])) {
		if($_SESSION['logged_in_user_group'] == 1) {

			if(isset($_GET["delete"])) {
				$Resume->deletePrimary($_GET["delete"], $_SESSION['logged_in_user_id'], $file_to_trim);
			}


			if(isset($_GET["delete_course"])) {
				$Resume->deleteCourse($_GET["delete_course"], $_SESSION['logged_in_user_id'], $file_to_trim);
			}


			if(isset($_GET["delete_work"])) {
				$Resume->deleteWork($_GET["delete_work"], $_SESSION['logged_in_user_id'], $file_to_trim);
			}

			if(isset($_GET["delete_language"])) {
				$Resume->deleteLanguage($_GET["delete_language"], $_SESSION['logged_in_user_id'], $file_to_trim);
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

					if(isset($_POST["update_course"])) {
						if (empty($_POST["course_name"]) ) {
							$course_name_error = "See väli on kohustuslik";
						}else{
							$course_name = cleanInput($_POST["course_name"]);
						}

						$course_trainer = cleanInput($_POST["course_trainer"]);
						$course_duration = cleanInput($_POST["course_duration"]);
						$course_info = cleanInput($_POST["course_info"]);
						$course_year = cleanInput($_POST["course_year"]);

						if ($course_name_error == "") {
						$Resume->editCourse($_POST["course_id"], $course_name, $course_trainer, $course_duration, $course_info, $course_year, $_SESSION['logged_in_user_id'], $file_to_trim);
						}
				}

				if(isset($_POST["update_work"])) {
					if (empty($_POST["work_company"]) ) {
						$work_company_error = "See väli on kohustuslik";
					}else{
						$work_company = cleanInput($_POST["work_company"]);
					}
					if (empty($_POST["work_name"]) ) {
						$work_name_error = "See väli on kohustuslik";
					}else{
						$work_name = cleanInput($_POST["work_name"]);
					}
					if (empty($_POST["work_content"]) ) {
						$work_content_error = "See väli on kohustuslik";
					}else{
						$work_content = cleanInput($_POST["work_content"]);
					}
					if (empty($_POST["work_start"]) ) {
						$work_start_error = "See väli on kohustuslik";
					}else{
						$work_start = cleanInput($_POST["work_start"]);
					}
					$work_info = cleanInput($_POST["work_info"]);
					$work_end = cleanInput($_POST["work_end"]);

					if ($work_company_error == "" && $work_name_error == "" && $work_content_error == "" && $work_start_error == "") {
					$Resume->editWork($_POST["work_id"], $work_company, $work_name, $work_content, $work_info, $work_start, $work_end, $_SESSION['logged_in_user_id'], $file_to_trim);
					}
			}

			if(isset($_POST["update_language"])) {

				if (empty($_POST["language"]) ) {
					$language_error = "See väli on kohustuslik";
				}else{
					$language = cleanInput($_POST["language"]);
				}

				if (empty($_POST["writing"]) ) {
					$writing_error = "See väli on kohustuslik";
				}else{
					$writing = cleanInput($_POST["writing"]);
				}

				if (empty($_POST["speaking"]) ) {
					$speaking_error = "See väli on kohustuslik";
				}else{
					$speaking = cleanInput($_POST["speaking"]);
				}

				if (empty($_POST["reading"]) ) {
					$reading_error = "See väli on kohustuslik";
				}else{
					$reading = cleanInput($_POST["reading"]);
				}

				$language_info = cleanInput($_POST["language_info"]);


				if ($language_error == "" && $writing_error == "" && $speaking_error == "" && $reading_error == "") {
				$Resume->editLanguage($_POST["language_id"], $language, $writing, $speaking, $reading, $language_info, $file_to_trim);
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

				if(isset($_POST["new_language"])){

					if (empty($_POST["language"]) ) {
						$language_error = "See väli on kohustuslik";
					}else{
						$language = cleanInput($_POST["language"]);
					}

					if (empty($_POST["writing"]) ) {
						$writing_error = "See väli on kohustuslik";
					}else{
						$writing = cleanInput($_POST["writing"]);
					}

					if (empty($_POST["speaking"]) ) {
						$speaking_error = "See väli on kohustuslik";
					}else{
						$speaking = cleanInput($_POST["speaking"]);
					}

					if (empty($_POST["reading"]) ) {
						$reading_error = "See väli on kohustuslik";
					}else{
						$reading = cleanInput($_POST["reading"]);
					}

					$language_info = cleanInput($_POST["language_info"]);

					if ($language_error == "" && $writing_error == "" && $speaking_Error == "" && $reading_error == "") {
						$response = $Resume->newLanguage($cvid->id, $language, $writing, $speaking, $reading, $language_info, $file_to_trim);

					}

				}

				if(isset($_POST["new_course"])){
					if (empty($_POST["course_name"]) ) {
						$course_name_error = "See väli on kohustuslik";
					}else{
						$course_name = cleanInput($_POST["course_name"]);
					}

					$course_trainer = cleanInput($_POST["course_trainer"]);
					$course_duration = cleanInput($_POST["course_duration"]);
					$course_info = cleanInput($_POST["course_info"]);
					$course_year = cleanInput($_POST["course_year"]);

					if ($course_name_error == "") {
					$Resume->newCourse($cvid->id, $course_name, $course_trainer, $course_duration, $course_info, $course_year, $file_to_trim);
					}

				}

				if(isset($_POST["new_work"])){
					if (empty($_POST["work_company"]) ) {
						$work_company_error = "See väli on kohustuslik";
					}else{
						$work_company = cleanInput($_POST["work_company"]);
					}
					if (empty($_POST["work_name"]) ) {
						$work_name_error = "See väli on kohustuslik";
					}else{
						$work_name = cleanInput($_POST["work_name"]);
					}
					if (empty($_POST["work_content"]) ) {
						$work_content_error = "See väli on kohustuslik";
					}else{
						$work_content = cleanInput($_POST["work_content"]);
					}
					if (empty($_POST["work_start"]) ) {
						$work_start_error = "See väli on kohustuslik";
					}else{
						$work_start = cleanInput($_POST["work_start"]);
					}
					$work_info = cleanInput($_POST["work_info"]);
					$work_end = cleanInput($_POST["work_end"]);

					if ($work_company_error == "" && $work_name_error == "" && $work_content_error == "" && $work_start_error == "") {
					$Resume->newWork($cvid->id, $work_company, $work_name, $work_content, $work_info, $work_start, $work_end, $file_to_trim);
					}

				}
				if(isset($_POST["save_add"])){
					$add_positive = cleanInput($_POST["add_positive"]);
					$add_info = cleanInput($_POST["add_info"]);

					$Resume->saveAdd($cvid->id, $_SESSION['logged_in_user_id'], $add_positive, $add_info, $file_to_trim);
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
												echo '<td><div class="btn-group pull-right" role="group">';

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
								<!-- Modal for adding school -->
								<div class="modal fade" id="new_school" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								  <div class="modal-dialog" role="document">
								    <div class="modal-content">
											<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								        <h4 class="modal-title" id="myModalLabel">Lisa uus kool</h4>
								      </div>
								      <div class="modal-body" style="height: 500px;">
												<div class="col-sm-12">
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
													</div>
		                      <div class="col-sm-12">
		                        <div class="form-group">
		                          <div class="col-sm-6">
		                            <label for="primary_start">Algus *</label>
		                            <input type="text" class="form-control" name="primary_start">
		                          </div>
		                          <div class="col-sm-6">
		                            <label for="primary_end">Lõpp</label>
		                            <input type="text" class="form-control" name="primary_end">
		                          </div>
		                        </div>
		                      </div>
		                      <div class="col-sm-12">
														<div class="col-sm-12">
														<label for="primary_info">Lisainfo</label>
		                        <textarea class="form-control" rows="4" name="primary_info" type="text"></textarea>
													</div>
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

				<!-- languages -->
				<div id="languages">
	             <h3>
								 Keelteoskus
									<button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#new_language">
	                      <span class="glyphicon glyphicon-plus"></span> Uus keel
	                </button>
							 </h3>
									<table class="table table-hover table-condensed table-striped table-responsive">
										<thead>
											<tr>
												<th>Keel</th>
												<th>Kirjutamine</th>
												<th>Rääkimine</th>
												<th>Lugemine</th>
												<th>Info</th>
											</tr>
										</thead>
										<tbody>
											<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
											<?php
											for($i = 0; $i < count($getLanguages); $i++) {
												if(isset($_GET["edit_language"]) && $_GET["edit_language"] == $getLanguages[$i]->id) {

													echo '<input type="hidden" name="language_id" value="'.$getLanguages[$i]->id.'">';
													echo '<tr>
															 <td><input class="form-control" type="text" name="language" value="'.$getLanguages[$i]->language.'"></td>
															 <td><input class="form-control" type="text" name="writing" value="'.$getLanguages[$i]->writing.'"></td>
															 <td><input class="form-control" type="text" name="speaking" value="'.$getLanguages[$i]->speaking.'"></td>
															 <td><input class="form-control" type="text" name="reading" value="'.$getLanguages[$i]->reading.'"></td>
															 <td><input class="form-control" type="text" name="language_info" value="'.$getLanguages[$i]->info.'"></td>';
													echo '<td>';

													echo '<div class="btn-group" role="group">';
													echo '<button type="submit" name="update_language" class="btn btn-success btn-sm">
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
															 <td>'.$getLanguages[$i]->language.'</td>
															 <td>'.$getLanguages[$i]->writing.'</td>
															 <td>'.$getLanguages[$i]->speaking.'</td>
															 <td>'.$getLanguages[$i]->reading.'</td>
															 <td>'.$getLanguages[$i]->info.'</td>';
													echo '<td><div class="btn-group pull-right" role="group">';

													echo '<a href="?edit_language='.$getLanguages[$i]->id.'" class="btn btn-info btn-sm">
																	<span class="glyphicon glyphicon-pencil"></span> Muuda
																</a>';
													echo '<a href="?delete_language='.$getLanguages[$i]->id.'" class="btn btn-danger btn-sm">
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
									<!-- Modal for adding language -->
									<div class="modal fade" id="new_language" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									  <div class="modal-dialog" role="document">
									    <div class="modal-content">
												<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
									      <div class="modal-header">
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									        <h4 class="modal-title" id="myModalLabel">Lisa uus keel</h4>
									      </div>
									      <div class="modal-body" style="height: 500px;">
													<div class="col-sm-12">
														<div class="col-sm-12">
			                      <div class="col-sm-6">

			                        <div class="form-group">
			                          <label for="language">Keel *</label>
			                          <input type="text" class="form-control" name="language">
			                        </div>
			                      </div>
														<div class="col-sm-6">

															<label for="writing">Kirjutamine *</label>

																<input type="text" class="form-control" name="writing">

															</div>
														</div>
			                      <div class="col-sm-12">
			                        <div class="form-group">
			                          <div class="col-sm-6">
			                            <label for="speaking">Rääkimine *</label>
			                            <input type="text" class="form-control" name="speaking">
			                          </div>
			                          <div class="col-sm-6">
			                            <label for="reading">Lugemine *</label>
			                            <input type="text" class="form-control" name="reading">
			                          </div>
			                        </div>
			                      </div>
			                      <div class="col-sm-12">
															<div class="col-sm-12">
															<label for="language_info">Lisainfo</label>
			                        <textarea class="form-control" rows="4" name="language_info" type="text"></textarea>
														</div>
			                      </div>

												</div>
									      </div>
									      <div class="modal-footer">
													<button type="button" class="btn btn-danger" data-dismiss="modal">
														<span class="glyphicon glyphicon-remove"></span> Katkesta
													</button>

													<button type="submit" name="new_language" class="btn btn-success">
														<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Lisa
													</button>
									      </div>
												</form>
									    </div>
									  </div>
									</div>

						</div>


				<!-- Additional courses -->
				<div id="courses">
					<h3>
						Kursused
						 <button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#new_course">
									 <span class="glyphicon glyphicon-plus"></span> Uus kursus
						 </button>
					</h3>
					<table class="table table-hover table-condensed table-striped table-responsive">
						<thead>
							<tr>
								<th>Koolitaja</th>
								<th>Koolitus</th>
								<th>Kestvus</th>
								<th>Lisainfo</th>
								<th>Aasta</th>
							</tr>
						</thead>
						<tbody>
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
							<?php
							for($i = 0; $i < count($getCourses); $i++) {
								if(isset($_GET["edit_course"]) && $_GET["edit_course"] == $getCourses[$i]->id) {

									echo '<input type="hidden" name="course_id" value="'.$getCourses[$i]->id.'">';
									echo '<tr>
											 <td><input class="form-control" type="text" name="course_trainer" value="'.$getCourses[$i]->trainer.'"></td>
											 <td><input class="form-control" type="text" name="course_name" value="'.$getCourses[$i]->course.'"></td>
											 <td><input class="form-control" type="text" name="course_duration" value="'.$getCourses[$i]->duration.'"></td>
											 <td><input class="form-control" type="text" name="course_info" value="'.$getCourses[$i]->info.'"></td>
											 <td><input class="form-control" type="text" name="course_year" value="'.$getCourses[$i]->year.'"></td>';
									echo '<td>';

									echo '<div class="btn-group" role="group">';
									echo '<button type="submit" name="update_course" class="btn btn-success btn-sm">
														<span class="glyphicon glyphicon-ok"></span>
													</button>';
									echo '<a href="'.$file_to_trim.'" class="btn btn-warning btn-sm">
														<span class="glyphicon glyphicon-remove"></span>
													</a>';
									echo '</div>';
									echo '</td>';
									echo '</tr>';

								} else {
									echo '<tr>
											 <td>'.$getCourses[$i]->trainer.'</td>
											 <td>'.$getCourses[$i]->course.'</td>
											 <td>'.$getCourses[$i]->duration.'</td>
											 <td>'.$getCourses[$i]->info.'</td>
											 <td>'.$getCourses[$i]->year.'</td>';
									echo '<td><div class="btn-group pull-right" role="group">';

									echo '<a href="?edit_course='.$getCourses[$i]->id.'" class="btn btn-info btn-sm">
													<span class="glyphicon glyphicon-pencil"></span> Muuda
												</a>';
									echo '<a href="?delete_course='.$getCourses[$i]->id.'" class="btn btn-danger btn-sm">
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
					<!-- Modal for adding courses-->
					<div class="modal fade" id="new_course" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">Lisa uus kursus</h4>
								</div>
								<div class="modal-body" style="height: 500px;">
									<div class="col-sm-12">
										<div class="col-sm-12">
										<div class="col-sm-6">

											<div class="form-group">
												<label for="course_trainer">Koolitaja</label>
												<input type="text" class="form-control" name="course_trainer">
											</div>
										</div>
										<div class="col-sm-6">

											<label for="course_name">Koolitus *</label>
											<input type="text" class="form-control" name="course_name">
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group">
												<div class="col-sm-6">
													<label for="course_duration">Kestvus</label>
													<input type="text" class="form-control" name="course_duration">
												</div>
												<div class="col-sm-6">
													<label for="course_year">Aasta</label>
													<input type="text" class="form-control" name="course_year">
												</div>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="col-sm-12">
											<label for="course_info">Lisainfo</label>
											<textarea class="form-control" rows="4" name="course_info" type="text"></textarea>
										</div>
										</div>

								</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal">
										<span class="glyphicon glyphicon-remove"></span> Katkesta
									</button>

									<button type="submit" name="new_course" class="btn btn-success">
										<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Lisa
									</button>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>


				<!-- Work experience -->
				<div id="workexp">
					<h3>
						Varasem töökogemus
						 <button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#new_work">
									 <span class="glyphicon glyphicon-plus"></span> Uus töö
						 </button>
					</h3>
					<table class="table table-hover table-condensed table-striped table-responsive">
						<thead>
							<tr>
								<th>Ettevõte</th>
								<th>Amet</th>
								<th>Töö sisu</th>
								<th>Lisainfo</th>
								<th>Algus</th>
								<th>Lõpp</th>
							</tr>
						</thead>
						<tbody>
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
							<?php
							for($i = 0; $i < count($getWorkexp); $i++) {
								if(isset($_GET["edit_work"]) && $_GET["edit_work"] == $getWorkexp[$i]->id) {

									echo '<input type="hidden" name="work_id" value="'.$getWorkexp[$i]->id.'">';
									echo '<tr>
											 <td><input class="form-control" type="text" name="work_company" value="'.$getWorkexp[$i]->company.'"></td>
											 <td><input class="form-control" type="text" name="work_name" value="'.$getWorkexp[$i]->name.'"></td>
											 <td><input class="form-control" type="text" name="work_content" value="'.$getWorkexp[$i]->content.'"></td>
											 <td><input class="form-control" type="text" name="work_info" value="'.$getWorkexp[$i]->info.'"></td>
											 <td><input class="form-control" type="text" name="work_start" value="'.$getWorkexp[$i]->start.'"></td>
											 <td><input class="form-control" type="text" name="work_end" value="'.$getWorkexp[$i]->end.'"></td>';
									echo '<td>';

									echo '<div class="btn-group " role="group">';
									echo '<button type="submit" name="update_work" class="btn btn-success btn-sm">
														<span class="glyphicon glyphicon-ok"></span>
													</button>';
									echo '<a href="'.$file_to_trim.'" class="btn btn-warning btn-sm">
														<span class="glyphicon glyphicon-remove"></span>
													</a>';
									echo '</div>';
									echo '</td>';
									echo '</tr>';

								} else {
									echo '<tr>
											 <td>'.$getWorkexp[$i]->company.'</td>
											 <td>'.$getWorkexp[$i]->name.'</td>
											 <td>'.$getWorkexp[$i]->content.'</td>
											 <td>'.$getWorkexp[$i]->info.'</td>
											 <td>'.$getWorkexp[$i]->start.'</td>
											 <td>'.$getWorkexp[$i]->end.'</td>';
									echo '<td><div class="btn-group pull-right" role="group">';

									echo '<a href="?edit_work='.$getWorkexp[$i]->id.'" class="btn btn-info btn-sm">
													<span class="glyphicon glyphicon-pencil"></span> Muuda
												</a>';
									echo '<a href="?delete_work='.$getWorkexp[$i]->id.'" class="btn btn-danger btn-sm">
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
					<!-- Modal for adding previous work experiences -->
					<div class="modal fade" id="new_work" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">Lisa uus varasem töökoht</h4>
								</div>
								<div class="modal-body" style="height: 500px;">
									<div class="col-sm-12">
										<div class="col-sm-12">
										<div class="col-sm-6">

											<div class="form-group">
												<label for="work_company">Ettevõte *</label>
												<input type="text" class="form-control" name="work_company">
											</div>
										</div>
										<div class="col-sm-6">

											<label for="work_name">Amet *</label>
											<input type="text" class="form-control" name="work_name">
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group">
												<div class="col-sm-6">
													<label for="work_start">Algus *</label>
													<input type="text" class="form-control" name="work_start">
												</div>
												<div class="col-sm-6">
													<label for="work_end">Lõpp</label>
													<input type="text" class="form-control" name="work_end">
												</div>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="col-sm-12">
											<label for="work_content">Töö sisu *</label>
											<textarea class="form-control" rows="3" name="work_content" type="text"></textarea>
										</div>
										</div>
										<div class="col-sm-12">
											<div class="col-sm-12">
											<label for="work_info">Lisainfo</label>
											<textarea class="form-control" rows="3" name="work_info" type="text"></textarea>
										</div>
										</div>

								</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal">
										<span class="glyphicon glyphicon-remove"></span> Katkesta
									</button>

									<button type="submit" name="new_work" class="btn btn-success">
										<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Lisa
									</button>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<!-- Additional (Positives, add. info) -->
				<div id="additional">

					<h3>
						Lisainformatsioon
						<a href="?edit_add" class="btn btn-info btn-sm pull-right">
									<span class="glyphicon glyphicon-pencil"></span> Muuda
						</a>
					</h3>
					<?php if(isset($_GET["edit_add"])): ?>

						<div class="col-sm-6">
							<label for="add_positive">Positiivsed küljed</label>
							<textarea class="form-control" rows="3" name="add_positive" type="text"><?=$cvid->pos;?></textarea>
						</div>
						<div class="col-sm-6">
							<label for="add_info">Lisainformatsioon endast</label>
							<textarea class="form-control" rows="3" name="add_info" type="text"><?=$cvid->add;?></textarea>
						</div>
						<div class="col-sm-12">
						<br>
						<div class="btn-group pull-right" role="group">
							<a href="<?=$file_to_trim;?>" class="btn btn-danger">
								<span class="glyphicon glyphicon-remove"></span> Katkesta
							</a>

							<button type="submit" name="save_add" class="btn btn-success">
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Salvesta
							</button>
						</div>

						</div>

					<?php else: ?>

						<div class="col-sm-6">
							<label for="add_positive">Positiivsed küljed</label>
							<textarea class="form-control" rows="3" name="add_positive" type="text" readonly><?=$cvid->pos; ?></textarea>
						</div>
						<div class="col-sm-6">
							<label for="add_info">Lisainformatsioon endast</label>
							<textarea class="form-control" rows="3" name="add_info" type="text" readonly><?=$cvid->add; ?></textarea>
						</div>
					<?php endif; ?>

				</div>
		</div>
		<div class="col-sm-12">
			<br>
			<a href="../content/profile.php" class="btn btn-success pull-right">
				Edasi <span class="glyphicon glyphicon-chevron-right"></span>
			</a>
      </div>
		</div>

    </form>
  </div>


<?php require_once("../footer.php"); ?>
