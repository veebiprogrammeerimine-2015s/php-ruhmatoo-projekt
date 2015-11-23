<?php 	require_once("header.php"); ?>

<!-- navigation -->
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Mikupea</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">Meist</a>
                    </li>
                    <li>
                        <a href="#">Kassid</a>
                    </li>
                    <li>
                        <a href="#">Kodu leidnud kassid</a>
                    </li>
					<li>
                        <a href="#">Annetamine</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <br><br><br><br>

	<!-- Sisu -->
    <div class="container-fluid" id="feg">
        <div class="row">
            <div class="col-sm-offset-1 col-sm-6">
                <h1>Tere tulemast Mikupea kodulehele!</h1>
            </div>
            <div class="col-sm-offset-1 col-sm-3">
				<form>
					<div class="form-group">
						<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
					</div>
				  

					<div class="row">
					
						<div class="col-lg-8">
							<div class="form-group">
								<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
							</div>
						</div>
						
						<div class="col-lg-4 hidden-sm hidden-md">
							<button type="submit" class="btn btn-info btn-block">Login</button>
						</div>
						
						<div class="col-lg-4 hidden-lg hidden-xs pull-right">
							<button type="submit" class="btn btn-info">Login</button>
						</div>
						
					</div>
				   
				</form>
            </div>
                    
        </div>
    </div>
	
<?php	require_once("footer.php"); ?>
