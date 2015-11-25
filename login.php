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
	
<!--Variables -->
<?
$email_error = "";
$password_error = "";	

$username = ""; $email = ""; $password = ""; $username_or_email = "";
$reg_username = ""; $reg_email = ""; $reg_password = "";
?>

<!--Log-in function -->
<?// Controlling whether someone inputed login button
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if(isset($_POST["login"])){
				
			if (empty($_POST["username_or_email"]) ) {
                $username_error = "This field is required";

            }else{

                $username_or_email = cleanInput($_POST["username_or_email"]);

                }
				
			if (empty($_POST["password"]) ) {
				$password_error = "This field is required";
			}else{
			
				$password = cleanInput($_POST["password"]);
				
			}
			// Checking for errors
			if($email_error == "" && $password_error ==""){
				
			$hash = hash("sha512", $password);
			
			// Creating user file
				loginUser($username_or_email, $hash);
				
		
			}
		}
?>

<br><br>

<!-- ######################## -->
<!-- ####### Content ######## -->
<!-- ######################## -->	

<div class="container">

	<div class="row">
		
		<div class="col-md-5 col-sm-5 col-sm-offset-1">
			
			<form action="login.php" method="post" >
			  <h1>Log-in</h1>
			  <div class="form-group">
				<input type="email" class="form-control" id="email placeholder="E-mail" > <?php echo $email_error; ?>
			  </div>
			  
				<div class="row">
					<div class="col-md-8">
						<div class="form-group">
						<input type="password" class="form-control" id="password" placeholder="Password"> <?php echo $password_error; ?>
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
		
		<div class="col-md-3 col-sm-4 col-sm-offset-1">


</div>
	
	
<?php require_once("footer.php"); ?>