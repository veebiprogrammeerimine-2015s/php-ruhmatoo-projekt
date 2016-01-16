<?php
	
	
	
	require_once("function.php");
	//kas kasutaja tahab kustutada
	// kas aadressireal on ?delete=??!??!?!
	if(isset($_GET["delete"])){
		
		// saadan kaasa id, mida kustutada
		deleteFeedback($_GET["delete"]);
		
	}
	
	$feedback_list = getFeedbacklist();
	
	//var_dump($post_list);

?>

<table border=1 >
	<tr>
		<th>id</th>
		<th>feedback</th>
	</tr>
	
	<?php
	
	// iga massiivis olema elemendi kohta
		// count($car_list) - massiivi pikkus
		for($i = 0; $i < count($feedback_list); $i++){
			// $i = $i +1; sama mis $i += 1; sama mis $i++;
			
			//kui on see rida mida kasutaja tahab muuta siis kuvan input väljad
			//if(isset($_GET["edit"]) && $post_list[$i]->post_id == $_GET["edit"]){
				// kasutajale muutmiseks
				// tavaline rida
				echo "<tr>";
			
				echo "<td>".$feedback_list[$i]->id."</td>";
				echo "<td>".$feedback_list[$i]->name."</td>";
				echo "<td><a href='comment.php?edit=".$feedback_list[$i]->id."'>Vaata komentaarid</a></td>";
				echo "</tr>";
			//}
			
			
		}
	
	?>

</table>