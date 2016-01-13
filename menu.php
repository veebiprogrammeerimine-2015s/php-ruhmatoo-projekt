<h3>Menüü</h3>

<ul>

	<?php if ($file_name == "data.php"){ ?>
		<li> Avaleht </li>
	<?php } else { ?>
		<li> <a href="data.php">Avaleht</a> </li>
	<?php } ?>
	
	<?php 
		if ($file_name == "login.php"){
			echo "<li> Login </li>";
		}else {
			echo '<li> <a href="login.php">Login</a> </li>';
		}

	?>
	<?php 
		if ($file_name == "forum"){
			echo "<li> Foorum </li>";
		}else {
			echo '<li> <a href="forum">Foorum</a> </li>';
		}

	?>
	

	
	
</ul>