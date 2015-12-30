<?php
  require_once("functions.php");
  require_once("conf.php");

  if(isset($_GET["logout"])){
    session_destroy();
    header("Location: index.php");
  }
  
  function test_input($data) {  
    $data = trim($data);  //võtab ära tühikud,enterid,tabid
    $data = stripslashes($data);  //võtab ära tagurpidi kaldkriipsud
    $data = htmlspecialchars($data);  //teeb htmli tekstiks, nt < läheb &lt
    return $data;
  }
?>

 <?php require('layout/headerloggedinw.php');  ?>
         <div id="tab-container" class="tab-container">
          <!-- Tab List -->
            <ul class='etabs'>
                <li class='tab' id="tab-kichen">
                  <a href="#kichen"><i class="icon-user"></i><span> Tellimused</span></a>
                </li>
                <li class='tab' id="tab-grade">
                  <a href="#grade"><i class="icon-file-text"></i><span> Hinded antud</span></a>
                </li>
            </ul>
        <div id="tab-data-wrap">
              <!-- kichen Tab Data -->
          <div id="kichen">
              <section class="clearfix">
						<section>
							<div id="menu">
                               <?php
									if(isset($_REQUEST['muuda_sooki'])) {
										$sookid = $_REQUEST['sook'];
										$q = 'UPDATE tellimus_toit SET staatus=1 WHERE tellimus_toit_ID=?';
										$uuenda = $yhendus->prepare($q);
										$uuenda->bind_param('i', $sookid);
										$uuenda->execute();
										$uuenda->close();
										header('Location: '.$_SERVER['PHP_SELF']);
									}
	                                if(isset($_REQUEST['saada_lauda'])) {
	                                    $tellimusid = $_REQUEST['tellimusID'];
	                                    $q = 'UPDATE tellimus SET staatus=3 WHERE tellimusID=?';
	                                    $uuenda = $yhendus->prepare($q);
	                                    $uuenda->bind_param('i', $tellimusid);
	                                    $uuenda->execute();
	                                    $uuenda->close();
	                                }
										$q = 'SELECT tellimusID as  tID FROM tellimus WHERE staatus=1';
										$tellimus = $yhendus->prepare($q);
										$tellimus->execute();
										$tellimus->bind_result($tID);    
										$hoidla=array();
										$i = 0;
										while($tellimus->fetch()){
											$i++;
											$hoidla[$i] = $tID;
										}
										$tellimus->close();
										$valmis = 1;
										for($j = $i; $j>0; $j--) {
											$q = 'SELECT t.tellimus_toit_ID, t.staatus, m.nimi, m.hind, t.kogus FROM tellimus_toit t LEFT JOIN menyy m ON m.menyyID=t.menyyID WHERE t.tellimusID=?';
											$toit = $yhendus->prepare($q) or trigger_error($yhendus->error); 
											$toit->bind_param('i', $hoidla[$j]);
											$toit->execute();
											$toit->bind_result($tellimus_toit_ID, $staatus, $nimi, $hind, $kogus);
											echo '<h3>Laua '.$hoidla[$j].' tellimus</h3>
											<ul>';
											$hind_kokku = 0;
											while($toit->fetch()) {
												echo '
												<form action="#">
													<li'; if($staatus != 0) {  echo ' style="text-decoration:line-through;"'; } echo '>'.$nimi.' <strong>'. $kogus.'tk.</strong> Hind: '.($hind*$kogus).'€<input type="hidden" name="sook" value="'.$tellimus_toit_ID.'" />';
														if($staatus == 0) { $valmis = 0;
															echo '<input type="submit" name="muuda_sooki" value="Valmis" />';
														} echo '
													</li>
												</form>';
												$hind_kokku = $hind_kokku + ($hind*$kogus);
											}
											$toit->close();
											echo '</ul><h4>Arve kokku: '. $hind_kokku .'€</h4>';
											if($valmis == 1) { echo '
												<form action="#">
													<input type="hidden" name="tellimusID" value="'.$hoidla[$j].'" />
													<input type="submit" name="saada_lauda" value="Saada lauda" />
												</form><br />';
											}
											$valmis = 1;
										}
        						?>
        						  <div class="break">
								</div>
						</section>
					</div>
			          <div id="grade">
			              <section class="clearfix">
									<section>
										<div id="grade">
										<center>
												<?php

                                    $toiduq = 'SELECT AVG(hinnang) as toidu_keskmine, COUNT(hinnang) as kokku_toit FROM hinnangud_s88k';
                                    $toidu = $yhendus->prepare($toiduq);
                                    $toidu->execute();
                                    $toidu->bind_result($toidu_keskmine, $kokku_toit);
                                    $toidu->fetch();
                                    $toidu->close();

                                    $teenindusq = 'SELECT AVG(hinnang) as teeninduse_keskmine, COUNT(hinnang) as kokku_teenindus FROM hinnangud_tellimus';
                                    $teenindus = $yhendus->prepare($teenindusq);
                                    $teenindus->execute();
                                    $teenindus->bind_result($teeninduse_keskmine, $kokku_teenindus);
                                    $teenindus->fetch();
                                    $teenindus->close();
                                    echo '<h3><p>Püüame ennast parandada Töölised vaatame kuida on teid hinnatud</p><h3>';
                                    
                                    echo '<h4>Toit</h4>
                                    <p>Teenindust on kokku hinnatud '.$kokku_toit.' korda. Keskmise hinde '.round($toidu_keskmine, 1) .' järgi on teenindus ';
                                    if($toidu_keskmine < 1) { echo 'Väga HULLLLLLL.</p>'; }
                                    if($toidu_keskmine < 2) { echo 'Mida Te teete.</p>'; }
                                    if($toidu_keskmine < 3) { echo 'Proovige Paremini.</p>'; }
                                    if($toidu_keskmine < 4) { echo 'Hea Pane täierauaga edasi.</p>'; }
                                    if($toidu_keskmine > 4) { echo 'Supppper jätka samas vaimus.</p>'; }
                                    
                                    echo '<h4>Teenindus</h4>
                                    <p>Teenindust on kokku hinnatud '.$kokku_teenindus.' korda. Keskmise hinde '.round($teeninduse_keskmine, 1) .' järgi on teenindus ';
                                    if($teeninduse_keskmine < 1) { echo 'Väga HULLLLLLL.</p>'; }
                                    if($teeninduse_keskmine < 2) { echo 'Mida Te teete.</p>'; }
                                    if($teeninduse_keskmine < 3) { echo 'Proovige Paremini.</p>'; }
                                    if($teeninduse_keskmine < 4) { echo 'Hea Pane täierauaga edasi.</p>'; }
                                    if($teeninduse_keskmine > 4) { echo 'Supppper jätka samas vaimus.</p>'; }
                                ?>
                                </center>
			        						  <div class="break">
											</div>
									</section>
								</div>
<?php
  $yhendus->close();
?>