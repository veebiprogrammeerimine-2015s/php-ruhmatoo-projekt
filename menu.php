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
		if ($file_name == "forum"){
			echo "<li> Foorum </li>";
		}else {
			echo '<li> <a href="http://localhost:5555/~janilv/php-ruhmatoo-projekt/forum/">Foorum</a> </li>';
		}

	?>
	

	
	
</ul>