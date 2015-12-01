<?php
	require_once(__DIR__."/../functions/functions.php");
	require_once(__DIR__."/../classes/userpage.class.php");
	$page_title = "Admin kasutaja";
	$page_file_name = "userpageadmin.php";
	if(isset($_GET["logout"])){
        session_destroy();
        header("Location:".__DIR__."/../index.php");
    }
	$getAllUsers = new getAllUsers($connection);
	$deleteUsers = new deleteUsers($connection);
	$updateUsers = new updateUsers($connection);

	$users_array = $getAllUsers->getAllUsers();
	if(isset($_GET["delete"])) {
		$response = $deleteUsers->deleteUsers($_GET["delete"]);
	}

	if(isset($_GET["update"])){
		$response = $updateUsers->updateUsers($_GET['first_name'], $_GET['last_name'], $_GET['address'], $_GET['creation_date'], $_GET['privileges'], $_GET['user_id']);
	}
		
	$keyword = "";
	if(isset($_GET["keyword"])){
		$keyword = $_GET["keyword"];
		$users_array = $getAllUsers->getAllUsers($keyword);
	}else{
		$users_array = $getAllUsers->getAllUsers();
	}
?>

<?php require_once(__DIR__."/../header.php"); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-9">
			<table class="table table-hover">
				<tr>
					<th>Kasutaja ID</th>
					<th>Kasutajanimi</th>
					<th>Eesnimi</th>
					<th>Perekonnanimi</th>
					<th>Aadress</th>
					<th>Kasutaja loomise kuupäev</th>
					<th>Õigused</th>
					<th>Muuda</th>
					<th>Kustuta</th>
				</tr>
				<?php 
				for($i = 0; $i < count($users_array); $i++){
					if(isset($_GET["edit"]) && $_GET["edit"] == $users_array[$i]->id) {
						echo "<tr>";
						echo '<form action="/pages/userpageadmin.php" method="get">';
						echo "<input type='hidden' name='user_id' value='".$users_array[$i]->id."'>";
						echo "<td>".$users_array[$i]->id."</td> ";
						echo "<td><input class='form-control' name='username' value='".$users_array[$i]->username."'></td>";
						echo "<td><input class='form-control' name='first_name' value='".$users_array[$i]->first_name."'></td>";
						echo "<td><input class='form-control' name='last_name' value='".$users_array[$i]->last_name."'></td>";
						echo "<td><input class='form-control' name='address' value='".$users_array[$i]->address."'></td>";
						echo "<td><input class='form-control' name='creation_date' value='".$users_array[$i]->creation_date."'></td>";
						echo "<td><input class='form-control' name='privileges' value='".$users_array[$i]->privileges."'></td>";
						echo "<td><input class='btn btn-default btn-block' name='update' type='submit' value='Uuenda'></td>";
						echo "<td><a class='btn btn-default btn-block' href='/pages/userpageadmin.php'>Katkesta</a></td>";
						echo "</tr>";
						echo "</form>";
					} else {
						echo "<tr> <td>".$users_array[$i]->id."</td> ";
						echo "<td>".$users_array[$i]->username."</td>"; 
						echo "<td>".$users_array[$i]->first_name."</td>"; 
						echo "<td>".$users_array[$i]->last_name."</td>"; 
						echo "<td>".$users_array[$i]->address."</td> ";
						echo "<td>".$users_array[$i]->creation_date."</td>"; 
						echo "<td>".$users_array[$i]->privileges."</td>"; 
						echo '<td><a class="btn btn-info btn-block" href="/pages/userpageadmin.php?edit='.$users_array[$i]->id.'">Muuda</a></td>';
						echo '<td><a class="btn btn-info btn-block" href="/pages/userpageadmin.php?delete='.$users_array[$i]->id.'">Kustuta</a></td></tr>';
						
					}
				}
				?>
			</table>
		</div>	
		<div class="col-sm-2">
			<label class="text"> Otsi kasutajat </label>
				<form action="/pages/userpageadmin.php" method="get">
				<input class="form-control" name="keyword" type="search" value="<?=$keyword?>" ><br>
				<input type="submit" value="otsi" class="btn btn-info btn-block">
			</form>
		</div>	
	</div>
</div>
<?php require_once(__DIR__."/../footer.php"); ?>