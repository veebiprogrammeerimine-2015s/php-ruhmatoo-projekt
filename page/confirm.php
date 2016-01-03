<?php
	require_once("functions.php");
	require_once("../classes/Confirm.class.php");
	
	$Confirm = new Confirm($mysqli);
	$array = getAllData();
	
	if(isset($_GET["confirm"])) {
			
		$Confirm->saveNewEntry($_GET["confirm"],$_GET["user_id"]);
		
		$contest_array = $Confirm->getAllData($_GET["confirm"],$_GET["user_id"]);
		var_dump($contest_array);
		
	}else{
		// küsid kõigi andmed
	
		$contest_array = getAllData();
		//$Confirm->getAllDataFromAll();
	}
	

?>
<a href="data.php">Tagasi registreerimislehele!</a><br>
<a href="table.php">Tagasi tabeli juurde!</a><br>

<h1>Tulemused ja kommentaarid</h1>
<form action="confirm.php" method="get">
    
</form>
<table border=1>

<tr>
    
    <th>Osaleja nimi</th>
    <th>Võistlus</th>
    <th>Tulemus</th>
    <th>Hinda võistlust</th>
    <th>Kommentaarid</th>
</tr>

<?php
    //osalejad ükshaaval läbi käia
    for($i = 0; $i < count($contest_array); $i++){ //SIIN ON MIDAGI VALESTI? 
	//tabelis ainult esimesel viskab selle rea ette kinnituslehel
        
        //kasutaja tahab rida muuta
        if(isset($_GET["edit"]) && $_GET["edit"] == $contest_array[$i]->id){
            echo "<tr>";
            echo "<form action='table.php' method='get'>";
            
            echo "<td>".$contest_array[$i]->contest_name."</td>";
            echo "<td>".$contest_array[$i]->name."</td>";
			echo "<td><input type='text'></td>";
			echo "<td><input type='text'></td>";
			echo "<td><input type='text'></td>";
            echo "<td><input name='update' type='submit'></td>";
            echo "</form>";
            echo "</tr>";
        }else{
            //lihtne vaade
            echo "<tr>";
            echo "<td>".$contest_array[$i]->contest_name."</td>";
            echo "<td>".$contest_array[$i]->name."</td>";
			echo "<td><input type='text'></td>";
			echo "<td><input type='text'></td>";
			echo "<td><input type='text'></td>";
            echo "<td><a href='?delete=".$contest_array[$i]->id."'>X</a></td>";
            echo "<td><a href='?edit=".$contest_array[$i]->id."'>Muuda</a></td>";
            
            echo "</tr>";
            
        }
        
    }
    
?>

</table>