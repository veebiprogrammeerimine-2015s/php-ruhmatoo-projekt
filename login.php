<<<<<<< HEAD
<?php require_once("header.php"); ?>
<?php require_once("functions.php");

	//kui kasutaja on sisseloginud,
	//siis suuunan data.php lehele
	if(isset($_SESSION["logged_in_user_id"])){
		header("Location: data.php");
	}
    ?>
	<!-- ###################### -->
	<!-- ####### MENÜÜ ######## -->
	<!-- ###################### -->
	

	
<br><br><br><br><br><br>

<!-- ###################### -->
<!-- ####### SISU ######### -->
<!-- ###################### -->	

<div class="container">

	<div class="row">
		
		<div class="col-md-6 col-sm-5 col-sm-offset-1">
			<h1> Tere </h1>
		</div>
		
		<div class="col-md-3 col-sm-4 col-sm-offset-1">
			
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
					<button type="submit" class="btn btn-info hidden-xs ">Login</button>
					<button type="submit" class="btn btn-info btn-block visible-xs">Login</button>
					</div>
					
				
			  </div>
			  
			</form>
			
			<br><br>
			
			
			<form>
				<h1>CREATE NEW USER</h1>
			  <div class="form-group">
				<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
			  </div>
			  
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
						<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
						<input type="text" class="form-control" id="exampleInputFirstName" placeholder="First name">
						<input type="text" class="form-control" id="exampleInputLastName" placeholder="Last name">
						</div>
					</div>
					<div class="col-md-4">
					<button type="submit" class="btn btn-info hidden-xs ">Login</button>
					<button type="submit" class="btn btn-info btn-block visible-xs">Login</button>
					</div>
					
				
			  </div>
			  
			</form>
			
		</div>
		
	</div>

</div>
=======
<?php require_once("header.php"); ?>
    

	
<br><br><br><br><br><br>
<!-- ###################### -->
<!-- ####### SISU ######## -->
<!-- ###################### -->	

<div class="container">

	<div class="row">
		
		<div class="col-md-6 col-sm-5 col-sm-offset-1">
			<h1> Tere </h1>
		</div>
		
		<div class="col-md-3 col-sm-4 col-sm-offset-1">
			
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
					<button type="submit" class="btn btn-info hidden-xs ">Login</button>
					<button type="submit" class="btn btn-info btn-block visible-xs">Login</button>
					</div>
					
				
			  </div>
			  
			</form>
			
			<br><br>
			
			
			<form>
				<h1>CREATE NEW USER</h1>
			  <div class="form-group">
				<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
			  </div>
			  
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
						<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
						<input type="text" class="form-control" id="exampleInputFirstName" placeholder="First name">
						<input type="text" class="form-control" id="exampleInputLastName" placeholder="Last name">
						</div>
					</div>
					<div class="col-md-4">
					<button type="submit" class="btn btn-info hidden-xs ">Login</button>
					<button type="submit" class="btn btn-info btn-block visible-xs">Login</button>
					</div>
					
				
			  </div>
			  
			</form>
			
		</div>
		
	</div>

</div>
>>>>>>> ae01d6a486725dcf10f3089662b1e3125401cf2a
	