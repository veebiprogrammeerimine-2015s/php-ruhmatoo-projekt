<?php
  require_once("functions.php");


  require_once("conf.php");
    if(!isset($_SESSION["logged_in_user_id"])){
    header("Location: member.php");
  }
  
  if(isset($_GET["s88k"])){
    header("Location: member.php#ready");
  }


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
 <?php require('layout/headerloggedin.php');  ?>

        <!-- Main Tab Container -->

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
                <?php

                  echo "
                    <form action='#food'>
                       <dl>
                      <dt style='font-weight: bold;'>Valige rada:</dt>
                      <dd>";
                        $q = 'SELECT ID, kohti FROM rajad WHERE staatus=0';
                        $rajad = $yhendus->prepare($q);
                        $rajad->execute();
                        //Vaatame, kas on üldse vabu radau
                        $rajad->store_result();
                        $vabu = $rajad->num_rows;
                        if($vabu == 0) {
                          echo 'Vabandame, hetkel pole ühtegi vaba rada.';
                        } else { echo "
                          <select name='rajad'>
                          <option></option>";
                          $rajad->bind_result($ID, $kohti);                            
                          while($rajad->fetch()) {
                            echo '<option value="'.$ID.'">'.$kohti.' kohaga rada</option>';
                          }
                          $rajad->close();
                          echo "
                           </select>";
                        } echo"

                      </dd>                                   
                      
                      <br>
                        <input"; if($vabu == 0) { echo " disabled='disabled' "; } echo" class='button' type='submit' name='rada' value='Edasi' />
                       </dl>
                    </form>";
                ?>
                  <div class="break">
              </section>
          </div>  
              <!-- End row Tab Data -->
              <!-- food Tab Data -->
          <div id="food">
            <section class="clearfix">
            
                <?php
                  //Tekitame rajale söökide valiku
                  if(isset($_REQUEST['rajad'])) {
                    if($_REQUEST['rajad'] != '') {
                    $rada = $yhendus->prepare('SELECT kohti FROM rajad WHERE ID=?');
                    $rada->bind_param('i',$_REQUEST['rajad']);
                    $rada->execute();
                    $rada->bind_result($kohti);
                    $rada->fetch();
                    $_SESSION['max_kohti'] = $kohti;
                    $rada->close();

                    echo "
                    <p>Valisite ".$_SESSION['max_kohti']." kohaga raja. <a href='member.php'>Muuda</a></p>
                    <h3>Vali menüüst</h3>
                    <form action='#'>
                      <input type='hidden' name='rada' value='".$_REQUEST['rajad']."' />
                       <dl>
                       <h4>Praed:</h4>
                      <dd><ul>";
                      $q = 'SELECT menyyID, nimi, hind FROM menyy WHERE tyyp=2';
                      $praad = $yhendus->prepare($q);
                      $praad->execute();
                      $praad->bind_result($menyyID, $nimi, $hind); 
                      $i = 0;
                      while($praad->fetch()) {
                         $i++;
                         echo '<li><input type="hidden" name="praad'.$i.'" value="'.$menyyID.'" />'.$nimi.' - '.$hind.'€ Kogus: 0 <input type="range" name="praad'.$i.'_kogus" value="0" min="0" max="'.$_SESSION['max_kohti'].'" />'.$_SESSION['max_kohti'].'</li>';
                      }
                      $_SESSION['praade'] = $i;
                      $praad->close();
                      echo "</ul>
                      
                      </dd>
                       
                      <h4>Supid:</h4>
                      <dd><ul>";
                      $q = 'SELECT menyyID, nimi, hind FROM menyy WHERE tyyp=1';
                      $supp = $yhendus->prepare($q);
                      $supp->execute();
                      $supp->bind_result($menyyID, $nimi, $hind);
                      $j = 0;
                      while($supp->fetch()) {
                        $j++;
                        echo '<li><input type="hidden" name="supp'.$j.'" value="'.$menyyID.'" />'.$nimi.' - '.$hind.'€ Kogus: 0 <input type="range" name="supp'.$j.'_kogus" value="0" min="0" max="'.$_SESSION['max_kohti'].'" />'.$_SESSION['max_kohti'].'</li>';
                      }
                      $_SESSION['suppe'] = $j;
                      $supp->close();
                      echo "</ul>
                      </dd>
                      
                       <h4>Magustoit:</h4>
                      <dd><ul>";
                      $q = 'SELECT menyyID, nimi, hind FROM menyy WHERE tyyp=3';
                      $magus = $yhendus->prepare($q);
                      $magus->execute();
                      $magus->bind_result($menyyID, $nimi, $hind);
                      $k = 0;


                      while($magus->fetch()) {
                        $k++;
                        echo '<li><input type="hidden" name="mt'.$k.'" value="'.$menyyID.'" />'.$nimi.' - '.$hind.'€ Kogus: 0 <input type="range" name="mt'.$k.'_kogus" value="0" min="0" max="'.$_SESSION['max_kohti'].'" />'.$_SESSION['max_kohti'].'</li>';
                      }
                      $_SESSION['magustoite'] = $k;
                      $magus->close();

                      echo "</ul>
                      </dd>                                    
                      
                      <br>
                        <input class='button' type='submit' name='s88k' value='Telli' />
                       </dl>
                    </form>";
                    }
                  } 


                ?>
                
              <div class="break">
            </section>
          </div> 
              <!-- End food Tab Data -->
              <!-- pildid Tab Data -->
                   <div id="ready">
                          <section class="clearfix">
                              <?php

                                //tellimus on algul puudu, notice vältimine
                                if(!isset($_SESSION['tellimusID'])) { $_SESSION['tellimusID'] = ''; }
                                //Tellimuse haldamine
                                if($_SESSION['tellimusID'] != '') {
                                  $q = 'SELECT tellimusID FROM tellimus WHERE tellimusID=?';
                                  $tellimus = $yhendus->prepare($q);
                                  $tellimus->bind_param('i', $_SESSION['tellimusID']);
                                  $tellimus->execute();
                                  $tellimus->bind_result($tellimusID);
                                  $tellimus->fetch();
                                  $tellimus->close();
                                  echo '<h3>tellimuse '.$tellimusID.' tellimus</h3>';
                                  //Kuvame tellimused
                                  
                                  $hind_kokku = 0;
                                  $q = 'SELECT m.nimi, m.hind, t.kogus FROM tellimus_toit t LEFT JOIN menyy m ON m.menyyID=t.menyyID WHERE t.tellimusID=?';
                                  $praed = $yhendus->prepare($q);
                                  $praed->bind_param('i', $_SESSION['tellimusID']);
                                  $praed->execute();
                                  $praed->bind_result($nimi, $hind, $kogus);
                                  echo '<ul>';
                                  while($praed->fetch()) {
                                    echo '<li>'.$nimi.' '. $kogus.'tk. Hind: '.($hind*$kogus).'€</li>';
                                    $hind_kokku = $hind_kokku + ($hind*$kogus);
                                  }
                                  $praed->close();
                                  echo '</ul><br /><br /><h3>Arve kokku: '. $hind_kokku .'€</h3>';
                                  session_destroy();
                                  
                                } else {
                                  //Lisame tellimuse andmebaasi
                                  if(isset($_REQUEST['s88k'])) {
                                    //Lisame tellimuse
                                    $q = 'INSERT INTO tellimus SET rajaID=?, staatus=1';
                                    $lisa = $yhendus->prepare($q);
                                    $lisa->bind_param('i', $_REQUEST['rada']);
                                    $lisa->execute() or trigger_error($lisa->error); 
                                    $_SESSION['tellimusID'] = $lisa->insert_id;
                                    $lisa->close();
                                    //Muudame raja staatust
                                    $q = 'UPDATE rajad SET staatus=1 WHERE ID=? LIMIT 1';
                                    $muuda = $yhendus->prepare($q);
                                    $muuda->bind_param('i',$_REQUEST['rada']);
                                    $muuda->execute();
                                    $muuda->close();
                                    //Praed
                                    for($i = 1; $i <= $_SESSION['praade']; $i++) {
                                      if($_REQUEST['praad'.$i.'_kogus'] != 0) {
                                        $lisapq = 'INSERT INTO tellimus_toit SET tellimusID=?, menyyID=?, kogus=?';
                                        $lisap = $yhendus->prepare($lisapq);
                                        $lisap->bind_param('iii', $_SESSION['tellimusID'], $_REQUEST['praad'.$i], $_REQUEST['praad'.$i.'_kogus']);
                                        $lisap->execute();
                                        $lisap->close();
                                      }
                                    }
                                    //Supid
                                    for($j = 1; $j <= $_SESSION['suppe']; $j++) {
                                      if($_REQUEST['supp'.$j.'_kogus'] != 0) {
                                        $lisasq = 'INSERT INTO tellimus_toit SET tellimusID=?, menyyID=?, kogus=?';
                                        $lisas = $yhendus->prepare($lisasq);
                                        $lisas->bind_param('iii', $_SESSION['tellimusID'], $_REQUEST['supp'.$j], $_REQUEST['supp'.$j.'_kogus']);
                                        $lisas->execute();
                                        $lisas->close();
                                      }
                                    }
                                    //Magustoidud
                                    for($k = 1; $k <= $_SESSION['magustoite']; $k++) {
                                      if($_REQUEST['mt'.$k.'_kogus'] != 0) {
                                        $lisamtq = 'INSERT INTO tellimus_toit SET tellimusID=?, menyyID=?, kogus=?';
                                        $lisamt = $yhendus->prepare($lisamtq);
                                        $lisamt->bind_param('iii', $_SESSION['tellimusID'], $_REQUEST['mt'.$k], $_REQUEST['mt'.$k.'_kogus']);
                                        $lisamt->execute();
                                        $lisamt->close();
                                      }
                                    }
                                    
                                    //session_destroy();
                                  }
                                  
                                }

                              ?>
                              
                        <div class="break">
                    </section>
                </div> 

              <!-- End pildid Data -->
              <!-- Contact Tab Data -->
                <div id="contact">
                    <section class="clearfix">
                       <div class="g1">
                         <div class="sny-icon-box">
                           <div class="sny-icon">
                              <i class="icon-globe"></i>
                            </div>
                            <div class="sny-icon-content">
                              <h4>Aadress</h4>
                              <p>kauntari 12b</p>
                            </div>
                         </div>
                       </div>
                       <div class="g1">
                         <div class="sny-icon-box">
                           <div class="sny-icon">
                              <i class="icon-phone"></i>
                            </div>
                            <div class="sny-icon-content">
                              <h4>Telefon</h4>
                              <p>5600399<br/>609883273</p>
                            </div>
                         </div>
                       </div>
                       <div class="g1">
                         <div class="sny-icon-box">
                           <div class="sny-icon">
                              <i class="icon-user"></i>
                            </div>
                            <div class="sny-icon-content">
                              <h4>Meist</h4>
                              <p>Oleme 5 tärni bowling kus saad lõbusalt aega veeta broneerimiseks loggi sisse</p>
                            </div>
                         </div>
                       </div>
                       <div class="break"></div>
                       
                    </section>
                </div>
              <!-- End Contact Data -->
            </div>
        </div>
        <!-- End Tab Container -->

    </div><!-- #main -->
</div><!-- #main-container -->



</body>
</html>