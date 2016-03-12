<?php
    $html = '<style>';
    $html .= '<link href="'.$_SERVER['DOCUMENT_ROOT'].'/php-ruhmatoo-projekt/css/bootstrap.css" rel="stylesheet">';
    $html .= '</style>';
    require_once("../inc/functions.php");
    require_once("tcpdf.php");
    $personal = $Resume->getPersonal($_GET['id']);
    $education = $Resume->getEducation($_GET['id']);
    $courses = $Resume->getSentCourses($_GET['id']);
      // create new PDF document
      $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

      // set document information
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor('Noorte Tööbörs');
      $pdf->SetTitle($personal->first.' '.$personal->last.' CV');

      // set default header data
      $pdf->SetHeaderData('logo_pdf.jpg', PDF_HEADER_LOGO_WIDTH, '', '', array(0,0,0), array(0,0,0));
      //$pdf->SetHeaderData('logo_pdf.jpg', PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
      $pdf->setFooterData(array(0,0,0), array(0,0,0));
      // set header and footer fonts
      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

      // set default monospaced font
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

      // set margins
      $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP+5, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

      // set auto page breaks
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

      // set image scale factor
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO+2);


    $pdf->SetFont('helvetica', '', 10);
    // add a page
    $pdf->AddPage();
    #echo $current->ntb_schools.school;
    $date1 = new DateTime(date("Y-m-d"));
    $date2 = new DateTime($personal->born);
    $diff = $date1->diff($date2);

    if($diff->format('%y') > 100) {
      $age = "xx";
    } else {
      $age = $diff->format('%y');
    }

    $borndate = date_create($personal->born);

    if($diff->format('%y') > 100) {
      $born = "Täitmata!";
    } else {
      $born = date_format($borndate,"d.m.Y");
    }


    $html .= "<h2>Isikuandmed</h2>";
    $html .= "<p><strong>Nimi: </strong> ".$personal->first." ".$personal->last."</p>";
    $html .= "<p><strong>Sünniaeg: </strong> " . $born . " (" . $age . ")</p>";
    $html .= "<p><strong>Elukoht: </strong> ".$personal->county.", ".$personal->parish."</p>";
    $html .= "<p><strong>Telefon: </strong> ".$personal->number."</p>";
    $html .= "<p><strong>Email: </strong> ".$personal->email."</p>";
    $html .= "<h2>Hariduskäik</h2>";

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
      if($education[$i]->type == "Keskkool") {
        $education[$i]->type = "Keskkool&nbsp;";
      }
      if($education[$i]->type == "Põhikool") {
        $education[$i]->type = "Põhikool&nbsp;&nbsp;";
      }
      if($education[$i]->info != "") {
        $education[$i]->info = "(".$education[$i]->info.")";
      }
      $html .= '<p align="justify">'.$education[$i]->start.' - '.$education[$i]->end.'&nbsp;&nbsp;'.$education[$i]->type.' - '.$education[$i]->name.'&nbsp;&nbsp;'.$education[$i]->info.'</p>';
    }

    if(!empty($courses)) {
      $html .= "<h2>Täiendkoolitused</h2>";
    } else {
      $html .= "";
    }
    for($i = 0; $i < count($courses); $i++) {
      if($courses[$i]->year == 0) {
        $courses[$i]->year = "";
      } else {
        $courses[$i]->year = "<p style='background-color: #f00'>Aasta: ".$courses[$i]->year."</p>";
      }

      if($courses[$i]->trainer != "") {
        $courses[$i]->trainer = "Koolitaja: ".$courses[$i]->trainer." - ";
      }
      $html .= "<table border=1>";
      $html .= "<thead>";
      $html .= "Koolitaja";
      $html .= "Koolitus";
      $html .= "</thead>";

      $html .= "</table>";
      #Trainer, course, duration, info, year
      $html .= $courses[$i]->year.$courses[$i]->trainer.'Koolitus: '.$courses[$i]->course.' - '.$courses[$i]->duration.'&nbsp;&nbsp;'.$courses[$i]->info;
    }

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    // reset pointer to the last page
    $pdf->lastPage();
    // ---------------------------------------------------------
    //Close and output PDF document
    $pdf->Output('ntb_cv_'.$_GET['id'].'.pdf', 'I');

?>
