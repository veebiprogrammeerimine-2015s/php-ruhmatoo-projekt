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
                <li class='tab' id="tab-row">
                  <a href="#row"><i class="icon-user"></i><span> Vali rada</span></a>
                </li>
                <li class='tab' id="tab-food">
                  <a href="#food"><i class="icon-file-text"></i><span> vali Toit soovil</span></a>
                </li>
                <li class='tab'>
                  <a href="#ready"><i class="icon-heart"></i><span> Valmis</span></a>
                </li>
                <li class='tab'>
                  <a href="#contact"><i class="icon-envelope"></i><span> kontaktid</span></a>
                </li>
            </ul>
          <!-- End Tab List -->
            <div id="tab-data-wrap">
              <!-- row Tab Data -->
          <div id="row">
              <section class="clearfix">
		<div id="main">
			<div class="container">
				<div class="row main-row">
					<div class="12u">
						<section>
							<div id="menyykiht">
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
								</div>
						</section>
					</div>
				</div>
			</div>
		</div>
<?php
  $yhendus->close();
?>