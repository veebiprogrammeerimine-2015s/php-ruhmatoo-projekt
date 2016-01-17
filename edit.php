
<?php
	
	require_once("edit_functions.php");
	
	if(isset($_POST["update"])){
		
		updateCar($_POST["id"], $_POST["model"], $_POST["make"], $_POST["color"]);
	}
	
	if(!isset($_GET["edit"])){
		
		header("location: cars.php");
		
	}else{
		
		$car_object = getSingleCarData($_GET["edit"]);
		var_dump($car_object);
	}
	
	
	
?>
<h2>Muuda Autot</h2>
	
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
		<input type="hidden" name="id" value="<?=$_GET["edit"];?>" >
		<label for="model" >Mark</label><br>
		<input id="model" name="model" type="text" value="<?=$car_object->model;?>"> <br><br>
		<label for="make" >Mudel</label><br>
		<input id="make" name="make" type="text" value="<?=$car_object->make;?>"> <br><br>
		<label for="color" >Värv</label><br>
		<input id="color" name="color" type="text" value="<?=$car_object->color;?>"> <br><br>
		<input type="submit" name="update" value="Salvesta">
	  </form>