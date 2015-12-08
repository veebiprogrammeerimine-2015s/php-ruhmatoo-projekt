<?php
	if(isset($_POST["search_packet"])){
		getPacketData($_POST["id"], $_POST["arrival"], $_POST["departure"], $_POST["fromc"], $_POST["comment"], $_POST["office_id"]);
	}
	function getPacketData($keyword=""){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT packet_id, arrival, departure, fromc, comment, offices.office FROM post_import join offices on post_import.office_id=offices.office_id WHERE deleted IS NULL AND (packet_id LIKE ? OR arrival LIKE ? OR departure LIKE ? OR fromc LIKE ? OR comment LIKE ? OR offices.office LIKE ?)");
		echo $mysqli->error;
		$stmt->bind_param("issssi", $search, $search, $search, $search, $search, $search);
		$stmt->bind_result($id, $arrival, $departure, $fromc, $comment, $office_id);
		$stmt->execute();
		$packet_array = array();
		while($stmt->fetch()){
			$packet = new StdClass();
			$packet->id = $id;
			$packet->arrival = $arrival;
			$packet->departure = $departure;
			$packet->fromc = $fromc;
			$packet->comment = $comment;
			$packet->office_id = $office_id;
			array_push($packet_array, $packet);
			
		}
		$stmt->close();
		return $packet_array;
	
	}
?>


<html>
<head>
<meta charset="utf-8">
<title> Saadetise otsing </title>
</head>
<body>
<h1>Saadetise otsing</h1>
<p>Tere tulemast Teamalpha postilehele. <br>
Sel lehel saad jägida oma saadetise teekonda. Lisaküsimuste korral kirjutage .. <p>
<form action="klient.php" method="get">
	<label for ="id">Sisesta otsitava paki id:</label><br>
	<input id="comment" name="comment" type="text" placeholder="Paki kood"><br><br>
	<input type="submit" name="search_packet" value="Otsi"><br>
<form>
<br><br>
<table border="1">
		<tr>
			<th>Saadetise id</th>
			<th>Saabumisaeg</th>
			<th>Lähteriik</th>
			<th>Märkus</th>
			<th>Järgnev kontor</th>
		</tr>
		
</body>
</html>