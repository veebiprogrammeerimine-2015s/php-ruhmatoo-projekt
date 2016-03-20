<?php
require('fpdf.php');
require_once("../inc/functions.php");
$personal = $Resume->getPersonal($_GET['id']);
$education = $Resume->getEducation($_GET['id']);
$courses = $Resume->getSentCourses($_GET['id']);
$work = $Resume->getSentWork($_GET['id']);
$languages = $Resume->getSentLanguages($_GET['id']);
$other = $Resume->getSentOther($_GET['id']);

$date1 = new DateTime(date("Y-m-d"));
$date2 = new DateTime($personal->born);
$diff = $date1->diff($date2);

### PERSONAL WORKAROUND ###
if($diff->format('%y') > 100) {
  $age = utf8_decode("Vigane!");
} else {
  $age = $diff->format('%y');
}

$borndate = date_create($personal->born);

if($diff->format('%y') > 100) {
  $born = utf8_decode("Täitmata!");
} else {
  $born = date_format($borndate,"d.m.Y");
}

### EDUCATION WORKAROUND ###
for($i = 0; $i < count($education); $i++) {
  if($education[$i]->end == 0) {
    $move = $education[$i];
    unset($education[$i]);
    array_unshift($education, $move);
  }
}





class PDF extends FPDF
{
function Header()
{
    global $title;
    $this->Image('../images/logo_pdf.jpg',10,6,60);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Calculate width of title and position
    $w = $this->GetStringWidth($title)+6;
    $this->SetX((210-$w)/2);
    // Colors of frame, background and text
    $this->SetDrawColor(255,255,255);
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(100, 33, 102);
    // Thickness of frame (1 mm)
    $this->SetLineWidth(0);
    // Title
    $this->Cell($w,10,$title,1,1,'C',true);
    // Line break
    $this->Ln(10);
    $this->SetDrawColor(0,0,0);
    $this->Line(10, 28, 200, 28);
}

function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Text color in gray
    $this->SetTextColor(128);
    // Page number
    $this->Cell(0,10,$this->PageNo(),0,0,'C');
}
function personalTable($fullname, $age, $born, $address, $number, $mail) {
  $data = array('Nimi: ', 'Vanus:', utf8_decode('Sünniaeg: '), 'Elukoht: ', 'Telefon: ', 'Email: ');
  $value = array($fullname, $age, $born, $address, $number, $mail);
  $title = "Isiklikud andmed";
  $title_next = utf8_decode("Hariduskäik");
  $h = 6;

  $this->SetTextColor(255,255,255);
  $this->SetFillColor(100, 33, 102);
  $this->SetFont('','B', 15);
  $this->Cell(0,10,$title,0,1,'L', true);
  $this->Ln(2);
  $this->SetTextColor(0,0,0);

  for($i = 0; $i < count($data); $i++) {
    if($i % 2 == 0) {
      $this->SetFillColor(250, 250, 250);
    } else {
      $this->SetFillColor(230, 230, 230);
    }


    //What to ask
    $this->SetFont('','B', 11);
    $w = $this->GetStringWidth($data[$i]) + 2.1;
    $this->Cell($w,$h,$data[$i],0,0,'L',true);
    //Value
    $this->SetFont('','','');
    $this->Cell(0,$h,$value[$i],0,1,'L',true);


  }

  $this->SetTextColor(255,255,255);
  $this->SetFillColor(100, 33, 102);
  $this->SetFont('','B', 15);
  $this->Ln(2);
  $this->Cell(0,10,$title_next,0,1,'L',true);
  $this->Ln(2);

}

function printPrimary() {
  $this->SetTextColor(255,255,255);
  $this->SetFillColor(140, 60, 140);
  $this->SetFont('','B', 12);
  $this->Cell(0,5,utf8_decode("Põhikool"),0,1,'L', true);
}

function printMiddle() {
  $this->SetTextColor(255,255,255);
  $this->SetFillColor(140, 60, 140);
  $this->SetFont('','B', 12);
  $this->Cell(0,5,utf8_decode("Keskkool"),0,1,'L', true);
}

function printIndustrial() {
  $this->SetTextColor(255,255,255);
  $this->SetFillColor(140, 60, 140);
  $this->SetFont('','B', 12);
  $this->Cell(0,5,utf8_decode("Kutsekool"),0,1,'L', true);
}

function printCourses() {
  $title = "Koolitused";

  $this->SetTextColor(255,255,255);
  $this->SetFillColor(100, 33, 102);
  $this->SetFont('','B', 15);
  $this->Ln(1);
  $this->Cell(0,10,$title,0,1,'L', true);
  $this->Ln(2);
  $this->SetTextColor(0,0,0);
}

function printWorkExp() {
  $title = utf8_decode("Töökogemus");

  $this->SetTextColor(255,255,255);
  $this->SetFillColor(100, 33, 102);
  $this->SetFont('','B', 15);
  $this->Ln(1);
  $this->Cell(0,10,$title,0,1,'L', true);
  $this->Ln(2);
  $this->SetTextColor(0,0,0);
}

function printLanguages() {
  $title = utf8_decode("Keelteoskus");

  $this->SetTextColor(255,255,255);
  $this->SetFillColor(100, 33, 102);
  $this->SetFont('','B', 15);
  $this->Ln(1);
  $this->Cell(0,10,$title,0,1,'L', true);
  $this->Ln(2);
  $this->SetTextColor(0,0,0);
}

function printOther() {
  $title = utf8_decode("Muu");

  $this->SetTextColor(255,255,255);
  $this->SetFillColor(100, 33, 102);
  $this->SetFont('','B', 15);
  $this->Ln(1);
  $this->Cell(0,10,$title,0,1,'L', true);
  $this->Ln(2);
  $this->SetTextColor(0,0,0);
}

function educationTable($name, $length, $info, $isDarker) {
  $this->SetTextColor(0,0,0);
  $data = array('Nimi: ', 'Periood: ', 'Lisainformatsioon: ');
  $value = array(utf8_decode($name), utf8_decode($length), utf8_decode($info));
  $h = 6;

  for($i = 0; $i < count($data); $i++) {
    if($isDarker == false) {
      $this->SetFillColor(250, 250, 250);
    } else {
      $this->SetFillColor(230, 230, 230);
    }

    if($i != 3 && strlen($value[$i]) != 0) {
      //Mis
      $this->SetFont('','B', 11);
      if($i == 2) {
        if($this->GetStringWidth($value[$i]) > 150) {

          $this->MultiCell(0,$h,$data[$i],0,'L',true);
        } else {
          $w = $this->GetStringWidth($data[$i]) + 2.1;
          $this->Cell($w,$h,$data[$i],0,0,'L',true);
        }

      } else {
        $w = $this->GetStringWidth($data[$i]) + 2.1;
        $this->Cell($w,$h,$data[$i],0,0,'L',true);
      }
      //V22rtus
      $this->SetFont('','','');
      $this->MultiCell(0,$h,$value[$i],0,'L',true);

    }

  }
}

function courseTable($trainer, $course_year_dur, $info, $isDarker) {
  $this->SetTextColor(0,0,0);
  $data = array('Koolitaja: ', 'Koolitus: ', 'Lisainformatsioon: ');
  $value = array(utf8_decode($trainer), utf8_decode($course_year_dur), utf8_decode($info));
  $h = 6;

  for($i = 0; $i < count($data); $i++) {
    if($isDarker == false) {
      $this->SetFillColor(250, 250, 250);
    } else {
      $this->SetFillColor(230, 230, 230);
    }

    if($i != 3 && strlen($value[$i]) != 0) {
      //Mis
      $this->SetFont('','B', 11);
      if($i == 2) {
        $w = $this->GetStringWidth($data[$i]) + 2.0;

        if($this->GetStringWidth($value[$i]) > 150) {
          $this->MultiCell(0,$h,$data[$i],0,'L',true);
        } else {
          $this->Cell($w,$h,$data[$i],0,0,'L',true);
        }

      } else {
        $w = $this->GetStringWidth($data[$i]) + 2.1;
        $this->Cell($w,$h,$data[$i],0,0,'L',true);
      }
      //V22rtus
      $this->SetFont('','','');
      $this->MultiCell(0,$h,$value[$i],0,'L',true);

    }

  }

}

function workTable($job, $time, $content, $info, $isDarker) {
  $this->SetTextColor(0,0,0);
  $data = array('Amet: ', 'Periood: ', 'Sisu: ', 'Lisainformatsioon: ');
  $value = array(utf8_decode($job), utf8_decode($time), utf8_decode($content), utf8_decode($info));
  $h = 6;

  for($i = 0; $i < count($data); $i++) {
    if($isDarker == false) {
      $this->SetFillColor(250, 250, 250);
    } else {
      $this->SetFillColor(230, 230, 230);
    }

    if($i != 4 && strlen($value[$i]) != 0) {
      //Mis
      $this->SetFont('','B', 11);
      if($i >= 2) {
        $w = $this->GetStringWidth($data[$i]) + 2.0;

        if($this->GetStringWidth($value[$i]) > 150) {
          $this->MultiCell(0,$h,$data[$i],0,'L',true);
        } else {
          $this->Cell($w,$h,$data[$i],0,0,'L',true);
        }

      } else {
        $w = $this->GetStringWidth($data[$i]) + 2.1;
        $this->Cell($w,$h,$data[$i],0,0,'L',true);
      }
      //V22rtus
      $this->SetFont('','','');
      $this->MultiCell(0,$h,$value[$i],0,'L',true);

    }

  }

}

function languagesTable($language, $skill, $info, $isDarker) {
  $this->SetTextColor(0,0,0);
  $data = array('Keel: ', 'Oskus: ', 'Lisainformatsioon: ');
  $value = array(utf8_decode($language), utf8_decode($skill), utf8_decode($info));
  $h = 6;

  for($i = 0; $i < count($data); $i++) {
    if($isDarker == false) {
      $this->SetFillColor(250, 250, 250);
    } else {
      $this->SetFillColor(230, 230, 230);
    }

    if($i != 3 && strlen($value[$i]) != 0) {
      //Mis
      $this->SetFont('','B', 11);
      if($i == 2) {
        $w = $this->GetStringWidth($data[$i]) + 2.0;

        if($this->GetStringWidth($value[$i]) > 150) {
          $this->MultiCell(0,$h,$data[$i],0,'L',true);
        } else {
          $this->Cell($w,$h,$data[$i],0,0,'L',true);
        }

      } else {
        $w = $this->GetStringWidth($data[$i]) + 2.1;
        $this->Cell($w,$h,$data[$i],0,0,'L',true);
      }
      //V22rtus
      $this->SetFont('','','');
      $this->MultiCell(0,$h,$value[$i],0,'L',true);

    }

  }

}

function otherTable($positives, $additional, $isDarker) {
  $this->SetTextColor(0,0,0);
  $data = array(utf8_decode('Positiivsed küljed: '), utf8_decode('Lisainformatsioon: '));
  $value = array(utf8_decode($positives), utf8_decode($additional));
  $h = 6;

  for($i = 0; $i < count($data); $i++) {
    if($i % 2 == 0) {
      $this->SetFillColor(250, 250, 250);
    } else {
      $this->SetFillColor(230, 230, 230);
    }

    if($i != 2 && strlen($value[$i]) != 0) {
      //Mis
      $this->SetFont('','B', 11);

      $w = $this->GetStringWidth($data[$i]) + 2.1;

      $this->MultiCell(0,$h,$data[$i],0,'L',true);
      //V22rtus
      $this->SetFont('','','');
      $this->MultiCell(0,$h, $value[$i],0,'L',true);


    }

  }

}

}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->SetTitle($personal->first." ".$personal->last." CV");
$title = $personal->first." ".$personal->last;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

$pdf->personalTable($personal->first . " " . $personal->last, $age, $born, $personal->county.", ".$personal->parish, $personal->number, $personal->email);

$primary = array();
$middle = array();
$industrial = array();

for($i = 0; $i < count($education); $i++) {
  if($education[$i]->end == 0) {
    $education[$i]->end = "     ";
  }
  if(utf8_decode($education[$i]->type) == utf8_decode("Põhikool")) {
    array_push($primary, $education[$i]);
  } elseif (utf8_decode($education[$i]->type) == utf8_decode("Keskkool")) {
    array_push($middle, $education[$i]);
  } elseif (utf8_decode($education[$i]->type) == utf8_decode("Kutsekool")) {
    array_push($industrial, $education[$i]);
  }
}

  if(count($primary) > 0) {
    $pdf->printPrimary();
    $pdf->Ln(1);
    for($j = 0; $j < count($primary); $j++) {
      if($j % 2 == 0) {
        $pdf->educationTable($primary[$j]->name,$primary[$j]->start . " - " . $primary[$j]->end,$primary[$j]->info,false);
      } else {
        $pdf->educationTable($primary[$j]->name,$primary[$j]->start . " - " . $primary[$j]->end,$primary[$j]->info,true);
      }
      $pdf->Ln(1);
    }
  }

  if(count($middle) > 0) {
    $pdf->printMiddle();
    $pdf->Ln(1);
    for($j = 0; $j < count($middle); $j++) {
      if($j % 2 == 0) {
        $pdf->educationTable($middle[$j]->name,$middle[$j]->start . " - " . $middle[$j]->end,$middle[$j]->info,false);
      } else {
        $pdf->educationTable($middle[$j]->name,$middle[$j]->start . " - " . $middle[$j]->end,$middle[$j]->info,true);
      }
      $pdf->Ln(1);
    }
  }

  if(count($industrial) > 0) {
    $pdf->printIndustrial();
    $pdf->Ln(1);
    for($j = 0; $j < count($industrial); $j++) {
      if($j % 2 == 0) {
        $pdf->educationTable($industrial[$j]->name,$industrial[$j]->start . " - " . $industrial[$j]->end,$industrial[$j]->info,false);
      } else {
        $pdf->educationTable($industrial[$j]->name,$industrial[$j]->start . " - " . $industrial[$j]->end,$industrial[$j]->info,true);
      }
      $pdf->Ln(1);
    }
  }
  if(count($courses) > 0) {
    $pdf->printCourses();
  }
  for($i = 0; $i < count($courses); $i++) {
    if($i % 2 == 0) {

      if($courses[$i]->year == 0 && $courses[$i]->duration == "") {
        $courses[$i]->year = "";
        $pdf->courseTable($courses[$i]->trainer, $courses[$i]->course . $courses[$i]->year . $courses[$i]->duration, $courses[$i]->info, false);

      } else if($courses[$i]->year == 0) {
        $courses[$i]->year = "";
        $pdf->courseTable($courses[$i]->trainer, $courses[$i]->course . ", " . $courses[$i]->year . "kestusega: " . $courses[$i]->duration, $courses[$i]->info, false);

      } elseif ($courses[$i]->duration == "") {
        $pdf->courseTable($courses[$i]->trainer, $courses[$i]->course . ", " . $courses[$i]->year . ". aasta", $courses[$i]->info, false);

      } else {
        $pdf->courseTable($courses[$i]->trainer, $courses[$i]->course . ", " . $courses[$i]->year . ". aasta, kestusega: " . $courses[$i]->duration, $courses[$i]->info, false);
      }



    } else {
      if($courses[$i]->year == 0 && $courses[$i]->duration == "") {
        $courses[$i]->year = "";
        $pdf->courseTable($courses[$i]->trainer, $courses[$i]->course . $courses[$i]->year . $courses[$i]->duration, $courses[$i]->info, true);

      } else if($courses[$i]->year == 0) {
        $courses[$i]->year = "";
        $pdf->courseTable($courses[$i]->trainer, $courses[$i]->course . ", " . $courses[$i]->year . "kestusega: " . $courses[$i]->duration, $courses[$i]->info, true);

      } elseif ($courses[$i]->duration == "") {
        $pdf->courseTable($courses[$i]->trainer, $courses[$i]->course . ", " . $courses[$i]->year . ". aasta", $courses[$i]->info, true);

      } else {
        $pdf->courseTable($courses[$i]->trainer, $courses[$i]->course . ", " . $courses[$i]->year . ". aasta, kestusega: " . $courses[$i]->duration, $courses[$i]->info, true);
      }

    }
    $pdf->Ln(1);
  }
  if(count($work) > 0) {
    $pdf->printWorkExp();
  }
  for($i = 0; $i < count($work); $i++) {
    if($i % 2 == 0) {

      if($work[$i]->end == 0) {
        $work[$i]->end = "";
        $pdf->workTable($work[$i]->company . ", " . $work[$i]->name, $work[$i]->start . " - " . $work[$i]->end, $work[$i]->content, $work[$i]->info, false);
      } else {
        $pdf->workTable($work[$i]->company . ", " . $work[$i]->name, $work[$i]->start . " - " . $work[$i]->end, $work[$i]->content, $work[$i]->info, false);
      }



    } else {
      if($work[$i]->end == 0) {
        $work[$i]->end = "";
        $pdf->workTable($work[$i]->company . ", " . $work[$i]->name, $work[$i]->start . " - " . $work[$i]->end, $work[$i]->content, $work[$i]->info, true);

      } else {
        $pdf->workTable($work[$i]->company . ", " . $work[$i]->name, $work[$i]->start . " - " . $work[$i]->end, $work[$i]->content, $work[$i]->info, true);
      }

    }
    $pdf->Ln(1);
  }

  if(count($languages) > 0) {
    $pdf->printLanguages();

  }

  $skillSet = array('A1', 'A2', 'B1', 'B2', 'C1', 'C2');

  for($i = 0; $i < count($languages); $i++) {
    if($i % 2 == 0) {

      $pdf->languagesTable($languages[$i]->language, "Kirjutamine: " . $skillSet[$languages[$i]->writing - 1] . " | Rääkimine: " . $skillSet[$languages[$i]->speaking - 1] . " | Lugemine: " . $skillSet[$languages[$i]->reading - 1], $languages[$i]->info, false);

    } else {

      $pdf->languagesTable($languages[$i]->language, "Kirjutamine: " . $skillSet[$languages[$i]->writing - 1] . " | Rääkimine: " . $skillSet[$languages[$i]->speaking - 1] . " | Lugemine: " . $skillSet[$languages[$i]->reading - 1], $languages[$i]->info, true);

    }
    $pdf->Ln(1);
  }

  if(count($other) > 0) {
    $pdf->printOther();

  }

  for($i = 0; $i < count($other); $i++) {
    if($i % 2 == 0) {

      $pdf->otherTable($other[$i]->positives, $other[$i]->additional, false);

    } else {

      $pdf->otherTable($other[$i]->positives, $other[$i]->additional, true);

    }
    $pdf->Ln(1);
  }

$pdf->Output("", "NTB_".$personal->first."_".$personal->last."_CV", true);
?>
