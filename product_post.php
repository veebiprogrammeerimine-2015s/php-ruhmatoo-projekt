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



<h2>Parandus</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["edit"];?>" > 
  	<label for="product_name" >Nimetus</label><br>
	<input id="product_name" name="product_name" type="text" value="<?php echo $pro_object->product_tech_name;?>" ><br><br>
	<label for="product_year">Aasta</label><br>
	<input id="product_year" name="product_year" type="text" value="<?php echo $pro_object->product_tech_year;?>" ><br><br>
	<label for="product_problem" >Probleem</label><br>
	<input id="product_problem" name="product_problem" type="text" value="<?php echo $pro_object->product_tech_problem;?>" ><br><br>
	<input type="submit" name="update" value="Salvesta">
  </form>