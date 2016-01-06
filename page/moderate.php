<?php
	$page_title = "Kommentaaride modereerimine";
	$page_file_name = "moderate.php";
	require_once("../header.php");
	require_once("../functions.php");
?>
<Title><?php echo $page_title?></title>

<?php

if(isset($_GET["delete"])) {
		deleteComment($_GET["delete"]);
	}

$keyword = "";
	if(isset($_GET["keyword"])){
		$keyword = $_GET["keyword"];
		
		$procomments_array = getAllData($keyword);
		
	}else{
		$procomments_array = getAllData();
	}
?>
<h1>Kommentaarid</h1>
	<form action="table.php" method="get">
		<input name="keyword" type="search" value="<?=$keyword?>">
		<input type="submit" value="otsi">
	<form>
	<br><br>
	<table border=1>
	<tr>
	<th>Kommentaari id</th>
	<th>Proffessori id</th>
    <th>Kasutaja id</th>
    <th>Kommentaari aeg</th>
    <th>Kommentaar</th>
	<th>Kontrollitud</th>
	</tr>
<?php

	for($i = 0; $i < count($procomments_array); $i++){
		
	
			echo "<tr>";
            echo "<form action='table.php' method='get'>";

            // input mida välja ei näidata

            echo "<input type='hidden' name='id' value='".$procomments_array[$i]->id."'>";
            echo "<td>".$procomments_array[$i]->id."</td>";
            echo "<td>".$procomments_array[$i]->pro_id."</td>";
			echo "<td>".$procomments_array[$i]->user_id."</td>";
            echo "<td>".$procomments_array[$i]->inserted."</td>";
            echo "<td>".$procomments_array[$i]->comment."</td>";
			echo "<td><input name='confirm' value='".$procomments_array[$i]->accepted."' ></td>";
            echo "<td><input name='update' type='submit'></td>";
            echo "<td><a href='?delete=".$procomments_array[$i]->id."'>DELETE</a></td>";
            echo "</form>";
            echo "</tr>";
		 
			
			
			
		
		
			
            
			}
			
            
            echo "</tr>";
		
	
	
?>
</table>
<?php
	
	require_once("../footer.php");
?>