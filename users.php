<?php
	$page_title = "Kasutajad";
	$page_file = "users.php";
?>
<?php
	require_once("header.php");
	require_once ("functions.php");


	if(!isset($_SESSION['logged_in_user_id'])) {
		header("Location: register.php");
		exit ();
	}

	if($_SESSION['logged_in_user_group'] != 3) {
		header("Location: noaccess.php");
		exit ();
	}

	$users = $Admin->getUsers();

	if(isset($_SESSION['logged_in_user_id'])) {
		if($_SESSION['logged_in_user_group'] == 3) {
			if(isset($_GET["update"])) {
				$Admin->updateUser($_GET["userid"], $_GET["email"], $_GET["usergroup"]);
			}
		}
	}

?>


<table class="table table-hover table-striped">
	<thead>
		<tr>
			<th>ID</th>
			<th>Email</th>
			<th>Õigused</th>
			<th>CV</th>
			<th>Registreerunud</th>
			<th>Admin</th>
		</tr>
	</thead>
	<tbody>
		<form action="users.php" method="get">
			<?php
				for($i = 0; $i < count($users); $i++) {
					if(isset($_GET["edit"]) && $_GET["edit"] == $users[$i]->id) {
					echo '<tr>
							 <td>'.$users[$i]->id.'</td>
							 <input class="form-control" type="hidden" name="userid" value="'.$users[$i]->id.'">
							 <td><input class="form-control" type="email" name="email" value="'.$users[$i]->email.'"></td>
							 <td><input class="form-control" type="text" name="usergroup" value="'.$users[$i]->usergroup.'"></td>
							 <td>'.$users[$i]->cv.'</td>
							 <td>'.$users[$i]->created.'</td>';

					echo '<td><div class="btn-group" role="group">';
					echo '<button name="update" class="btn btn-success btn-sm" type="submit"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>';
					echo '<a href="users.php" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
					echo '</div></td>';
					echo '</tr>';
					} else {
					echo '<tr>
							 <td>'.$users[$i]->id.'</td>
							 <td>'.$users[$i]->email.'</td>
							 <td>'.$users[$i]->usergroup.'</td>
							 <td>'.$users[$i]->cv.'</td>
							 <td>'.$users[$i]->created.'</td>';
					echo '<td><a href="?edit='.$users[$i]->id.'"><button type="button" class="btn btn-info btn-sm">';
					echo '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Muuda';
					echo '</button></a></td>';
					echo '</tr>';
					}
				}
			?>
		</form>
	</tbody>
</table>




<?php
	require_once("footer.php");
?>
