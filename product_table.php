<?php
	
	
	
	require_once("function.php");
	//kas kasutaja tahab kustutada
	// kas aadressireal on ?delete=??!??!?!
	if(isset($_GET["delete"])){
		
		// saadan kaasa id, mida kustutada
		deleteProductList($_GET["delete"]);
		
	}
	
	$produkt_list = getProductList();
	

?>

<table border=1 >
	<tr>
		<th>product_id</th>
		<th>name</th>
		<th>year</th>
		<th>problem</th>
		<th>user_id</th>
		<th>email_user</th>
	</tr>
	
	<?php
	

		for($i = 0; $i < count($produkt_list); $i++){


				echo "<tr>";
			
				echo "<td>".$produkt_list[$i]->product_id."</td>";
				echo "<td>".$produkt_list[$i]->name."</td>";
				echo "<td>".$produkt_list[$i]->year."</td>";
				echo "<td>".$produkt_list[$i]->problem."</td>";
				echo "<td>".$produkt_list[$i]->user_id."</td>";
				echo "<td>".$produkt_list[$i]->email_user."</td>";
				echo "<td><a href='product.php?edit=".$produkt_list[$i]->product_id."'>Vaata komentaarid</a></td>";
				echo "</tr>";
			
			
			
		}
	
	?>

</table>