<?php
	//load header
	require_once("header.php");
?> 
<?php

	//funktsioonid
	require_once("functions.php");
	require_once("diseasemanager.class.php");

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
		<div class="col-md-2">
			<h3>Lisa uus aeg</h3>
		</div>
		<div class="col-md-6 col-md-offset-1">
				<?php if(isset($_GET["valik"])){
				$allTimes = $DiseaseManager->getDrTimes($_SESSION["id_from_db"], $_GET["valik"]);
				echo $DiseaseManager->build_table($allTimes);
				}?>
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