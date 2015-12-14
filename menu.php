<base href="http://tlu.multirootor.eu" />
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menyy" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Brand</a>
    </div>
	
	
	
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="menyy">
		<ul class="nav navbar-nav">
			<?php
			if($page_title == 'Avaleht'){
				echo '<li class="active"><a href="/index.php">Avaleht<span class="sr-only"></span></a></li>';
			} else {
				echo '<li><a href="/index.php">Avaleht</a></li>';
			}
			if($page_title == 'Pood'){
				echo '<li class="active"><a href="/pages/store.php">Pood<span class="sr-only"></span></a></li>';
			} else {
				echo '<li><a href="/pages/store.php">Pood</a></li>';
			}

			if(!isset($_SESSION['logged_in_user_id'])){
				if($page_title == 'LogIn'){
					echo '<li class="active"><a href="/pages/login.php">Log In<span class="sr-only"></span></a></li>'; 
				} else {
					echo '<li><a href="/pages/login.php">Log In</a>';
				}
			}
			
			if(!isset($_SESSION['logged_in_user_id'])){
				if($page_title == 'Register'){
					echo '<li class="active"><a href=/pages/create.php>Kasutaja loomine<span class="sr-only">(current)</span></a></li>';
				} else {
					echo '<li><a href=/pages/create.php>Kasutaja loomine</a></li>';
				}
			}
			
			if(isset($_SESSION['logged_in_user_id'])){
				if($page_title == 'User edit'){
					echo '<li class="active"><a href="pages/userpage.php">Kasutaja andmete muutmine<span class="sr-only">(current)</span></a></li>';
				} else {
					echo '<li><a href=/pages/userpage.php>Kasutaja andmete muutmine</a></li>';
				}
			}
			?>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<?php
			if($_SESSION['logged_in_user_privileges']=='admin'){
				echo '<li class="dropdown">';
				echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin asjad <span class="caret"></span></a>';
				echo '<ul class="dropdown-menu">';
					echo '<li><a href="pages/storage.php" >Lisa ladu<span class="sr-only"></span></a></li>';
					echo '<li><a href="pages/userpageadmin.php">Kasutaja muutmine<span class="sr-only">(current)</span></a></li>';
					echo '<li><a href="pages/storageitems.php">Kaup<span class="sr-only">(current)</span></a></li>';
					echo '<li><a href="pages/storageitemimage.php">Kauba pilt<span class="sr-only">(current)</span></a></li>';
				echo '</ul>';
			echo '</li>';
			}?>
			<li>
				<form class="navbar-form navbar-right" role="logout">
					<div>
						<?php
							if(isset($_SESSION['logged_in_user_id'])){
								echo '<p class="navbar-text" id="signed_in">Signed in as ',$_SESSION['logged_in_user_username'],'</p>';
								echo '<a href="?logout" class="btn btn-default navbar-link">Logout</a>';
						}?>
					</div>
				</form>
			</li>
		</ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
