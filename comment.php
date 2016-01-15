<?php
	//edit.php
	require_once("function.php");
	
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		
		createComment($_POST["id"], $_POST["comment"]);
	}
	
	
	
	//id mida muudame
	if(!isset($_GET["edit"])){
		
		// ei ole aadressieal ?edit=midagi
		// suunan table.php lehele
		
		header("location: table.php");
		
	}else{
		// saada kätte kõige uuemad andmed selle id kohta
		//numbrimärk ja värv
		//küsime andmebaasist andmed id järgi
		
		//saadan kaasa id
				//$post_object = getSinglePostData($_GET["edit"]);
		var_dump($post_object);
	}
	
	
	$comment_list = getSinglePostData();
	
	//var_dump($post_list);
	
	
?>


<table border=1 >
	<tr>
		<th>post_name</th>
		<th>comment_user</th>
		<th>user_tech_email</th>
		<th>user_tech_name</th>
		<th>user_tech_name</th>
	</tr>
	
	<?php
	
	// iga massiivis olema elemendi kohta
		// count($car_list) - massiivi pikkus
		for($i = 0; $i < count($comment_list); $i++){
			// $i = $i +1; sama mis $i += 1; sama mis $i++;
			
			//kui on see rida mida kasutaja tahab muuta siis kuvan input väljad
			//if(isset($_GET["edit"]) && $post_list[$i]->post_id == $_GET["edit"]){
				// kasutajale muutmiseks
				// tavaline rida
				echo "<tr>";
			
				echo "<td>".$comment_list[$i]->post_name."</td>";
				echo "<td>".$comment_list[$i]->comment_user."</td>";
				echo "<td>".$comment_list[$i]->comment_tech_id."</td>";
				echo "<td>".$comment_list[$i]->user_tech_email."</td>";
				echo "<td>".$comment_list[$i]->user_tech_name."</td>";
				echo "</tr>";
			//}
			
			
		}
	
	?>

</table>



<h2>Muuda autot</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["edit"];?>" > 
  	<label for="comment" >comment</label><br>
	<input id="comment" name="comment" type="text" value="<?php echo $post_object->comment;?>" ><br><br>
	<input type="submit" name="update" value="Salvesta">
  </form>