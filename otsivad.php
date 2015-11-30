<?php require_once ("header.php"); ?>

    <br><br>

	<!-- Sisu -->
    <div class="container-fluid">
        <div class="row"  id="body">
            <div class="col-sm-offset-1 col-sm-6">
                <h1>Kassid, kes otsivad kodu</h1>
            </div>
        </div>
    </div>

<?php 
	require_once("functions.php");
	
	
	//kasutaja muudab andmeid
	if(isset($_GET["update"])){
		
		//
		updateCatHome($_GET["cat_id"]);
	}
	
	
	
	//kõik objektide kujul massiivis
	$cat_array=getAllHomeless();
	
	$keyword="";
	if(isset($_GET["keyword"])){
		$keyword=$_GET["keyword"];
		
		//otsime
		$cat_array=getAllHomeless($keyword);
		
	}else{
		//näitame kõiki tulemusi
		//kõik objektide kujul massiivis
		$cat_array=getAllHomeless();
	}
	
?>

	<!-- Sisu -->
    <div class="container-fluid">
        <div class="row"  id="body">
            <div class="col-sm-offset-1 col-sm-6">
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
            </div>
        </div>
    </div>


<?php 
	
	//ükshaaval läbi käia
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