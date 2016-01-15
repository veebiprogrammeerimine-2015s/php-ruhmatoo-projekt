<?php
	
	
	
	require_once("function.php");
	//kas kasutaja tahab kustutada
	// kas aadressireal on ?delete=??!??!?!
	if(isset($_GET["delete"])){
		
		// saadan kaasa id, mida kustutada
		deletePostList($_GET["delete"]);
		
	}
	
	$post_list = getPostList();
	
	//var_dump($post_list);

?>

<table border=1 >
	<tr>
		<th>post_id</th>
		<th>user_id</th>
		<th>post_tech_name</th>
		<th>user_tech_name</th>
		<th>user_tech_email</th>
		<th>X</th>
	</tr>
	
	<?php
	
	// iga massiivis olema elemendi kohta
		// count($car_list) - massiivi pikkus
		for($i = 0; $i < count($post_list); $i++){
			// $i = $i +1; sama mis $i += 1; sama mis $i++;
			
			//kui on see rida mida kasutaja tahab muuta siis kuvan input väljad
			//if(isset($_GET["edit"]) && $post_list[$i]->post_id == $_GET["edit"]){
				// kasutajale muutmiseks
				// tavaline rida
				echo "<tr>";
			
				echo "<td>".$post_list[$i]->post_id."</td>";
				echo "<td>".$post_list[$i]->user_id."</td>";
				echo "<td>".$post_list[$i]->post_tech_name."</td>";
				echo "<td>".$post_list[$i]->user_tech_name."</td>";
				echo "<td>".$post_list[$i]->user_tech_email."</td>";
				echo "<td><a href='?delete=".$post_list[$i]->post_id."'>X</a></td>";
				echo "<td><a href='?edit=".$post_list[$i]->post_id."'>edit</a></td>";
				echo "</tr>";
			//}
			
			
		}
	
	?>

</table>