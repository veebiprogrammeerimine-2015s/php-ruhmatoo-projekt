<?php
	//Lehe nimi
	$page_title = "CV muutmine";
	//Faili nimi
	$page_file = "editresume.php";
?>
<?php

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
	require_once("../header.php");
 ?>


<div class="row">
	<div class="col-xs-12 col-sm-3">
		<h3>CV muutmine</h3>

		<ul class="nav nav-pills nav-stacked">
			<li role="presentation" class="active"><a href="#personal" aria-controls="personal" role="tab" data-toggle="tab">Isiklik</a></li>
		  <li role="presentation"><a href="#education" class="active" aria-controls="education" role="tab" data-toggle="tab">Hariduskäik</a></li>
		  <li role="presentation"><a href="#languages" aria-controls="languages" role="tab" data-toggle="tab">Keeled</a></li>
			<li role="presentation"><a href="#courses" aria-controls="courses" role="tab" data-toggle="tab">Kursused</a></li>
			<li role="presentation"><a href="#workexp" aria-controls="workexp" role="tab" data-toggle="tab">Töökogemus</a></li>
			<li role="presentation"><a href="#additional" aria-controls="additional" role="tab" data-toggle="tab">Lisainfo</a></li>
		</ul>
	</div>

  <div class="col-xs-12 col-sm-9">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
			<div class="tab-content">
				<!-- Personal -->
				<div role="tabpanel" class="tab-pane active" id="personal">
						<h3>Isiklik informatsioon</h3>

						<ul class="list-group">
						  <li class="list-group-item"><label> Eesnimi: </label> <?=$personal->first;?></li>
						  <li class="list-group-item"><label> Perekonnanimi: </label> <?=$personal->last;?></li>
						  <li class="list-group-item"><label> Maakond: </label> <?=$personal->county;?></li>
						  <li class="list-group-item"><label> Vald: </label> <?=$personal->parish;?></li>
						  <li class="list-group-item"><label> Telefoni number: </label> <?=$personal->number;?></li>
						</ul>

				</div>

				<!-- Education -->
				<div role="tabpanel" class="tab-pane" id="education">
             <h3>
							 Hariduskäik
								<button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#new_school">
                      <span class="glyphicon glyphicon-plus"></span> Uus kool
                </button>
						 </h3>
								<div class="list-group">
										<?php
										for($i = 0; $i < count($getPrimary); $i++) {
												echo '<div class="list-group-item" role="button" data-toggle="collapse" href="#school_'.$getPrimary[$i]->id.'" aria-expanded="false" aria-controls="'.$getPrimary[$i]->id.'">';

												echo '<h4 class="list-group-item-heading">'.$getPrimary[$i]->school.' <font size="2">('.$getPrimary[$i]->start.' - '.$getPrimary[$i]->end.')</font></h4>';
												echo '<p class="list-group-item-text">'.$getPrimary[$i]->type.'</p>';

												echo '</div>';

												echo '<div class="collapse" id="school_'.$getPrimary[$i]->id.'">
															<div class="well">';

												echo '<label for="info">Lisainfo:</label>
															<p class="list-group-item-text">'.$getPrimary[$i]->info.'</p><br>

															<div class="btn-group" role="group">

															<a data-toggle="modal" data-target="#edit_school_'.$getPrimary[$i]->id.'" class="btn btn-info btn-sm">
																			<span class="glyphicon glyphicon-pencil"></span> Muuda
																		</a>
															<a class="btn btn-danger btn-sm" onclick="confirmSchoolDelete('.$getPrimary[$i]->id.');">
																			<span class="glyphicon glyphicon-remove"></span> Kustuta
																		</a>
															</div>';

												echo '</div>
															</div>';
										}

										?>
										<?php for($i = 0; $i < count($getPrimary); $i++): ?>
											<!-- Modal for editing school -->
											<div class="modal fade" id="edit_school_<?=$getPrimary[$i]->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
															<h4 class="modal-title" id="myModalLabel">Muuda kooli <?=$getPrimary[$i]->school;?></h4>
														</div>
														<div class="modal-body" style="height: 500px;">
															<div class="col-sm-12">
																<div class="col-sm-12">
																<div class="col-sm-6">
																	<input type="hidden" name="primary_id" value="<?=$getPrimary[$i]->id;?>">
																	<div class="form-group">
																		<label for="primary_name">Kooli nimi *</label>
																		<input type="text" class="form-control" name="primary_name" value="<?=$getPrimary[$i]->school;?>">
																	</div>
																</div>
																<div class="col-sm-6">

																	<label for="primary_type">Kooli tüüp *</label>

																		<?php
																		$current_type = $Resume->currentTypeDropdown($getPrimary[$i]->id);
																		echo $current_type;
																		?>

																	</div>
																</div>
																<div class="col-sm-12">
																	<div class="form-group">
																		<div class="col-sm-6">
																			<label for="primary_start">Algus *</label>
																			<input type="text" class="form-control" name="primary_start" value="<?=$getPrimary[$i]->start;?>">
																		</div>
																		<div class="col-sm-6">
																			<label for="primary_end">Lõpp</label>
																			<input type="text" class="form-control" name="primary_end" value="<?=$getPrimary[$i]->end;?>">
																		</div>
																	</div>
																</div>
																<div class="col-sm-12">
																	<div class="col-sm-12">
																	<label for="primary_info">Lisainfo</label>
																	<textarea class="form-control" rows="4" name="primary_info" type="text"><?=$getPrimary[$i]->info;?></textarea>
																</div>
																</div>

														</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
																<span class="glyphicon glyphicon-remove"></span> Katkesta
															</button>

															<button type="submit" name="update" class="btn btn-success btn-sm">
																<span class="glyphicon glyphicon-ok"></span> Salvesta
															</button>
														</div>
														</form>
													</div>
												</div>
											</div>
										<?php endfor; ?>

								</div>
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
				<div role="tabpanel" class="tab-pane" id="languages">
	             <h3>
								 Keelteoskus
									<button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#new_language">
	                      <span class="glyphicon glyphicon-plus"></span> Uus keel
	                </button>
							 </h3>
							 <div class="list-group">
									 <?php
									 for($i = 0; $i < count($getLanguages); $i++) {
											 echo '<div class="list-group-item" role="button" data-toggle="collapse" href="#language_'.$getLanguages[$i]->id.'" aria-expanded="false" aria-controls="'.$getLanguages[$i]->id.'">';

											 echo '<h4 class="list-group-item-heading">'.$getLanguages[$i]->language.'</h4>';
											 echo '<p class="list-group-item-text">Kirjutamine: '.$getLanguages[$i]->writing.' | Rääkimine:'.$getLanguages[$i]->speaking.' | Lugemine: '.$getLanguages[$i]->reading.'</p>';

											 echo '</div>';

											 echo '<div class="collapse" id="language_'.$getLanguages[$i]->id.'">
														 <div class="well">';

											 echo '<label for="info">Lisainfo:</label>
														 <p class="list-group-item-text">'.$getLanguages[$i]->info.'</p><br>

														 <div class="btn-group" role="group">

														 <a data-toggle="modal" data-target="#edit_language_'.$getLanguages[$i]->id.'" class="btn btn-info btn-sm">
																		 <span class="glyphicon glyphicon-pencil"></span> Muuda
																	 </a>
														 <a class="btn btn-danger btn-sm" onclick="confirmLanguageDelete('.$getLanguages[$i]->id.');">
																		 <span class="glyphicon glyphicon-remove"></span> Kustuta
																	 </a>
														 </div>';

											 echo '</div>
														 </div>';
									 }

									 ?>
									 <?php for($i = 0; $i < count($getLanguages); $i++): ?>
										 <!-- Modal for editing language -->
											 <div class="modal fade" id="edit_language_<?=$getLanguages[$i]->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												 <div class="modal-dialog" role="document">
													 <div class="modal-content">
														 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
														 <div class="modal-header">
															 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
															 <h4 class="modal-title" id="myModalLabel">Muuda keelt <?=$getLanguages[$i]->language;?></h4>
														 </div>
														 <div class="modal-body" style="height: 500px;">
															 <div class="col-sm-12">
																 <div class="col-sm-12">
																 <div class="col-sm-6">

																	 <input type="hidden" name="language_id" value="<?=$getLanguages[$i]->id;?>">

																	 <div class="form-group">
																		 <label for="language">Keel *</label>
																		 <input type="text" class="form-control" name="language" value="<?=$getLanguages[$i]->language;?>">
																	 </div>
																 </div>
																 <div class="col-sm-6">

																	 <label for="writing">Kirjutamine *</label>

																		 <select class="form-control" name="writing">
																			 <?=$Resume->currentWritingSkill($getLanguages[$i]->id);?>
																		 </select>

																	 </div>
																 </div>
																 <div class="col-sm-12">
																	 <div class="form-group">
																		 <div class="col-sm-6">
																			 <label for="speaking">Rääkimine *</label>

																			 <select class="form-control" name="speaking">
																				 <?=$Resume->currentSpeakingSkill($getLanguages[$i]->id);?>
																			 </select>

																		 </div>
																		 <div class="col-sm-6">
																			 <label for="reading">Lugemine *</label>

																			 <select class="form-control" name="reading">
																				 <?=$Resume->currentReadingSkill($getLanguages[$i]->id);?>
																			 </select>

																		 </div>
																	 </div>
																 </div>
																 <div class="col-sm-12">
																	 <div class="col-sm-12">
																	 <label for="language_info">Lisainfo</label>
																	 <textarea class="form-control" rows="4" name="language_info" type="text"><?=$getLanguages[$i]->info;?></textarea>
																 </div>
																 </div>

														 </div>
														 </div>
														 <div class="modal-footer">
															<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
																 <span class="glyphicon glyphicon-remove"></span> Katkesta
															</button>

															<button type="submit" name="update_language" class="btn btn-success btn-sm">
		 																		<span class="glyphicon glyphicon-ok"></span> Salvesta
		 													</button>
														 </div>
														 </form>
													 </div>
												 </div>
											 </div>

									 <?php endfor; ?>

							 </div>

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

														 <select class="form-control" name="writing">
															 <?=$Resume->languageSkills();?>
														 </select>

													 </div>
												 </div>
												 <div class="col-sm-12">
													 <div class="form-group">
														 <div class="col-sm-6">
															 <label for="speaking">Rääkimine *</label>

															 <select class="form-control" name="speaking">
																 <?=$Resume->languageSkills();?>
															 </select>

														 </div>
														 <div class="col-sm-6">
															 <label for="reading">Lugemine *</label>

															 <select class="form-control" name="reading">
																 <?=$Resume->languageSkills();?>
															 </select>

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
				<div role="tabpanel" class="tab-pane" id="courses">
					<h3>
						Kursused
						 <button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#new_course">
									 <span class="glyphicon glyphicon-plus"></span> Uus kursus
						 </button>
					</h3>

					<div class="list-group">
						<?php
							for($i = 0; $i < count($getCourses); $i++) {
									echo '<div class="list-group-item" role="button" data-toggle="collapse" href="#course_'.$getCourses[$i]->id.'" aria-expanded="false" aria-controls="'.$getCourses[$i]->id.'">';

									echo '<h4 class="list-group-item-heading">'.$getCourses[$i]->course.'</h4>';
									echo '<p class="list-group-item-text">'.$getCourses[$i]->trainer.'</p>';

									echo '</div>';

									echo '<div class="collapse" id="course_'.$getCourses[$i]->id.'">
												<div class="well">';

									echo '<label for="year">Aasta:</label>
												<font class="list-group-item-text">'.$getCourses[$i]->year.'</font><br>
												<label for="duration">Kestvus:</label>
												<font class="list-group-item-text">'.$getCourses[$i]->duration.'</font><br>
												<label for="info">Lisainfo:</label>
												<p class="list-group-item-text">'.$getCourses[$i]->info.'</p><br>

												<div class="btn-group" role="group">

												<a data-toggle="modal" data-target="#edit_course_'.$getCourses[$i]->id.'" class="btn btn-info btn-sm">
																<span class="glyphicon glyphicon-pencil"></span> Muuda
															</a>
												<a class="btn btn-danger btn-sm" onclick="confirmCourseDelete('.$getCourses[$i]->id.');">
																<span class="glyphicon glyphicon-remove"></span> Kustuta
															</a>
												</div>';

									echo '</div>
												</div>';
							}

							?>
							<?php for($i = 0; $i < count($getCourses); $i++): ?>
								<!-- Modal for editing courses -->
								<div class="modal fade" id="edit_course_<?=$getCourses[$i]->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title" id="myModalLabel">Muuda kursust <?=$getCourses[$i]->course;?></h4>
											</div>
											<div class="modal-body" style="height: 500px;">
												<div class="col-sm-12">
													<div class="col-sm-12">
													<div class="col-sm-6">

														<input type="hidden" name="course_id" value="<?=$getCourses[$i]->id;?>">

														<div class="form-group">
															<label for="course_trainer">Koolitaja</label>
															<input type="text" class="form-control" name="course_trainer" value="<?=$getCourses[$i]->trainer;?>">
														</div>
													</div>
													<div class="col-sm-6">

														<label for="course_name">Koolitus *</label>
														<input type="text" class="form-control" name="course_name" value="<?=$getCourses[$i]->course;?>">
														</div>
													</div>
													<div class="col-sm-12">
														<div class="form-group">
															<div class="col-sm-6">
																<label for="course_duration">Kestvus</label>
																<input type="text" class="form-control" name="course_duration" value="<?=$getCourses[$i]->duration;?>">
															</div>
															<div class="col-sm-6">
																<label for="course_year">Aasta</label>
																<input type="text" class="form-control" name="course_year" value="<?=$getCourses[$i]->year;?>">
															</div>
														</div>
													</div>
													<div class="col-sm-12">
														<div class="col-sm-12">
														<label for="course_info">Lisainfo</label>
														<textarea class="form-control" rows="4" name="course_info" type="text"><?=$getCourses[$i]->info;?></textarea>
													</div>
													</div>

											</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
													<span class="glyphicon glyphicon-remove"></span> Katkesta
												</button>

												<button type="submit" name="update_course" class="btn btn-success btn-sm">
								          <span class="glyphicon glyphicon-ok"></span> Salvesta
								        </button>
											</div>
											</form>
										</div>
									</div>
								</div>




							<?php endfor; ?>

					</div>


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
				<div role="tabpanel" class="tab-pane" id="workexp">
					<h3>
						Varasem töökogemus
						 <button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#new_work">
									 <span class="glyphicon glyphicon-plus"></span> Uus töö
						 </button>
					</h3>

					<div class="list-group">
						<?php
							for($i = 0; $i < count($getWorkexp); $i++) {
									echo '<div class="list-group-item" role="button" data-toggle="collapse" href="#work_'.$getWorkexp[$i]->id.'" aria-expanded="false" aria-controls="'.$getCourses[$i]->id.'">';

									echo '<h4 class="list-group-item-heading">'.$getWorkexp[$i]->name.' <font size="2">('.$getPrimary[$i]->start.' - '.$getPrimary[$i]->end.')</font></h4>';
									echo '<p class="list-group-item-text">'.$getWorkexp[$i]->company.'</p>';

									echo '</div>';

									echo '<div class="collapse" id="work_'.$getWorkexp[$i]->id.'">
												<div class="well">';

									echo '<label for="content">Töö sisu:</label><br>
												<font class="list-group-item-text">'.$getWorkexp[$i]->content.'</font><br>
												<label for="add_info">Lisainfo:</label><br>
												<font class="list-group-item-text">'.$getWorkexp[$i]->info.'</font><br>

												<div class="btn-group" role="group">

												<a data-toggle="modal" data-target="#edit_work_'.$getWorkexp[$i]->id.'" class="btn btn-info btn-sm">
																<span class="glyphicon glyphicon-pencil"></span> Muuda
															</a>
												<a class="btn btn-danger btn-sm" onclick="confirmWorkDelete('.$getWorkexp[$i]->id.');">
																<span class="glyphicon glyphicon-remove"></span> Kustuta
															</a>
												</div>';

									echo '</div>
												</div>';
							}

							?>
							<?php for($i = 0; $i < count($getWorkexp); $i++): ?>
								<!-- Modal for editing work -->
								<div class="modal fade" id="edit_work_<?=$getWorkexp[$i]->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title" id="myModalLabel">Muuda varasemat töökohta <?=$getWorkexp[$i]->name;?></h4>
											</div>
											<div class="modal-body" style="height: 500px;">
												<div class="col-sm-12">
													<div class="col-sm-12">
													<div class="col-sm-6">

														<input type="hidden" name="work_id" value="<?=$getWorkexp[$i]->id;?>">

														<div class="form-group">
															<label for="work_company">Ettevõte *</label>
															<input type="text" class="form-control" name="work_company" value="<?=$getWorkexp[$i]->company;?>">
														</div>
													</div>
													<div class="col-sm-6">

														<label for="work_name">Amet *</label>
														<input type="text" class="form-control" name="work_name" value="<?=$getWorkexp[$i]->name;?>">
														</div>
													</div>
													<div class="col-sm-12">
														<div class="form-group">
															<div class="col-sm-6">
																<label for="work_start">Algus *</label>
																<input type="text" class="form-control" name="work_start" value="<?=$getWorkexp[$i]->start;?>">
															</div>
															<div class="col-sm-6">
																<label for="work_end">Lõpp</label>
																<input type="text" class="form-control" name="work_end" value="<?=$getWorkexp[$i]->end;?>">
															</div>
														</div>
													</div>
													<div class="col-sm-12">
														<div class="col-sm-12">
														<label for="work_content">Töö sisu *</label>
														<textarea class="form-control" rows="3" name="work_content" type="text"><?=$getWorkexp[$i]->content;?></textarea>
													</div>
													</div>
													<div class="col-sm-12">
														<div class="col-sm-12">
														<label for="work_info">Lisainfo</label>
														<textarea class="form-control" rows="3" name="work_info" type="text"><?=$getWorkexp[$i]->info;?></textarea>
													</div>
													</div>

											</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-danger" data-dismiss="modal">
													<span class="glyphicon glyphicon-remove"></span> Katkesta
												</button>

												<button type="submit" name="update_work" class="btn btn-success">
													<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Salvesta
												</button>
											</div>
											</form>
										</div>
									</div>
								</div>



							<?php endfor; ?>

					</div>


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
				<div role="tabpanel" class="tab-pane" id="additional">

					<h3>
						Lisainformatsioon
						<a href="?edit_add" class="btn btn-info btn-sm pull-right">
									<span class="glyphicon glyphicon-pencil"></span> Muuda
						</a>
					</h3>
					<?php if(isset($_GET["edit_add"])): ?>

						<div class="col-sm-6">
							<label for="add_positive">Positiivsed küljed</label>
							<textarea class="form-control" rows="5" name="add_positive" type="text"><?=$cvid->pos;?></textarea>
						</div>
						<div class="col-sm-6">
							<label for="add_info">Lisainformatsioon endast</label>
							<textarea class="form-control" rows="5" name="add_info" type="text"><?=$cvid->add;?></textarea>
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
							<textarea class="form-control" rows="5" name="add_positive" type="text" readonly><?=$cvid->pos; ?></textarea>
						</div>
						<div class="col-sm-6">
							<label for="add_info">Lisainformatsioon endast</label>
							<textarea class="form-control" rows="5" name="add_info" type="text" readonly><?=$cvid->add; ?></textarea>
						</div>
					<?php endif; ?>

				</div>

			</div>
    </form>
	</div>
	<div class="col-sm-12">
		<br>
		<label class="pull-right" for="profile">Lahkumiseks vajuta "Profiil"</label>
		</div>

		<div class="col-sm-12">
			<br>
			<a href="../content/profile.php" class="btn btn-success pull-right">
				Profiil <span class="glyphicon glyphicon-user"></span>
			</a>
      </div>
		</div>


	<script type="text/javascript">

					// Javascript to enable link to tab
					var hash = document.location.hash;
					var prefix = "";
					if (hash) {
					$('.nav-pills a[href='+hash.replace(prefix,"")+']').tab('show');
					}

					// Change hash for page-reload
					$('.nav-pills a').on('shown.bs.tab', function (e) {
					window.location.hash = e.target.hash.replace("#", "#" + prefix);
					});

					function confirmSchoolDelete(id) {

						var start = new Date().getTime();
						var confirmation = confirm("Kas oled kindel, et soovid kustutada?");
						var dt = new Date().getTime() - start;

						for(var i=0; i < 10 && !confirmation && dt < 50; i++){
								start = new Date().getTime();
								confirmation = confirm("Kas oled kindel, et soovid kustutada?");
								dt = new Date().getTime() - start;
						}
						if(dt < 50)
							 window.location = "?delete="+id;
						else if(dt > 150 && confirmation == true)
							window.location = "?delete="+id;
					};

					function confirmLanguageDelete(id) {

						var start = new Date().getTime();
						var confirmation = confirm("Kas oled kindel, et soovid kustutada?");
						var dt = new Date().getTime() - start;

						for(var i=0; i < 10 && !confirmation && dt < 50; i++){
								start = new Date().getTime();
								confirmation = confirm("Kas oled kindel, et soovid kustutada?");
								dt = new Date().getTime() - start;
						}
						if(dt < 50)
							window.location = "?delete_language="+id;
						else if(dt > 150 && confirmation == true)
							window.location = "?delete_language="+id;
					};

					function confirmCourseDelete(id) {

						var start = new Date().getTime();
						var confirmation = confirm("Kas oled kindel, et soovid kustutada?");
						var dt = new Date().getTime() - start;

						for(var i=0; i < 10 && !confirmation && dt < 50; i++){
								start = new Date().getTime();
								confirmation = confirm("Kas oled kindel, et soovid kustutada?");
								dt = new Date().getTime() - start;
						}
						if(dt < 50)
							window.location = "?delete_course="+id;
						else if(dt > 150 && confirmation == true)
							window.location = "?delete_course="+id;

					};

					function confirmWorkDelete(id) {

						var start = new Date().getTime();
						var confirmation = confirm("Kas oled kindel, et soovid kustutada?");
						var dt = new Date().getTime() - start;

						for(var i=0; i < 10 && !confirmation && dt < 50; i++){
								start = new Date().getTime();
								confirmation = confirm("Kas oled kindel, et soovid kustutada?");
								dt = new Date().getTime() - start;
						}
						if(dt < 50)
							window.location = "?delete_work="+id;
						else if(dt > 150 && confirmation == true)
							window.location = "?delete_work="+id;
					};
	</script>

<?php require_once("../footer.php"); ?>
