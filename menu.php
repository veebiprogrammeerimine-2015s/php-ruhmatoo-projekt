<h2>Menu</h2>
<ul>
	
	<?php if($file_name == "home.php"){ ?>
	
		<li>Avaleht</li>
	
	<?php } else { ?>
	
		<li><a href="home.php">Avaleht</a></li>
	
	<?php } ?>
	
	
	
	<?php 
		
		if($file_name == "register.php"){ 
		
			echo "<li>Registreerimine</li>";
		
		}else{
	
			echo '<li><a href="registration.php">Registreerimine</a></li>';
		}
		
	?>
<<<<<<< HEAD

=======
<?php 
		
		if($file_name == "data.php"){ 
		
			echo "<li>Lisa parandus</li>";
		
		}else{
	
			echo '<li><a href="data.php">Lisa parandus</a></li>';
		}
		
	?>
>>>>>>> katariin

</ul> 
