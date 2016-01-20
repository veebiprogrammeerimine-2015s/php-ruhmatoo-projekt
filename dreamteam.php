
<?php require_once("functions.php") ?>
<?php require_once("header.php") ?>
<?php require_once("footer.php"); ?>
<?php if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	$array_of_dream = getDreamData();
	
	?>

	<html>
    <head></head>
    <body>
       <?php if ($_SESSION['logged_in_user_id'] == 'whateverTheNameShouldBe') : ?>
            <span>Edit</span>
       <?php endif; ?>
    </body>
 </html>
	
<h1>
	<div style="text-align: center;"></div>
</h1>
<div style="text-align: center;">
    <p><a href="dreamteam_add.php" class="btn btn-primary" role="button">Loo endale enda dreamteam</a></p>

	
	<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>GK</th>
          <th>LB</th>
          <th>CB1</th>
		  <th>CB2</th>
          <th>RB</th>
          <th>LM</th>
          <th>CM1</th>
		  <th>CM2</th>
          <th>RM</th>
          <th>ST1</th>
          <th>ST2</th>
          <th style="width: 36px;"></th>
        </tr>
      
<?php
		
		for($i=0; $i<count($array_of_dream);$i++) {
				
					

			echo "<tr>";
			echo "<td>".$array_of_dream[$i]->GK."</td>";
			echo "<td>".$array_of_dream[$i]->LB."</td>";
			echo "<td>".$array_of_dream[$i]->CB1."</td>";
			echo "<td>".$array_of_dream[$i]->CB2."</td>";
			echo "<td>".$array_of_dream[$i]->RB."</td>";
			echo "<td>".$array_of_dream[$i]->LM."</td>";
			echo "<td>".$array_of_dream[$i]->CM1."</td>";
			echo "<td>".$array_of_dream[$i]->CM2."</td>";
			echo "<td>".$array_of_dream[$i]->RM."</td>";
			echo "<td>".$array_of_dream[$i]->ST1."</td>";
			echo "<td>".$array_of_dream[$i]->ST2."</td>";
			if($_SESSION["logged_in_user_id"] == $array_of_dream[$i]->user_id){
							echo "<td><a href='?delete=".$array_of_dream[$i]->id."'>X</a></td>";
							echo "<td><a href='edit.php?edit_id=".$array_of_dream[$i]->id."'>Muutmine</a></td>";
						}
			
		
			echo "</tr>";
			
			
			
		}
	
	
?>
</div>
