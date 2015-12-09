<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Forum</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" >
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" >

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <h2>Menu</h2>
<ul>
	
	<?php if($page_file_name == "home.php"){ ?>
		<li>
			Home
		</li>
	<?php }else{ ?>
		<li>
			<a href="home.php">Home</a>
		</li>
	<?php } ?>
	
	<?php
		
		if($page_file_name == "login.php"){
			echo '<li>Log in</li>';
		} else {
			echo '<li><a href="login.php">Log in</a></li>';
		}
		
		if($page_file_name == "profile.php"){
			echo '<li>Edit profile</li>';
		} else {
			echo '<li><a href="profile.php">Edit profile</a></li>';
		}
	?>
	
	
</ul>