<?php
	//kopeerime header.php sisu
require_once("header.php");
?>
<nav class="navbar navbar-inverse
navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php">Kings of cocktails</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="top.php">Top baarid</a></li>
        <li><a href="critic.php">Kriitikule</a></li>
        <li class="dropdown">
          
        </li>
      </ul>
      
     
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<br>
<br>
<br>

KRIITIKU LEHT
<div class=" col-md-offset-1 col-md-3 col-sm-4">
<form>
		<h2>Logi sisse</h2>
			  <div class="form-group">
				<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
			  </div>
			  <div class="form-group">
				<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
			  </div>
			 
			  <button type="submit" class="btn btn-success pull-right hidden-xs">Logi sisse!</button>
			  <button type="submit" class="btn btn-success btn-block visible-xs">Logi sisse!</button>
			</form>

</div>


