<?php
	require_once("header.php"); 
	require_once("login.php");
		if(isset($_SESSION["logged_in_user_id"])){
		header("Location:data.php");
		
	}

?>
    
	<!-- ###################### -->
	<!-- ####### MENÜÜ ######## -->
	<!-- ###################### -->
	
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">PHOTTLE</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Front Page <span class="sr-only">(current)</span></a></li>
        <li><a href="about.php">About</a></li>
		<li><a href="forums.php">Foorum</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	
	
	<br><br><br><br>
	
<!-- ###################### -->
<!-- ####### SISU ######## -->
<!-- ###################### -->	

<div class="container">

	<div class="row">
		<div class="col-sm-6">
			<div class="jumbotron">
				<div class="container">
			<form method="post" >
				<h3>Logige sisse</h3>
				<div class="form-group">
				<input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
				</div>
			  
				<div class="row">
					<div class="col-xs-8">
						<div class="form-group">
						<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
						</div>
					</div>
					<div class="col-xs-4">
					<input type="submit" name="login" class="btn btn-info hidden-xs "> 
					<input type="submit" name="login" class="btn btn-info btn-block visible-xs"> 
					</div>
			  </div>
			  
			</form>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="jumbotron">
				<div class="container">
					<form>
						<h4>Ei ole veel liitunud? Registreerige siin:</h4>
						<button type="submit" class="btn btn-info"><a href="signup.php"> Sign Up</a></button>
						<b>
					</form>
				</div>
			</div>
		</div>
			
	</div>

</div>