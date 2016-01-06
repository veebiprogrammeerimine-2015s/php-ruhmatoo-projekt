<?php
  require_once("../header.php");
	require_once("../functions.php");
  //Lehe nimi
  $page_title = "Uus professor";
  //Faili nimi
  $page_file = "addprof.php";

?>
<?php
  $firstname_error = $lastname_error = $school_error = "";
  $firstname = $lastname = $school = "";

  if($_SERVER["REQUEST_METHOD"] == "POST") {
      if(isset($_POST["add"])){
      if (empty($_POST["firstname"]) ) {
        $firstname_error = "See väli on kohustuslik";
      }else{
        $firstname = cleanInput($_POST["firstname"]);
      }

      if (empty($_POST["lastname"]) ) {
        $lastname_error = "See väli on kohustuslik";
      }else{
        $lastname = cleanInput($_POST["lastname"]);
      }

      if (empty($_POST["school"]) ) {
        $school_error = "See väli on kohustuslik";
      }else{
        $school = cleanInput($_POST["school"]);
      }

      if ($firstname_error == "" && $lastname_error == "" && $school_error == "") {
        $response = $Rate->newProfessor($firstname, $lastname, $school);
      }
    }
  }

 ?>
<div class="row">
  <div class="col-sm-12">
    <?php if(isset($response->success)): ?>
    <div class="alert alert-success alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
      <p><?=$response->success->message;?></p>
    </div>

    <?php elseif(isset($response->error)): ?>
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
      <p><?=$response->error->message;?></p>
    </div>
    <?php endif; ?>
    <div class="col-sm-6">
      <h1>Uus professor</h1>
      <p>Kas leidsid professori, kes on puudu?</p>
      </div>
      <div class="col-sm-6">
        <h1>Uus professor</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          <label for="firstname">Eesnimi</label>
          <input type="text" class="form-control" name="firstname">
          <?=$firstname_error;?>
          <br>
          <label for="lastname">Perekonnanimi</label>
          <input type="text" class="form-control" name="lastname">
          <?=$lastname_error;?>
          <br>
          <?=$Rate->schoolDropdown(); ?>
          <?=$school_error;?>
          <br>
          <input type="submit" name="add" class="btn btn-primary pull-right">
        </form>
      </div>
    </div>



</div>



<?php require_once("../footer.php"); ?>
