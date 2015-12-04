<?php require_once("../header.php"); ?>

<nav class="navbar navbar-inverse navbar-fixed-top">  <!-- default - hall; navbar fixed top hoiab seda üleval kinni -->
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Home</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<br></br>
<br></br>

<!-- SISU -->
<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 col-md-offset-1 col-sm-9">
			<div class="jumbotron">
				<h1>Welcome to disc golf page!</h1>
				<p>...</p>
			</div>
		</div>

		
<!-- SISSE LOGIMINE -->		
		<div class="col-md-3 col-md-offset-1 col-sm-4">
			<h3>Log in</h3>
			<form>
			  <div class="form-group">
				
				<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
			  </div>
			  <div class="form-group">
				
				<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
			  </div>
			  <div class="form-group">
				
			  </div>
			  <button type="submit" class="btn btn-success pull-right hidden-xs">Log in</button>
			  <button type="submit" class="btn btn-success btn-block visible-xs">Log in</button>
			</form>
			
			<br></br>


	</div>

	<!-- UUS KASUTAJA -->				
			<div class="col-md-3 col-md-offset-1 col-sm-4">
			<h3>Sign up</h3>
			<form>
			  <div class="form-group">
				
				<input type="newname" class="form-control" id="exampleInputName2" placeholder="Full Name">
			  </div>
			
			
			  <div class="form-group">
				
				<input type="newemail" class="form-control" id="exampleInputEmail2" placeholder="Email">
			  </div>
			  <div class="form-group">
				
				<input type="newpassword" class="form-control" id="exampleInputPassword2" placeholder="Password">
			  </div>
			  <div class="form-group">
				
			  </div>
			  <button type="submit" class="btn btn-success pull-right hidden-xs">Sign up</button>
			  <button type="submit" class="btn btn-success btn-block visible-xs">Sign up</button>
			</form>
					
		</div>
	
</div>



<?php require_once("../footer.php"); ?>