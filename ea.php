<?php
//annan vaikeväärtuse
	function getInfo($keyword=""){
		
		$search="%%";
		
		//kas otsisõna on tühi
		if($keyword==""){
			//ei otsi midagi
			//echo "Ei otsi";
			
		}else{
			//otsin
			echo "Otsin " .$keyword;
			$search="%".$keyword."%";
			// "linex"
			// "%linex%"
			
		}
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id FROM post_import WHERE deleted IS NULL AND (medicine LIKE ?)");
		//echo $mysqli->error; //Unknown column 'deleted' in 'where clause' ??? - lahendatud
		$stmt->bind_param("s", $search);
		$stmt->bind_result($id, $);
		$stmt->execute();
		
		//tekitan tühja massiivi, kus edaspidi hoian objekte
		$review_array = array ();
		
		//tee midagi seni, kuni saame andmebaasist ühe rea andmeid
		while($stmt->fetch()){
			//seda siin sees tehakse nii mitu korda kui on ridu
			
			//tekitan objekti, kus hakkan hoidma väärtusi
			$review = new StdClass();
			$review->id = $id;
			$review->medicine =$medicine;
			$review->user_id=$user_id;
			$review->rating=$rating;
			$review->comment=$comment;
			//lisan massiivi ühe rea juurde
			
			array_push($review_array, $review);
			//var dump ütleb muutuja tüübi ja sisu
			//echo "<pre>";
			//var_dump($car_array);
			//echo "</pre><br>";
			
		}
		//tagastan massiivi, kus kõik read sees
		return $review_array;
		
		$stmt->close();
		$mysqli->close();
		
	}

?>

<html lang="et">
<head>
<meta charset="utf-8">
<title> Posti otsimine </title>
<base target="_blank">
</head>
<body>
<h1> Saadetise otsimine </h1>
<form action="">
  Sisestage saadetise id: <input type="text" name="id" placeholder="Sisesta id">&nbsp;
  <input type="submit" value="Otsi">
</form>
<br>
Otsingule leitud vasted:
<table border="1">
	<tr>
		<th>Saadetise id</th>
		<th>Asukoht</th>
		<th>Saabumine</th>
		<th>Väljumine</th>
		
	</tr>

<table border="1">
<br>
	<tr>
		<th>Saadetise id</th>
		<th>Asukoht</th>
		<th>Saabumine</th>
		<th>Väljumine</th>
	</tr>
</body>
</html>
