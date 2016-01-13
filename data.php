<?php
	require_once("functions.php");
	require_once("header.php");
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	//data.php
	// siia pääseb ligi sisseloginud kasutaja
	//kui kasutaja ei ole sisseloginud,
	//siis suuunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	



	
?>



<div class="row">
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="pildid/eestijalgpall" alt="eestijalgpall" style="width:200px; height:160px;">
      <div class="caption">
        <h3>Eesti Jalgpall</h3>
        <p>Kõik seoses Eesti Jalgpalli ja Eesti Meistriliigaga</p>
        <p><a href="eestijalgpall.php" class="btn btn-primary" role="button">Loe edasi ...</a></p>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="pildid/inglisejalgpall" alt="inglise jalgpall" style="width:200px; height:160px;">
      <div class="caption">
        <h3>Inglise jalgpall</h3>
        <p>Arutelu seoses Barclays Premium Ligaga</p>
        <p><a href="inglisejalgpall.php" class="btn btn-primary" role="button">Loe edasi ...</a></p>
      </div>
    </div>
  </div>


  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="pildid/hispaaniajalgpall" alt="hispaaniajalgpall" style="width:200px; height:160px;">
      <div class="caption">
        <h3>Hispaania jalgpall</h3>
        <p>Arutelu seoses La Ligaga</p>
        <p><a href="hispaaniajalgpall.php" class="btn btn-primary" role="button">Loe edasi ...</a></p>
      </div>
    </div>
  </div>


  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="pildid/saksamaajalgpall" alt="saksamaajalgpall" style="width:200px; height:160px;">
      <div class="caption">
        <h3>Saksamaa jalgpall</h3>
        <p>Arutelu seoses Bundesligaga</p>
        <p><a href="saksamaajalgpall.php" class="btn btn-primary" role="button">Loe edasi ...</a></p>
      </div>
    </div>
 
</div>

  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="pildid/uefa" alt="uefa" style="width:200px; height:160px;">
      <div class="caption">
        <h3>Meistriteliiga UEFA</h3>
        <p>Arutelu seoses UEFA Meistriteliigaga</p>
        <p><a href="uefa.php" class="btn btn-primary" role="button">Loe edasi ...</a> </p>
      </div>
    </div>
 
</div>
