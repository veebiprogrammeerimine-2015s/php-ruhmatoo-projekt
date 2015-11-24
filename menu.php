<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Brand</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	<ul class="nav navbar-nav">
		<?php
		if($page_title == Avaleht){
			echo '<li class="active navbar-text"><p>Esileht</p></li>';
		} else {
			echo '<li><a href="index.php">Esileht</a></li>';
		}
		?>
		<?php
		if(!isset($_SESSION['logged_in_user_id'])){
			echo '<li><a href="login.php">Login</a></li>';
		}
		?>
		<?php
		if(!isset($_SESSION['logged_in_user_id'])){
			echo '<li class=""><a href="create.php">Kasutaja loomine</a></li>';
		}
		?>
		<?php
		if($_SESSION['logged_in_user_privileges']=='admin'){
			echo '<li class=""><a href="storage.php">Lisa ladu</a></li>';
		}
		?>
		<?php
		if($_SESSION['logged_in_user_privileges']=='admin'){
			echo '<li class=""><a href="userpageadmin.php">admin</a></li>';
		}
		?><?php
		if($_SESSION['logged_in_user_privileges']=='admin'){
			echo '<li class=""><a href="storageadditem.php">Add item</a></li>';
		}
		?>
		<?php
		if(isset($_SESSION['logged_in_user_id'])){
			echo '<li class=""><a href="userpage.php">Tava</a></li>';
		}
		?>
		
	</ul>
		<div class="navbar-right push-right" >
		<?php
		if(isset($_SESSION['logged_in_user_id'])){
			echo '<p class="navbar-text">Signed in as ',$_SESSION['logged_in_user_username'],'</p>';
			echo '<a href="?logout" class=" btn btn-default">Logout</a>';
			
		
		}?>
		<form class="navbar-form navbar-right push-right" role="search">
		<div class="form-group">
			<input type="text" class="form-control" placeholder="Search">
		</div>
		<button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
