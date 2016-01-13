<?php
	require_once("header.php");
	require_once("functions.php");

	//data.php
	// siia pääseb ligi sisseloginud kasutaja
	//kui kasutaja ei ole sisseloginud,
	//siis suuunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: page/login.php");
	}

	
	// kas kustutame
	// ?delete=vastav id mida kustutada on aadressi real
	if(isset($_GET["delete"])) {
		
		echo "Kustutame id "  .$_GET["delete"];
		//käivitan funktsiooni, saadan kaasa id!
		deleteReview($_GET["delete"]);
	}
	
	if(isset($_POST["save"])) {
		
		updatePost($_POST["id"],$_POST["post"]);
		
		
	}
	
		//käivitan funktsiooni
		$array_of_posts = getPostData();

?>

<div>
<br>
<p><a href="data.php" class="btn btn-primary" role="button">Tagasi teemade lehele</a></p>



<h2>Postitused Eesti jalgpallist</h2>










<body style="background-color:#0074D9">
<h2 style=color:#F8F8FF>Arvustused</h2>
<a href="mingiteema.php"><h2 style="text-align:right;color:#F8F8FF">Loo ise arvustus</h2></a>

<style>

.CSSTableGenerator {
	margin:0px;padding:0px;
	width:100%;
	box-shadow: 10px 10px 5px #888888;
	border:1px solid #ffffff;
	
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
	
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
	
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
	
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}.CSSTableGenerator table{
    border-collapse: collapse;
        border-spacing: 0;
	width:100%;
	height:100%;
	margin:0px;padding:0px;
}.CSSTableGenerator tr:last-child td:last-child {
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
}
.CSSTableGenerator table tr:first-child td:first-child {
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}
.CSSTableGenerator table tr:first-child td:last-child {
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
}.CSSTableGenerator tr:last-child td:first-child{
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
}.CSSTableGenerator tr:hover td{
	background-color:#d3e9ff;
		

}
.CSSTableGenerator td{
	vertical-align:middle;
	
	background-color:#aad4ff;

	border:1px solid #ffffff;
	border-width:0px 1px 1px 0px;
	text-align:left;
	padding:7px;
	font-size:10px;
	font-family:Arial;
	font-weight:normal;
	color:#000000;
}.CSSTableGenerator tr:last-child td{
	border-width:0px 1px 0px 0px;
}.CSSTableGenerator tr td:last-child{
	border-width:0px 0px 1px 0px;
}.CSSTableGenerator tr:last-child td:last-child{
	border-width:0px 0px 0px 0px;
}
.CSSTableGenerator tr:first-child td{
		background:-o-linear-gradient(bottom, #0057af 5%, #0057af 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #0057af), color-stop(1, #0057af) );
	background:-moz-linear-gradient( center top, #0057af 5%, #0057af 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#0057af", endColorstr="#0057af");	background: -o-linear-gradient(top,#0057af,0057af);

	background-color:#0057af;
	border:0px solid #ffffff;
	text-align:center;
	border-width:0px 0px 1px 1px;
	font-size:14px;
	font-family:Arial;
	font-weight:bold;
	color:#ffffff;
}
.CSSTableGenerator tr:first-child:hover td{
	background:-o-linear-gradient(bottom, #0057af 5%, #0057af 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #0057af), color-stop(1, #0057af) );
	background:-moz-linear-gradient( center top, #0057af 5%, #0057af 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#0057af", endColorstr="#0057af");	background: -o-linear-gradient(top,#0057af,0057af);

	background-color:#0057af;
}
.CSSTableGenerator tr:first-child td:first-child{
	border-width:0px 0px 1px 0px;
}
.CSSTableGenerator tr:first-child td:last-child{
	border-width:0px 0px 1px 1px;
}


</style>

<div class="csstablegenerator">
<table border=1>
	<tr>
		<th>ID</th>
		<th>USER ID</th>
		<th>USER EMAIL</th>
		<th>Kuupäev</th>
		<th>Postitus</th>
		<th>Kustuta</th>
		<th>Muuda</th>
		

	</tr>
	
<?php
		
		for($i=0; $i<count($array_of_posts);$i++) {
				
					

			echo "<tr>";
			echo "<td>".$array_of_posts[$i]->id."</td>";
			echo "<td>".$array_of_posts[$i]->user_id."</td>";
			echo "<td>".$array_of_posts[$i]->user_email."</td>";
			echo "<td>".$array_of_posts[$i]->timestamp."</td>";
			echo "<td>".$array_of_posts[$i]->post."</td>";
			if($_SESSION["logged_in_user_id"] == $array_of_posts[$i]->user_id){
							echo "<td><a href='?delete=".$array_of_posts[$i]->id."'>X</a></td>";
							echo "<td><a href='edit.php?edit_id=".$array_of_posts[$i]->id."'>Muutmine</a></td>";
						}
			
		
			echo "</tr>";
			
			
			
		}
	
	
?>
</div>


	





