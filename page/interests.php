<?php
    // kõik mis seotud andmetabeliga, lisamine ja tabeli kujul esitamine
    require_once("functions.php");
    require_once("../classes/InterestManager.class.php");
    
    
    if(!isset($_SESSION['logged_in_user_id'])){
        header("Location: login.php");
    }
	
	if(isset($_GET["logout"])){
	//kustutame sessiooni muutujad
	session_destroy();
	header("Location: login.php");
    }
 
    //****************
    //****HALDUS******
    //****************

    
    $InterestManager = new InterestManager($mysqli, $_SESSION['logged_in_user_id']);
    
    if(isset($_GET["new_interest"])){
        $add_interest_response = $InterestManager->addInterest($_GET["new_interest"]);
    }
    
    if(isset($_GET["dropdown_interest"])){
        $add_user_interest_response = $InterestManager->addUserInterest($_GET["dropdown_interest"]);
    }

?>
<?php 
    // lehe nimi
    $page_title = "Huvide lisamine";
 
?>
<?php
    require_once("../header.php");
?>

<br><br>

<div class="container">
	<div class="row">
		<div class="box">
			<div class="col-lg-12">

				<br>
					<hr>
                    <h2 class="intro-text text-center">Huvialad
                    </h2>
					<hr>
					
					<p class="text-center">Kui jooksimise vahepeal jääb aega teisteks hobideks, siis pane needki kirja, ehk on kellelgi veel samad huvid.</p>
				<br>
				<p style="margin:10px">
				<?php if(isset($add_interest_response->error)): ?>
				  
				  <p style="color:red"><?=$add_interest_response->error->message;?></p>
				<?php elseif(isset($add_interest_response->success)): ?>

				<p style="color:green;">
					<?=$add_interest_response->success->message;?>
				</p>
				  <?php endif; ?>
				<form>
					<input name="new_interest"> <br><br>
					<input type="submit" value="Lisa">
				</form>

				<hr>
				<h2 class="intro-text text-center">Lisatud huvialad
				</h2>
				<hr>
				<?php if(isset($add_user_interest_response->error)): ?>
				  
				  <p style="color:red"><?=$add_user_interest_response->error->message;?></p>
				<?php elseif(isset($add_user_interest_response->success)): ?>

				<p style="color:green;">
					<?=$add_user_interest_response->success->message;?>
				</p>
				  <?php endif; ?>
					<form>
					<?=$InterestManager->createDropdown();?>
					<input type="submit" value="Lisa">
				</form>

					<hr>
                    <h2 class="intro-text text-center">Minu huvialad
                    </h2>
					<hr>
				<?=$InterestManager->getUserInterests();?>
			</div>
		</div>
	</div>
</div>

<?php require_once("../footer.php"); ?> 
   
