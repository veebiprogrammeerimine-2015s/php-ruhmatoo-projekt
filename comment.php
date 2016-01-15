<?php
	//edit.php
	require_once("function.php");
	
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		
		updateComment($_POST["id"], $_POST["comment"]);
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
		$post_object = getSinglePostData($_GET["edit"]);
		var_dump($post_object);
	}
	
	
	
	
	
?>
<h2>Muuda autot</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["edit"];?>" > 
  	<label for="comment" >comment</label><br>
	<input id="comment" name="comment" type="text" value="<?php echo $post_object->comment;?>" ><br><br>
	<input type="submit" name="update" value="Salvesta">
  </form>