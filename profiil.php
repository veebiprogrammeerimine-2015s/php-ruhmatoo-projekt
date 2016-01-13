
<?php require_once("functions.php") ?>
<?php require_once("header.php") ?>
<?php if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kustutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	?>


<div class="container">
      <div class="row">
      <div class="col-md-5  toppad  pull-right col-md-offset-3 ">
   
      </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
   
   
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Miguel Mjau</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                
               
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Email</td>
                        <td><a href="mailto:info@support.com">miguel@gmail.com</a></td>
                     </tr>
                     
                    </tbody>
                  </table>
                  
                 
                </div>
              </div>
            </div>
                 
            
          </div>
        </div>
      </div>
    </div>