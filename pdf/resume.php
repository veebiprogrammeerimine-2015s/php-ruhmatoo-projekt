<?php
    $html = '<style>';
    $html .= '<link href="'.$_SERVER['DOCUMENT_ROOT'].'/php-ruhmatoo-projekt/css/bootstrap.css" rel="stylesheet">';
    $html .= '</style>';
    require_once("../inc/functions.php");
    require_once("tcpdf.php");
    $personal = $Resume->getPersonal($_GET['id']);
    $education = $Resume->getEducation($_GET['id']);
    #var_dump ($current[0]->school_name);
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetFont('helvetica', '', 10);
    // add a page
    $pdf->AddPage();
    #echo $current->ntb_schools.school;
    $html .= "<h2>Personaalne info</h2>";
    $html .= "<br><br><br><br><br><br>";
    $html .= "<p><strong>Eesnimi: </strong> ".$personal->first."</p>";
    $html .= "<p><strong>Perekonnanimi: </strong> ".$personal->last."</p>";
    $html .= "<p><strong>Maakond: </strong> ".$personal->county."</p>";
    $html .= "<p><strong>Vald: </strong> ".$personal->parish."</p>";
    $html .= "<p><strong>Telefon: </strong> ".$personal->number."</p>";
    $html .= "<p><strong>Email: </strong> ".$personal->email."</p>";
    $html .= "<h2>Haridus</h2>";

    for($i = 0; $i < count($education); $i++) {
      if($education[$i]->end == 0) {
        $move = $education[$i];
        unset($education[$i]);
        array_unshift($education, $move);
      }
    }


    for($i = 0; $i < count($education); $i++) {
      if($education[$i]->end == 0) {
        $education[$i]->end = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
      }
      $html .= '<p align="justify">'.$education[$i]->start.' - '.$education[$i]->end.'&nbsp;&nbsp;'.$education[$i]->type.' '.$education[$i]->name.'&nbsp;&nbsp;'.$education[$i]->info.'</p>';
    }


    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    // reset pointer to the last page
    $pdf->lastPage();
    // ---------------------------------------------------------
    //Close and output PDF document
    $pdf->Output('ntb_cv_'.$_GET['id'].'.pdf', 'I');

?>
