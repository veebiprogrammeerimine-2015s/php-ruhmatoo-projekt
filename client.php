<?php require_once("header.php"); ?>
<?php require_once("footer.php"); ?>




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
	<input id="comment" name="keyword" type="search" placeholder="Paki kood" value=""><br><br>
	<input type="submit" name="submit"><br>
<form>
<br><br>
<table border="1" class="table">
		<tr>
			<th>Saadetise id</th>
			<th>Saabumisaeg</th>
			<th>Läheriik</th>
			<th>Märkus</th>
			<th>Järgnev kontor</th>
		</tr>
</body>
</html>
	</table>