<?php
	require_once("../functions.php");
	require_once("../classes/Series.class.php");
	//data
	//siia pääseb ligi sisseloginud kasutaja
	//kui kasutaja on sisse loginud
	//siis suunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	$Series = new Series($mysqli, $_SESSION["logged_in_user_id"]);
	
	//kasutaja tahab välja logida
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kusutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	
	$title = $season = $description = $picture = "";
	$title_error = $season_error = $description_error = $picture_error = "";
	
	
	if(isset($_POST["addSeries"])){
		echo "vajutati nuppu";
		if ( empty($_POST["title"]) ) {
				$title_error = "See väli on kohustuslik";
			}else{
				$title = cleanInput($_POST["title"]);
			}

			if ( empty($_POST["season"]) ) {
				$season_error = "See väli on kohustuslik";
			} else {
				
				$season = cleanInput($_POST["season"]);
				
			}
			if ( empty($_POST["description"]) ) {
				$description_error = "See väli on kohustuslik";
			} else {
				
				$description = cleanInput($_POST["description"]);
				
			}
			if ( empty($_POST["picture"]) ) {
				$picture_error = "See väli on kohustuslik";
			} else {
				
				$picture = cleanInput($_POST["picture"]);
				
			}
		if(	$title_error == "" && $season_error == "" && $description_error == "" && $picture_error == ""){
			
			echo "Sisestatud!";
				
				
				$add_response = $Series->addSeries($title, $season, $description, $picture);
				
		}
	}
	
	if(isset($_POST["createList"])){
		if ( empty($_POST["name"]) ) {
					$name_error = "Field is empty";
				}else{
					$name = cleanInput($_POST["name"]);
				}
		if($name_error == ""){
			
			echo "List created";
			
			$add_list_response = $Series->createList($name);
		}
	}
	function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
	
	
	
?>
<?php require_once("../header.php"); ?>
<div class="container">
	<div class="row">

			
		<p>
			Tere, <?=$_SESSION["name"];?>
			<a href="?logout=1">Logi välja</a>
		</p>
<?php var_dump($add_response);?>
<?php var_dump($add_list_response);?>

		<h2>Add new series</h2>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
			<label for="title" >Name</label><br>
			<div class="form-group">
				<input name="title" id="title" type="text"  value="<?php echo $title; ?>"> <?php echo $title_error; ?><br><br>
			</div>
			<div class="form-group">
				<label for="season" >Season</label><br>
				<input name="season" type="text"  value="<?php echo $season; ?>"> <?php echo $season_error; ?><br><br>
			</div>
			<div class="form-group">
				<label for="description" >Description</label><br>
				<textarea name="description" rows="10" cols="100"><?php echo $description; ?></textarea> <?php echo $description_error; ?><br><br>
			</div>
			<div class="form-group">
				<label for="picture" >Add series cover</label><br>
				<input name="picture" type="text" placeholder="Photo URL"  value="<?php echo $picture; ?>"> <?php echo $picture_error; ?><br><br>	
			</div>
			<input type="submit" name="addSeries" value="Submit" class="btn btn-success">
		  </form>
	</div>
</div>

<form method="post">
    <input name="name" type="text">
    <input type="submit" name="createList" value="Submit">
</form>
<?php
function dropdown(){
		
		$html = "";
		
		$html .= '<select name="new_dd_selection">';
		//$html .= '<option>1</option>';
		//$html .= '<option>2</option>';
		//$html .= '<option>3</option>';
		//$html .= '<option selected>3</option>';
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, name FROM user_list where user_id=?");
		
		$stmt->bind_param("i", $_SESSION["logged_in_user_id"]);
		$stmt->bind_result($id, $name);
		$stmt->execute();
		
		while($stmt->fetch()){
			$html .= '<option value="'.$id.'">'.$name.'</option>';
			
		}
		
		
		$html .= '</select>';
		
		return $html;
		
	}

?>

<a href="?add=1">Lisa</a>
<?php if(isset($_GET["add"])){ ?>
<form method="post">
    <input type="hidden" name="add" value="<?=$_GET["add"];?>" type="text">
	<?php echo dropdown(); ?>
    <input type="submit" name="createList" value="Submit">
</form>
<?php } ?>

  <?php require_once("../footer.php"); ?>