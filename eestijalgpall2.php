<?php
	require_once("functions.php");
	require_once("header.php");
	require_once("footer.php");
	

	//data.php
	// siia pääseb ligi sisseloginud kasutaja
	//kui kasutaja ei ole sisseloginud,
	//siis suuunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: page/login.php");
	}

	
	// kas kustutame
	// ?delete=vastav id mida kustutada on aadressi real
	if(isset($_GET["delete"])) {
		
		echo "Kustutame id "  .$_GET["delete"];
		//käivitan funktsiooni, saadan kaasa id!
		deletePosts($_GET["delete"]);
	}
	
	if(isset($_POST["save"])) {
		
		updatePost($_POST["id"],$_POST["post"]);
		
		
	}
	
		//käivitan funktsiooni
		$array_of_posts = getPostData();

?>


<p><a href="data.php" class="btn btn-primary" role="button">Tagasi teemade lehele</a></p>
<p><a href="mingiteema.php" class="btn btn-primary" role="button" style="text-align:left;color:#F8F8FF">Loo ise postitus</a></p>


<div class="well">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>User ID</th>
          <th>Kuupäev, kell</th>
          <th>Arvamus</th>
          <th style="width: 36px;"></th>
        </tr>
      
<?php
		
		for($i=0; $i<count($array_of_posts);$i++) {
				
					

			echo "<tr>";
			echo "<td>".$array_of_posts[$i]->id."</td>";
			echo "<td>".$array_of_posts[$i]->user_id."</td>";
			echo "<td>".$array_of_posts[$i]->timestamp."</td>";
			echo "<td>".$array_of_posts[$i]->post."</td>";
			if($_SESSION["logged_in_user_id"] == $array_of_posts[$i]->user_id){
							echo "<td><a href='?delete=".$array_of_posts[$i]->id."'>X</a></td>";
							echo "<td><a href='edit.php?edit_id=".$array_of_posts[$i]->id."'>Muutmine</a></td>";
						}
			
		
			echo "</tr>";
			
			
			
		}
	
	
?>
</div>