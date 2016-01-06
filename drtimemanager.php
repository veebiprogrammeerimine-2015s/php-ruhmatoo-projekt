<?php
	//load header
	require_once("header.php");
?> 
<?php

	//funktsioonid
	require_once("functions.php");
	require_once("diseasemanager.class.php");
	
	
	$create_date_error = "";
	
	//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		// suunan home lehele
		header("Location: home.php");
		exit();
	}
	//kontroll, kas kasutaja on doctor, kui ei suunan ära
	if($_SESSION["role_from_db"] != 2){
		header("Location: home.php");
		exit();
	}
	
	$DiseaseManager=new DiseaseManager($mysqli);
	if(isset($_GET["new_Disease"])&&!empty($_GET["new_Disease"])){
		$Disease_response = $DiseaseManager->addDisease($_GET["new_Disease"]);
	}
	if(isset($_GET["dropdownselect"])){
		$added_user_Diseases = $DiseaseManager->addUserDisease($_GET["dropdownselect"], $_SESSION["id_from_db"]);
		
	}
	//kas kasutaja tahab kustutada, kas aadressi real on ?delete=??
	if(isset($_GET["delete"])){
		$DiseaseManager->deleteDisease($_GET["delete"]);
	}
	$allDiseases = $DiseaseManager->getUserDiseases($_SESSION["id_from_db"]);
	
	if(isset($_GET["valik"])){
		$allTimes = $DiseaseManager->getDrTimes($_SESSION["id_from_db"], $_GET["valik"]);
	}
	
	if(isset($_GET["create"])){
		if(empty($_GET["date"])){
				$create_date_error = "See väli on kohustuslik";
			}else{
				//echo($_SESSION["id_from_db"]." ".$_GET["date"]." ".$_GET["starttime"]." ".$_GET["endtime"]);
				$DiseaseManager->addDate($_SESSION["id_from_db"], $_GET["date"], $_GET["starttime"], $_GET["endtime"]);
			}
	}
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-3 col-md-offset-3">
		<h3>Kuupäevad</h3>
		<form>
			<?=$DiseaseManager->getDrDates($_SESSION["id_from_db"]);?>
			<button type="submit" class="btn">Vali</button>
		</form>
		</div>
	</div><br>
	<div class="row">
		<div class="col-md-3">
			<h3>Lisa uus aeg</h3>
			<?php if(isset($addDate->error)):?>
			<p style="color:red;"><?=$addDate->error->message;?></p>
			<?php elseif(isset($addDate->success)):?>
			<p style="color:green;"><?=$addDate->success->message;?></p>
			<?php endif;?>
		</div>
	</div>
		<font style="color:red"><?php echo $create_date_error; ?></font>
		<div class="row">
		<div class="col-md-3">
			<form>
				<div class="form-group">
				<label for="datepicker" class="col-sm-2 control-label">Kuupäev:</label>
				<input type="text" name="date" class="form-control datepicker" id="datepicker" placeholder="kuupäev" value="<?php if(isset($_POST["dob"])){echo $create_age;} ?>">
				</div>
				
				<div class="form-group">
				<label for="starttime" class="col-sm-2 control-label">Algus:</label>
				<select class="form-control" name="starttime">
				<option>7:00</option>
				<option>8:00</option>
				<option>9:00</option>
				<option>10:00</option>
				<option>11:00</option>
				<option>12:00</option>
				<option>13:00</option>
				<option>14:00</option>
				<option>15:00</option>
				<option>16:00</option>
				<option>17:00</option>
				</select>
				</div>
				
				<div class="form-group">
				<label for="endtime" class="col-sm-3 control-label">Lõpp:</label>
				<select class="form-control" name="endtime">
				<option>8:00</option>
				<option>9:00</option>
				<option>10:00</option>
				<option>11:00</option>
				<option>12:00</option>
				<option>13:00</option>
				<option>14:00</option>
				<option>15:00</option>
				<option>16:00</option>
				<option>17:00</option>
				<option>18:00</option>
				</select><br>
				</div>
				
				<div class="form-group">
				<div class="col-sm-offset-3 col-sm-10">
				<button type="submit" class="btn btn-success pull-right" name="create" id="addtime">Sisesta</button>
				</div>
				</div>
			</form>
		</div>
		
		<div class="col-md-8">
				
				<?php
				if(isset($_GET["valik"])){
				$allTimes = $DiseaseManager->getDrTimes($_SESSION["id_from_db"], $_GET["valik"]);
				echo $DiseaseManager->build_table($allTimes);
				}else{
					$allTimes = $DiseaseManager->getDrTimes($_SESSION["id_from_db"], "");
					echo $DiseaseManager->build_table($allTimes);
				}
				?>
				
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-3">
			<h3>Lisa uus haigus</h3>
				<?php if(isset($Disease_response->error)):?>
				<p style="color:red;"><?=$Disease_response->error->message;?></p>
				<?php elseif(isset($Disease_response->success)):?>
				<p style="color:green;"><?=$Disease_response->success->message;?></p>
				<?php endif;?>
			<form>
			  <div class="form-group">
				<input type="text" class="form-control" id="new_Disease" placeholder="haigus" name="new_Disease">
			  </div>
			  <button type="submit" class="btn btn-success pull-right">Sisesta</button>
			</form>
		</div>
		<div class="col-md-8">
		<?php echo $DiseaseManager->build_table($allDiseases);?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<h3>Haigused</h3>
			<?php if(isset($added_user_Diseases->error)):?>
			<p style="color:red;"><?=$added_user_Diseases->error->message;?></p>
			<?php elseif(isset($added_user_Diseases->success)):?>
			<p style="color:green;"><?=$added_user_Diseases->success->message;?></p>
			<?php endif;?>
			<form>
				<?=$DiseaseManager->createDropdown();?>
				<button type="submit" class="btn btn-success pull-right">Sisesta</button>
			</form>
		</div>
	</div>
</div>

<?php
	//load footer
	require_once("footer.php");	
?> 