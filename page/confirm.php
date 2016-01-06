
<?php
	require_once("functions.php");
	require_once("../classes/Confirm.class.php");
	
	if(!isset($_SESSION['logged_in_user_id'])){
    header("Location: login.php");
    }
	
	if(isset($_GET["logout"])){
	//kustutame sessiooni muutujad
	session_destroy();
	header("Location: login.php");
    }
	
	$Confirm = new Confirm($mysqli);
	//$array = getAllData();
	
	if(isset($_GET["edit"])) {
			
		$Confirm->saveNewEntry($_GET["edit"],$_SESSION['logged_in_user_id']);
		
		//$contest_array = $Confirm->getAllData($_GET["user_id"]);
		//var_dump($contest_array);
		
	}
	$contest_array = $Confirm->getAllData();
	
	if(isset($_GET["update"])){
		$Confirm->updateConfirmData($_GET["confirm_id"], $_GET["result"], $_GET["grade"], $_GET["run_comment"]);
		
		header("Location: confirm.php");
		exit();
	}

?>

<?php 
    // lehe nimi
    $page_title = "Tulemused ja kommentaarid";

?>

<?php
    require_once("../header.php");
?>

<div class="container">
	<div class="row">
		<div class="col-lg-12">
	
			<br><br>
			<p>Siin saab kirja panna võistluste tulemused ja lisada kommentaare võistluse kohta.</p>


			<h1>Tulemused ja kommentaarid</h1>
			<form action="confirm.php" method="get">
				
			</form>
			<table class="table table-condensed">

			<tr>
				
				<th>Osaleja nimi</th>
				<th>Võistlus</th>
				<th>Tulemus</th>
				<th>Hinda võistlust</th>
				<th>Kommentaarid</th>
			</tr>
		</div>
	</div>
</div>
	
	
<?php
    //osalejad ükshaaval läbi käia
    for($i = 0; $i < count($contest_array); $i++){ //SIIN ON MIDAGI VALESTI? 
	//tabelis ainult esimesel viskab selle rea ette kinnituslehel
        //if($contest_array[$i]->user_id == aadressieal){
        //kasutaja tahab rida muuta
        if(isset($_GET["edit_confirm"]) && $_GET["edit_confirm"] == $contest_array[$i]->id){
            echo "<tr>";
            echo "<form action='confirm.php' method='get'>";
            
            echo "<td>".$contest_array[$i]->user."</td>";
            echo "<td>".$contest_array[$i]->contest_name."</td>";
			echo "<input type='hidden' name='confirm_id' value='".$contest_array[$i]->id."' type='text'>";
			echo "<td><input name='result' type='text' value='".$contest_array[$i]->result."'></td>";
			echo "<td><input name='grade' type='text' value='".$contest_array[$i]->grade."'></td>";
			echo "<td><input name='run_comment' type='text' value='".$contest_array[$i]->run_comment."'></td>";
            echo "<td><input name='update' type='submit'></td>";
            echo "</form>";
            echo "</tr>";
        }else{
            //lihtne vaade
            echo "<tr>";
            echo "<td>".$contest_array[$i]->user."</td>";
            echo "<td>".$contest_array[$i]->contest_name."</td>";
            echo "<td>".$contest_array[$i]->result."</td>";
			echo "<td>".$contest_array[$i]->grade."</td>";
            echo "<td>".$contest_array[$i]->run_comment."</td>";
            
			if($contest_array[$i]->user_id == $_SESSION['logged_in_user_id']){
            echo "<td><a href='?delete=".$contest_array[$i]->id."'>X</a></td>";
            echo "<td><a href='?edit_confirm=".$contest_array[$i]->id."'>Muuda</a></td>";
            }
            echo "</tr>";
            
        }
        
    }
    
?>

</table>

<?php require_once("../footer.php"); ?> 