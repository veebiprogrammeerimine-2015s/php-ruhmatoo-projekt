<?php
	require_once("../config_global.php");
	$database = "if15_teamalpha_3";
	
	require_once("edit_function.php");
	
	if(isset($_POST["update_packet"])){
		//vajuta Salvesta nuppu
		//numberplate ja color tulevad vormist, aga id aadressirealt
		//aga id varjatud väljast
		updatePacket($_POST["id"], $_POST["arrival"], $_POST["departure"], $_POST["fromc"], $_POST["comment"], $_POST["office_id"]);
	}
	
	//edit.php
	//aadressireal on=edit_id siis trükin välja selle väärtuse
	if(isset($_GET["edit_id"])){
		echo $_GET["edit_id"];
		
		//id oli aadressireal
		//tahaks ühte rida kõige uuemaid andmeid, kus id on $_GET["edit_id"]
		
		$packet_array = getPacketData($_GET["edit_id"]);
		var_dump($packet_array);		//var_dump annab kas stringi pikkuse või muutuja tüübi
		
	}else{
		//ei olnud aadressireal
		echo "VIGA";
		//die- edasi lehte ei laeta (siit järgnevat ei loeta)
		//die();
		//suuname kasutaja table.php lehele
		header("Location:dataWorker.php");
		
	}
	
		for($i = 0; $i < count($packet_array); $i=$i+1){
			
			if(isset($_GET["edit"]) && $packet_array[$i]->id == $_GET["edit"]){
				
				echo "<tr>";
				echo "<form action='dataWorker.php' method='post'>";
				echo "<input type='hidden' name='id' value='".$packet_array[$i]->id."'>";
				echo "<td>".$packet_array[$i]->id."</td>";
				echo "<td><input name='arrival' value='".$packet_array[$i]->arrival."'></td>";
				echo "<td><input name='departure' value='".$packet_array[$i]->departure."'></td>";
				echo "<td><input name='fromc' value='".$packet_array[$i]->fromc."'></td>";
				echo "<td><input name='comment' value='".$packet_array[$i]->comment."'></td>";
				echo "<input type='hidden' name='office_id' value='".$packet_array[$i]->office_id."'>";
				echo "<td>".$packet_array[$i]->office_id."</td>";
				echo "<td><a href='dataWorker.php'>cancel</a></td>";
				echo "<td><input type='submit' name='save' value='save'></td>";
				echo "</form>";
				echo "</tr>";
				
			}else{
				
				echo "<tr>";
				echo "<td>".$packet_array[$i]->id."</td>";
				echo "<td>".$packet_array[$i]->arrival."</td>";
				echo "<td>".$packet_array[$i]->departure."</td>";
				echo "<td>".$packet_array[$i]->fromc."</td>";
				echo "<td>".$packet_array[$i]->comment."</td>";
				echo "<td>".$packet_array[$i]->office_id."</td>";
				echo "<td><a href='?delete=".$packet_array[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$packet_array[$i]->id."'>edit</a></td>";
				echo "<td><a href='edit.php?edit_id=".$packet_array[$i]->id."'>edit</a></td>";
				echo "</tr>";
				
			}
		}
	
	?>

<h2>Muuda saadetise andmeid</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<input type="hidden" name="id" value="<?=$_GET["edit_id"];?>">
		<label for ="id">Saadetise id</label><br>
		<input id="id" name="id" type="text" value="<?=$packet_array->id;?>"><br><br>
		<label for ="arrival">Saabumisaeg</label><br>
		<input id="arrival" name="arrival" type="text" value="<?=$packet_array->arrival;?>"> <br><br>
		<label for ="arrival">Väljumisaeg</label><br>
		<input id="departure" name="departure" type="text" value="<?=$packet_array->departure;?>"> <br><br>
		<label for ="fromc">Lähteriik</label><br>
		<input id="fromc" name="fromc" type="text" value="<?=$packet_array->fromc;?>"> <br><br>
		<label for ="comment">Märkus</label><br>
		<input id="comment" name="comment" type="text" value="<?=$packet_array->comment;?>"> <br><br>
		<label for ="office_id">Järgnev kontor</label><br>
		<input id="office_id" name="office_id" type="text" value="<?=$packet_array->office_id;?>"> <br><br>
		<input type="submit" name="update_packet" value="Salvesta"><br>
		</form>	
		
		
		
		
		
		
		
		