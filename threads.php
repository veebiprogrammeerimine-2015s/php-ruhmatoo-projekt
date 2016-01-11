<?php	

	require_once("user.class.php");
	$page_title = "Threads";
	$page_file_name = "threads.php";
	require_once("header.php");
	
		if(isset($_POST["save"])){
		
		updateThread($_POST["id"], $_POST["thread"], $_POST["post"]);
	}

		$forum = "";
	
	//aadressireal on keyword
	if(isset($_GET["thread"])){
		
		//otsin
		$thread= $_GET["thread"];
		$array_of_threads = getThreadData($thread);
		
	}else{
		
		//küsin kõik andmed
		
		//käivitan funktsiooni
		$array_of_threads = getThreadData();
	}

?>

<h2>Threads</h2>

<form action="table.php" method="get" >
	<input type="search" name="thread" placeholder="find post" value="<?=$thread;?>" >
	<input type="submit" >
</form>

<table border=1 >
	<tr>
		<th>Title</th>
	</tr>
	
	<?php
		// Trükime välja read
		// massiivi pikkus count()
		for($i = 0; $i < count($array_of_threads); $i++){
								
				echo "<tr>";
				echo "<td>".$array_of_threads[$i]->teema."</td>";
				echo "</tr>";

			}
			
	
	?>

</table>

<?php require_once("footer.php"); ?>