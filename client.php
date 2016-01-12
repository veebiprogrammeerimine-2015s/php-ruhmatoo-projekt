<?php
	require_once("../config_global.php");
	$database = "if15_teamalpha_3";
	
	require_once("functions.php");
	require_once("client.class.php");
	require_once("header.php");
	require_once("footer.php");
	
	$Client = new Client($mysqli);
	
	$packet_id= "";
	$packet_id_error = "";
	$nonexist_packet_id = "";
	
	//$getvar = key($_GET);
	//$getvar1 = key($_POST);
	
	
	
	/*if(isset($_GET["submit"])){
		if($_POST["$packet_id"] != $_POST["$packet_id_from_db"]){
			$nonexistant_packet_id = "Sellist numbrikoodiga saadetist meil ei ole. Palun proovi uuesti";
		}
		
		/*else{
				$packet_id = cleanInput($_POST["$packet_id= $packet_array->id"]);
				}

			
			/*if (!in_array($_POST["packet_id"], $packet_id_array)) {
			$nonexist_packet_id = "Sellise numbrikoodiga saadetist meie andmebaasis ei ole. Palun proovi uuesti";
				echo $nonexist_packet_id;*/
		
			//if ($_POST["$packet_id= $packet_array->id"] != $_POST["$packet_id_from_db"]) {
			//$nonexist_packet_id = "Sellise numbrikoodiga saadetist meie andmebaasis ei ole. Palun proovi uuesti";
			//	echo $nonexist_packet_id;
		

	
	$keyword ="";

	if(isset($_GET["keyword"])){
		
		$keyword= $_GET["keyword"];
		$packet_array = $Client->getPacketData($keyword);
		
	}else{

		$packet_array = $Client->getPacketData();
	}
	
	if(isset($_GET["submit"])){
		
		if(empty($_GET["keyword"])){
			$packet_id_error = "Palun sisestage paki kood!";
		}
		
	}
	/*if(isset($_GET["submit"])){
		if(print_r(!empty($packet_array[0]))){
			echo "Sellist pakki pole";
		}
	}*/
	
	function cleanInput($data) {	
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
	}
	//echo $getvar;
	//echo $getvar1;
	/*var_dump ($packet_array);*/
	//print_r ($packet_array[0]);
	
?>


<html>
<head>
<meta charset="utf-8">
<title> Saadetise otsing </title>
</head>
<body>
<h1>Saadetise otsing</h1>
<p>Tere tulemast Teamalpha postilehele. <br>
Sel lehel saad jälgida oma saadetise teekonda. Lisaküsimuste korral kirjutage info@post.ee või helistage +372 5550 1002 <p>
<form action="client.php" method="get">
	<label for ="packet_id">Sisesta otsitava paki id:</label><br>
	<input id="comment" name="keyword" type="search" placeholder="Paki kood" value="<?=$keyword;?>"> <?=$packet_id_error;?><br><br>
	<input type="submit" name="submit"><br>
</form>
<br><br>
<?php echo $packet_id;?>
<table border="1" class="table">
		<tr>
			<th>Saadetise id</th>
			<th>Saabumisaeg</th>
			<th>Läheriik</th>
			<th>Märkus</th>
			<th>Järgnev kontor</th>
		</tr>

	<?php
		for($i = 0; $i < count($packet_array); $i=$i+1){
			echo "<tr>";
			echo "<td>".$packet_array[$i]->id."</td>";
			echo "<td>".$packet_array[$i]->arrival."</td>";
			echo "<td>".$packet_array[$i]->fromc."</td>";
			echo "<td>".$packet_array[$i]->comment."</td>";
			echo "<td>".$packet_array[$i]->office_id."</td>";
			echo "</tr>";
			
		}
		
	?>
</table>
</body>
</html>