<?php
	//Lehe nimi
	$page_title = "Muuda ettevõtteid";
	//Faili nimi
	$page_file = "companies.php";
?>
<?php
	require_once("../header.php");
	require_once ("../inc/functions.php");

	if(!isset($_SESSION['logged_in_user_id'])) {
		header("Location: register.php");
		exit ();
	}

	if($_SESSION['logged_in_user_group'] != 3) {
		header("Location: noaccess.php");
		exit ();
	}



	$companies = $Admin->getCompanies();

	if(isset($_SESSION['logged_in_user_id'])) {
		if($_SESSION['logged_in_user_group'] == 3) {
			if(isset($_GET["update"])) {
				$Admin->updateCompany($_GET["company"], $_GET["email"], $_GET["number"], $_GET["oldcompany"]);
			}
		}
	}

?>
<table class="table table-hover table-striped">
<thead>
	<tr>
		<th>Kasutaja</th>
		<th>Nimi</th>
		<th>Email</th>
		<th>Number</th>
		<th>Admin</th>
	</tr>
</thead>
<tbody>
<form action="companies.php" method="get">
	<?php
		for($i = 0; $i < count($companies); $i++) {
			if(isset($_GET["edit"]) && $_GET["edit"] == $companies[$i]->company) {
			echo '<tr>
					 <td>'.$companies[$i]->user.'</td>
					 <input class="form-control" type="hidden" name="oldcompany" value="'.$companies[$i]->company.'">
					 <td><input class="form-control" type="text" name="company" value="'.$companies[$i]->company.'"></td>
					 <td><input class="form-control" type="email" name="email" value="'.$companies[$i]->email.'"></td>
					 <td><input class="form-control" type="text" name="number" value="'.$companies[$i]->number.'"></td>';
			echo '<td><div class="btn-group" role="group">';
			echo '<button name="update" class="btn btn-success btn-sm" type="submit"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>';
			echo '<a href="companies.php" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
			echo '</div></td>';
			echo '</tr>';
			} else {
			echo '<tr>
					 <td>'.$companies[$i]->user.'</td>
					 <td>'.$companies[$i]->company.'</td>
					 <td>'.$companies[$i]->email.'</td>
					 <td>'.$companies[$i]->number.'</td>';
			echo '<td><a href="?edit='.$companies[$i]->company.'"><button type="button" class="btn btn-info btn-sm">';
			echo '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Muuda';
			echo '</button></a></td>';
			echo '</tr>';
			}
		}
	?>
</form>
 </tbody>
 </table>

<?php require_once("../footer.php"); ?>
