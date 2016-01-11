<?php
	require_once("function.php");
	//kas kasutaja tahab kustutada
	// kas aadressireal on ?delete=??!??!?!
	if(isset($_GET["delete"])){
		
		// saadan kaasa id, mida kustutada
		deletePOST($_GET["delete"]);
		
	}
	
	$post_list = getPostList();
	//var_dump($car_list);
?>

<table border=1 >
	<tr>
		<th>postid</th>
		<th>name</th>
		<th>userid</th>
		<th>X</th>
	</tr>
	
	<?php
	
		// iga massiivis olema elemendi kohta
		// count($car_list) - massiivi pikkus
		for($i = 0; $i < count($post_list); $i++){
			// $i = $i +1; sama mis $i += 1; sama mis $i++;
			
			//kui on see rida mida kasutaja tahab muuta siis kuvan input väljad
			if(isset($_GET["edit"]) && $post_list[$i]->post_id == $_GET["edit"]){
				// kasutajale muutmiseks
				echo "<tr>";
					echo "<form action='table.php' method='post'>";
						echo "<td>".$post_list[$i]->post_id."</td>";
						echo "<td><input name='name' value='".$post_list[$i]->name."</td>";
						echo "<td><input name='user_id' value='".$post_list[$i]->user_id."'></td>";
						echo "<td><input type='submit' name='update'></td>";
						echo "<td><a href='table.php'>cancel</a></td>";
					echo "</form>";
				echo "</tr>";
				
			}else{
				// tavaline rida
				echo "<tr>";
			
				echo "<td>".$post_list[$i]->post_id."</td>";
				echo "<td>".$post_list[$i]->name."</td>";
				echo "<td>".$post_list[$i]->user_id."</td>";
				echo "<td><a href='?delete=".$post_list[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$post_list[$i]->id."'>edit</a></td>";
			
				echo "</tr>";
			}
			
			
		}
	
	?>

</table>