<?php require_once("page/header.php"); ?>
<?php require_once("user.class.php");	?>
<?php	require_once("page/functions.php");	?>
<?php
	$keyword = "";
	if(isset($_GET["keyword"])){
		$keyword = $_GET["keyword"];
		//echo $keyword;
		$array_of_results = $user->getSearchData($keyword);
	}

?>


<br><br>

<div class="container">

	<div class="row">
		<div class="col-sm-6 col-sm-pull-3">
			<div class="jumbotron">
				<div class="container">
					<h2>Teade</h2>
					<p>
					<a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
					Loe teadet
					</a></p>
						<div class="collapse" id="collapseExample">
							<div class="well">
							Pikem tekst teate kohta kui nupule vajutada
							</div>
						</div>
				</div>
			</div>
		</div>

	</div>

</div>
<html>
<body>

		<form action="main.php" method="get" >
			<input type="search" name="keyword" value="<?=$keyword;?>" >
			<input type="submit" value="Search">
		</form>
	<table border="1"></td>
		<tr>
			<!--<th>id</th>-->
			<th>Name</th>
			<th>Category</th>
			<th>Year</th>
			<th>Director</th>
		</tr>
		<?php
		if(isset($_GET["keyword"])){
			for($i = 0; $i < count($array_of_results); $i++){
					echo "<tr>";
					echo "<td>".$array_of_results[$i]->name."</td>";
					echo "<td>".$array_of_results[$i]->category."</td>";
					echo "<td>".$array_of_results[$i]->year."</td>";
					echo "<td>".$array_of_results[$i]->director."</td>";
					echo "</tr>";
			}
		}
		?>
	</table>
</html>
</body>



<?php require_once("page/footer.php"); ?>
