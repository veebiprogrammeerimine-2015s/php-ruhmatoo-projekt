<?php
  require_once("../header.php");
	require_once("../functions.php");
  //Lehe nimi
  $page_title = "Hinda professorit";
  //Faili nimi
  $page_file = "professor.php";

?>
<?php
  /*$current = $_SERVER['PHP_SELF'];
  $path = pathinfo($current);
  $file_to_trim = $path['basename'];
  $trimmed = rtrim($file_to_trim, ".php");
  $professor = $Rate->currentProfessor($trimmed);*/
 ?>
 <div class="col-sm-6">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Nimi</th>
        <th>Kool</th>
        <th>Abivalmidus</th>
        <th>Selgus</th>
        <th>Eksami keskmine</th>
        <th>Üldine hinne</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Mari Murakas</td>
        <td>Tallinn</td>
        <td>0/5</td>
        <td>0/5</td>
        <td>4.2</td>
        <td>0/5</td>
      </tr>
    </tbody>
  </table>
</div>
<div class="col-sm-6">
 require rate.php
</div>

<?php require_once("../footer.php"); ?>
