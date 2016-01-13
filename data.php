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
        <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="pildid/inglisejalgpall" alt="inglise jalgpall" style="width:200px; height:160px;">
      <div class="caption">
        <h3>Inglise jalgpall</h3>
        <p>...</p>
        <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
      </div>
    </div>
  </div>


  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="pildid/hispaaniajalgpall" alt="hispaaniajalgpall" style="width:200px; height:160px;">
      <div class="caption">
        <h3>Hispaania jalgpalll</h3>
        <p>...</p>
        <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
      </div>
    </div>
  </div>


  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="pildid/saksamaajalgpall" alt="saksamaajalgpall" style="width:200px; height:160px;">
      <div class="caption">
        <h3>Saksamaa jalgpalll</h3>
        <p>...</p>
        <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
      </div>
    </div>
 
</div>

  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img src="pildid/uefa" alt="uefa" style="width:200px; height:160px;">
      <div class="caption">
        <h3>Meistriteliiga UEFA</h3>
        <p>...</p>
        <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
      </div>
    </div>
 
</div>
