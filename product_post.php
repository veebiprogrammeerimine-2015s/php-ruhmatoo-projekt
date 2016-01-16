<?php
	//edit.php
	require_once("function.php");
	
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		
		createProduct($_POST["product_name"], $_POST["product_year"], $_POST["product_problem"]);
		
	}
	
	
	
	//id mida muudame
	if(!isset($_GET["edit"])){
		
		// ei ole aadressieal ?edit=midagi
		// suunan table.php lehele
		
		header("location: product_table.php");
		
	}else{
		// saada katte koige uuemad andmed selle id kohta
		//numbrimark ja varv
		//kusime andmebaasist andmed id jargi
		
		//saadan kaasa id
		$pro_object = getSingleProductData($_GET["edit"]);
		//var_dump($post_object);
	}
	
	
	$pro_list = getSingleProductData();
	
	//var_dump($post_list);
	
	
?>


<table border=1 >
	<tr>
		<th>product id</th>
		<th>product name</th>
		<th>product year</th>
		<th>product problem</th>
		<th>posti name</th>
		<th>useri email</th>
	</tr>
	
	<?php
	
	// iga massiivis olema elemendi kohta
		// count($car_list) - massiivi pikkus
		for($i = 0; $i < count($pro_list); $i++){
			// $i = $i +1; sama mis $i += 1; sama mis $i++;
			
			//kui on see rida mida kasutaja tahab muuta siis kuvan input valjad
			//if(isset($_GET["edit"]) && $post_list[$i]->post_id == $_GET["edit"]){
				// kasutajale muutmiseks
				// tavaline rida
				echo "<tr>";
			
				echo "<td>".$pro_list[$i]->product_tech_id."</td>";
				echo "<td>".$pro_list[$i]->product_tech_name."</td>";
				echo "<td>".$pro_list[$i]->product_tech_year."</td>";
				echo "<td>".$pro_list[$i]->product_tech_problem."</td>";
				echo "<td>".$pro_list[$i]->posti_tech_name."</td>";
				echo "<td>".$pro_list[$i]->useri_tech_email."</td>";
				echo "</tr>";
			//}
			
			
		}
	
	?>

</table>
