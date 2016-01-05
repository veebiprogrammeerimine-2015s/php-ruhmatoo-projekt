
<?php 

    require_once("functions.php");
    require_once("../classes/Table.class.php");
    
    $Table = new Table($mysqli);
    
    if(!isset($_SESSION['logged_in_user_id'])){
        header("Location: login.php");
    }
    //kuulan, kas kasutaja tahab kustutada
    if(isset($_GET["delete"])){
        $Table->deleteContestData($_GET["delete"]);
    }

    
    //kasutaja muudab andmeid
    if(isset($_GET["update"])){
        $Table->updateContestData($_GET["contest_id"], $_GET["contest_name"], $_GET["name"]);
    }
    $contest_array = getAllData();
    
    $keyword = "";
	
    if(isset($_GET["keyword"])){
        $keyword = $_GET["keyword"];
        //otsime
        $contest_array = getAllData($keyword);
    }else{
        //näitame kõik tulemused
        $contest_array = getAllData();
    }
	
	if(isset($_GET["confirm"])){
        header("Location: confirm.php");
    }
?>

<?php 
    // lehe nimi
    $page_title = "Osalejad";

?>

<?php
    require_once("../header.php");
?>

<div class="container">

<br>
	<p>Siin ilmuvad tabeli kujul kõik eelregistreerunud.</p>
<br>
	<h1>Osalejad</h1>
	<form action="table.php" method="get">
		<input name="keyword" type="search" value="<?=$keyword?>">
		<input type="submit" value="Otsi"><br><br>
	</form>
	<table border=1>
	<tr>
		<th>id</th>
		<th>Kasutaja id</th>
		<th>Võistlus</th>
		<th>Osaleja nimi/klubi</th>
		<th>Kustuta</th>
		<th>Muuda</th>
		<th>Kinnita osalus</th>
	</tr>
</div>

<?php
    //osalejad ükshaaval läbi käia
    for($i = 0; $i < count($contest_array); $i++){
        
        //kasutaja tahab rida muuta
        if(isset($_GET["edit"]) && $_GET["edit"] == $contest_array[$i]->id){
            echo "<tr>";
            echo "<form action='table.php' method='get'>";
            // input mida välja ei näidata
            echo "<input type='hidden' name='contest_id' value='".$contest_array[$i]->id."'>";
            echo "<td>".$contest_array[$i]->id."</td>";
            echo "<td>".$contest_array[$i]->user_id."</td>";
            echo "<td><input name='contest_name' value='".$contest_array[$i]->contest_name."'></td>";
            echo "<td><input name='name' value='".$contest_array[$i]->name."'></td>";       
            echo "<td><a href='?table.php=".$contest_array[$i]->id."'>Katkesta</a></td>";
            echo "<td><input name='update' type='submit'></td>";
            echo "</form>";
            echo "</tr>";
        }else{
            //lihtne vaade
            echo "<tr>";
			
            echo "<td>".$contest_array[$i]->id."</td>";
            echo "<td>".$contest_array[$i]->user_id."</td>";
            echo "<td>".$contest_array[$i]->contest_name."</td>";
            echo "<td><a href='user.php?id=".$contest_array[$i]->user_id."'>".$contest_array[$i]->name."</a></td>";
			if($contest_array[$i]->user_id == $_SESSION['logged_in_user_id']){
				echo "<td><a href='?delete=".$contest_array[$i]->id."'>X</a></td>";
				echo "<td><a href='?edit=".$contest_array[$i]->id."'>Muuda</a></td>";
				
				echo "<td><a href='confirm.php?edit=".$contest_array[$i]->id."&user_id=".$contest_array[$i]->user_id."'>Kinnita</a></td>";
			}
            echo "</tr>";
            
        }
        
        
    }
    
?>

</table>

<?php require_once("../footer.php"); ?> 

