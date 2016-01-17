<h3>Menüü</h3>

<ul>

	<?php if ($file_name == "data.php"){ ?>
		<li> Avaleht </li>
	<?php } else { ?>
		<li> <a href="data.php">Avaleht</a> </li>
	<?php } ?>
	
	<?php 
		if ($file_name == "add_car.php"){
			echo "<li> Auto lisamine </li>";
		}else {
			echo '<li> <a href="add_car.php">Auto lisamine </a> </li>';
		}

	?>
	
	<?php 
		if ($file_name == "cars.php"){
			echo "<li> Autode nimekiri </li>";
		}else {
			echo '<li> <a href="cars.php">Autode nimekiri </a> </li>';
		}

	?>
	
	<?php 
		if ($file_name == "user_car.php"){
			echo "<li> Kasutajate autod </li>";
		}else {
			echo '<li> <a href="user_car.php">Kasutajate autod </a> </li>';
		}

	?>
	
	<?php 
		if ($file_name == "forum"){
			echo "<li> Foorum </li>";
		}else {
			echo '<li> <a href="http://greeny.cs.tlu.ee/~janilv/php-ruhmatoo-projekt/forum/">Foorum</a> </li>';
		}

	?>
	

	
	
</ul>