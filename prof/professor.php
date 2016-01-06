<?php

  //Lehe nimi
  $page_title = "Hinda professorit";
  //Faili nimi
  $page_file = "professor.php";

  require_once("../header.php");
	require_once("../functions.php");

?>
<?php
  $current = $_SERVER['PHP_SELF'];
  $path = pathinfo($current);
  $file_to_trim = $path['basename'];
  $trimmed = rtrim($file_to_trim, ".php");
  $professor = $Rate->getProfData($trimmed);
  $comments = $Rate->getComments($trimmed);
  $add_help = 0;
  $add_clarity = 0;
  $add_exam = 0;
  $add_class = 0;
  #var_dump ($professor[0]);
 ?>
 <?php
 for($i = 0; $i < count($professor[0]); $i++) {
   $add_help += $professor[0][$i]->help;
   $add_clarity += $professor[0][$i]->clarity;
   $add_exam += $professor[0][$i]->exam;
   $add_class += $professor[0][$i]->class;

 }
  $median_help = $add_help / count($professor[0]);
  $median_clarity = $add_clarity / count($professor[0]);
  $median_exam = $add_exam / count($professor[0]);
  $median_class = $add_class / count($professor[0]);
?>

 <div class="col-sm-6">
   <table class="table table-striped table-bordered">

     <tr>
       <td><label> Nimi </label></td>
       <td><?=$professor[1]->first." ".$professor[1]->last;?></td>
     </tr>
     <tr>
       <td><label> Kool </label></td>
       <td><?=$professor[1]->school;?></td>
     </tr>
     <tr>
       <td><label> Abivalmidus </label></td>
       <td><?=$median_help;?></td>
     </tr>
     <tr>
       <td><label> Selgus </label></td>
       <td><?=$median_clarity;?></td>
     </tr>
     <tr>
       <td><label> Eksamihinne </label></td>
       <td><?=$median_exam;?></td>
     </tr>
     <tr>
       <td><label> Üldine hinne </label></td>
       <td><?=$median_class;?></td>
     </tr>
   </table>
</div>
<div class="col-sm-6">
 <?php require_once("../page/rate_points.php"); ?>
</div>
<div class="col-sm-6">
  <br>
  <br>
 <?php
   for($i = 0; $i < count(); $i++) {
     echo 'Kood:'.;
     echo '<pre>'..'</pre>';
    }
 ?>
</div>
<div class="col-sm-6">
  <br>
  <br>
 <?php require_once("../page/rate.php"); ?>
</div>

<?php require_once("../footer.php"); ?>
