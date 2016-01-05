<?php require_once("functions.php"); 

require_once("../classes/Confirm.class.php");
	
require_once("../classes/InterestManager.class.php");	

$InterestManager = new InterestManager($mysqli, $_GET["id"]);
	
	$Confirm = new Confirm($mysqli);
	$contest_array = $Confirm->getAllData();
?>



// küsid kasutaja andmed kus id on selline

// kus võistlustel osalenud

// näitad tema huvialad

<h1> </h1>
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
        
		if($contest_array[$i]->user_id == $_GET["id"]){
        //kasutaja tahab rida muuta
            //lihtne vaade
            echo "<tr>";
            echo "<td>".$contest_array[$i]->user."</td>";
            echo "<td>".$contest_array[$i]->contest_name."</td>";
            echo "<td>".$contest_array[$i]->result."</td>";
			echo "<td>".$contest_array[$i]->grade."</td>";
            echo "<td>".$contest_array[$i]->run_comment."</td>";
            echo "</tr>";
            
        }
        
    }
    
?>

</table>



<?=$InterestManager->getUserInterests();?>

