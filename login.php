<?php require_once("header.php"); ?>
    
	<!-- ###################### -->
	<!-- ####### Menu ######### -->
	<!-- ###################### -->
	
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Menu</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Link</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	
<br><br><br><br><br><br>
<!-- ######################## -->
<!-- ####### Content ######## -->
<!-- ######################## -->	

<div class="container">

	<div class="row">
		
		<div class="col-md-6 col-sm-5 col-sm-offset-1">

			<form>
			  <div class="form-group">
				<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
			  </div>
			  
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
						<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
						</div>
					</div>
					<div class="col-md-4">
					<button type="submit" class="btn btn-info hidden-xs ">Login 1 </button>
					<button type="submit" class="btn btn-info btn-block visible-xs">Login 2 </button>
					</div>
					
				
			  </div>
			  
			</form>
			
			
		</div>
		
	</div>
		
		<div class="col-md-3 col-sm-4 col-sm-offset-1">


</div>
	
	
<?php require_once("footer.php"); ?>