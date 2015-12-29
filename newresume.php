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
	$personal = $Profile->getPersonal($_SESSION['logged_in_user_id']);
  $firstname = $lastname = $county = $parish = $email = $number = $workexp = $positives = $additional = $school = "";
  $firstname_error = $lastname_error = $county_error = $parish_error = $email_error = $number_error = $workexp_error = $positives_error = $additional_error = $school_error = "";
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
																	<table class="table table-striped table-condensed table-bordered">
																		For loopiga tõmbab kõik kasutaja koolid läbi
																		<tr>
																			<td><label> Kool </label></td>
																			<td> Blah </td>
																		</tr>

																		<tr>
																			<td><label> Aastad </label></td>
																			<td> 1900 - 2015 </td>
																		</tr>
																		<tr>

																			<td><label> Lisainfo </label></td>
																			<td> Blah Blah </td>
																		</tr>

																	</table>
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
<?php require_once("footer.php"); ?>
