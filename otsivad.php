<?php require_once ("header.php"); ?>

<h1>Kassid, kes otsivad kodu</h1>

<?php 
	require_once("functions.php");
	
	
	//kasutaja muudab andmeid
	if(isset($_GET["update"])){
		
		//
		updateCatKodus($_GET["cat_id"]);
	}
	
	
	
	//k�ik objektide kujul massiivis
	$cat_array=getAllHomeless();
	
	$keyword="";
	if(isset($_GET["keyword"])){
		$keyword=$_GET["keyword"];
		
		//otsime
		$cat_array=getAllHomeless($keyword);
		
	}else{
		//n�itame k�iki tulemusi
		//k�ik objektide kujul massiivis
		$cat_array=getAllHomeless();
	}
	
?>


<h2>Kasside tabel</h2>
<form action="otsivad.php" method="get">
	<input name="keyword" type="search" value="<?=$keyword?>" >
	<input type="submit" value="otsi"> 
</form>

<br>
<table border=1>
<tr>

	<th>Nimi</th>
	<th>Vanus</th>
	<th>Sugu</th>
	<th>Kirjeldus</th>

</tr>

<?php 
	
	//�kshaaval l�bi k�ia
	for($i=0; $i<count($cat_array); $i++){
		
			//lihtne vaade
			echo "<tr>";
			echo "<td>".$cat_array[$i]->name."</td>";
			echo "<td>".$cat_array[$i]->age."</td>";
			echo "<td>".$cat_array[$i]->gender."</td>";
			echo "<td>".$cat_array[$i]->description."</td>";
			echo "</tr>";
		
	}

?>

</table>

<?php require_once ("footer.php"); ?>