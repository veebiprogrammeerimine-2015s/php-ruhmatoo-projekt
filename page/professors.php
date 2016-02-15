<?php
  //Lehe nimi
  $page_title = "Otsi professorit";
  //Faili nimi
  $page_file = "professors.php";

  require_once("../header.php");
	require_once("../functions.php");

?>
<?php
  $keyword = "";
  $professor = $Rate->allProfessors($keyword);

  if (isset($_GET["keyword"])) {
    $keyword = cleanInput($_GET["keyword"]);

    //otsime
    $professor = $Rate->allProfessors($keyword);
  } else {
    //Naitame koiki tulemus
    $professor = $Rate->allProfessors($keyword);
  }
?>
<div class="col-sm-12">


  <form action="professors.php" method="get">
     <div class="input-group">
       <input name="keyword" type="text" class="form-control" placeholder="Otsi...">
       <span class="input-group-btn">
         <button class="btn btn-default" type="submit" value="otsi">Otsi!</button>
       </span>
     </div>
  </form>


 <table class="table table-striped">
   <thead>
     <tr>
       <th>Nimi</th>
       <th>Kool</th>
       <th>Hindama</th>
     </tr>
   </thead>
   <tbody>
       <?php
        for($i = 0; $i < count($professor); $i++) {
          echo '<tr>';
          echo '<td>'.$professor[$i]->first.' '.$professor[$i]->last.'</td>
                <td>'.$professor[$i]->school.'</td>
                <td><a href="../prof/'.$professor[$i]->id.'.php" class="btn btn-default"><span class="glyphicon glyphicon-comment"></span> Hinda</a></td>';

          echo '</tr>';
        }


       ?>
   </tbody>
 </table>
</div>


<?php require_once("../footer.php"); ?>
