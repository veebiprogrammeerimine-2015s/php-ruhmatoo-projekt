
<?php
  require_once("functions.php");
  require_once("conf.php");
  if(!isset($_SESSION["logged_in_user_id"])){
    header("Location: member.php");
  }

  if(isset($_GET["logout"])){
      $q = 'UPDATE rajad SET staatus=0 WHERE ID=1 LIMIT 1';
      $muuda = $yhendus->prepare($q);
      $muuda->bind_param('i',$_REQUEST['rada']);
      $muuda->execute();
      $muuda->close();
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
                <li class='false tab' id="tab-row">
                  <a href="#row "><i class="icon-user" ></i><span> Vali rada</span></a>
                </li>
                <li class='false tab' id="tab-row">
                  <a href="#food"><i class="icon-file-text"></i><span> vali Toit soovil</span></a>
                </li>
                <li class='false tab' id="tab-ready">
                  <a href="#ready"><i class="icon-heart"></i><span> Valmis</span></a>
                </li>
                <li class='tab false' id="tab-grade">
                  <a href="#grade"><i class="icon-envelope"></i><span> Hinda</span></a>
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
                    <form action='#ready'>
                      <input type='hidden' name='rada' value='".$_REQUEST['rajad']."' />
                       <dl>
                       <h4>snaks:</h4>
                      <dd><ul>";
                      $q = 'SELECT menyyID, nimi, hind FROM menyy WHERE tyyp=2';
                      $snak = $yhendus->prepare($q);
                      $snak->execute();
                      $snak->bind_result($menyyID, $nimi, $hind); 
                      $i = 0;
                      while($snak->fetch()) {
                         $i++;
                         echo '<li><input type="hidden" name="snak'.$i.'" value="'.$menyyID.'" />'.$nimi.' - '.$hind.'€ Kogus: 0 <input type="range" name="snak'.$i.'_kogus" value="0" min="0" max="'.$_SESSION['max_kohti'].'" />'.$_SESSION['max_kohti'].'</li>';
                      }
                      $_SESSION['snaks'] = $i;
                      $snak->close();
                      echo "</ul>
                      
                      </dd>
                       
                      <h4>Joogid:</h4>
                      <dd><ul>";
                      $q = 'SELECT menyyID, nimi, hind FROM menyy WHERE tyyp=1';
                      $jook = $yhendus->prepare($q);
                      $jook->execute();
                      $jook->bind_result($menyyID, $nimi, $hind);
                      $j = 0;
                      while($jook->fetch()) {
                        $j++;
                        echo '<li><input type="hidden" name="jook'.$j.'" value="'.$menyyID.'" />'.$nimi.' - '.$hind.'€ Kogus: 0 <input type="range" name="jook'.$j.'_kogus" value="0" min="0" max="'.$_SESSION['max_kohti'].'" />'.$_SESSION['max_kohti'].'</li>';
                      }
                      $_SESSION['Jooke'] = $j;
                      $jook->close();
                      echo "</ul>
                      </dd>
                      
                       <h4>Alko:</h4>
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
                      $_SESSION['alko'] = $k;
                      $magus->close();

                      echo "</ul>
                      </dd>                                    
                      
                      <br>
                        <input class='button' type='submit' name='food' value='Telli' />
                       </dl>
                    </form>";
                    }
                  } 


                ?>
                
              <div class="break">
            </section>
          </div> 
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

                                  $hind_kokku = 0;
                                  $q = 'SELECT m.nimi, m.hind, t.kogus FROM tellimus_toit t LEFT JOIN menyy m ON m.menyyID=t.menyyID WHERE t.tellimusID=?';
                                  $snaks = $yhendus->prepare($q);
                                  $snaks->bind_param('i', $_SESSION['tellimusID']);
                                  $snaks->execute();
                                  $snaks->bind_result($nimi, $hind, $kogus);
                                  echo '<ul>';
                                  while($snaks->fetch()) {
                                    echo '<li>'.$nimi.' '. $kogus.'tk. Hind: '.($hind*$kogus).'€</li>';
                                    $hind_kokku = $hind_kokku + ($hind*$kogus);
                                  }
                                  $snaks->close();
                                  echo '</ul><br /><br /><h3>Arve kokku: '. $hind_kokku .'€</h3>';
                                  
                                  
                                } else {

                                  if(isset($_REQUEST['food'])) {

                                    $q = 'INSERT INTO tellimus SET rajaID=?, staatus=1';
                                    $lisa = $yhendus->prepare($q);
                                    $lisa->bind_param('i', $_REQUEST['rada']);
                                    $lisa->execute() or trigger_error($lisa->error); 
                                    $_SESSION['tellimusID'] = $lisa->insert_id;
                                    $lisa->close();

                                    $q = 'UPDATE rajad SET staatus=1 WHERE ID=? LIMIT 1';
                                    $muuda = $yhendus->prepare($q);
                                    $muuda->bind_param('i',$_REQUEST['rada']);
                                    $muuda->execute();
                                    $muuda->close();

                                    for($i = 1; $i <= $_SESSION['snaks']; $i++) {
                                      if($_REQUEST['snak'.$i.'_kogus'] != 0) {
                                        $lisapq = 'INSERT INTO tellimus_toit SET tellimusID=?, menyyID=?, kogus=?';
                                        $lisap = $yhendus->prepare($lisapq);
                                        $lisap->bind_param('iii', $_SESSION['tellimusID'], $_REQUEST['snak'.$i], $_REQUEST['snak'.$i.'_kogus']);
                                        $lisap->execute();
                                        $lisap->close();
                                      }
                                    }

                                    for($j = 1; $j <= $_SESSION['Jooke']; $j++) {
                                      if($_REQUEST['jook'.$j.'_kogus'] != 0) {
                                        $lisasq = 'INSERT INTO tellimus_toit SET tellimusID=?, menyyID=?, kogus=?';
                                        $lisas = $yhendus->prepare($lisasq);
                                        $lisas->bind_param('iii', $_SESSION['tellimusID'], $_REQUEST['jook'.$j], $_REQUEST['jook'.$j.'_kogus']);
                                        $lisas->execute();
                                        $lisas->close();
                                      }
                                    }

                                    for($k = 1; $k <= $_SESSION['alko']; $k++) {
                                      if($_REQUEST['mt'.$k.'_kogus'] != 0) {
                                        $lisamtq = 'INSERT INTO tellimus_toit SET tellimusID=?, menyyID=?, kogus=?';
                                        $lisamt = $yhendus->prepare($lisamtq);
                                        $lisamt->bind_param('iii', $_SESSION['tellimusID'], $_REQUEST['mt'.$k], $_REQUEST['mt'.$k.'_kogus']);
                                        $lisamt->execute();
                                        $lisamt->close();
                                      }
                                    }
                                    
                                  }
                                  
                                }                              

                                  if(!isset($_SESSION['tellimusID'])) { $_SESSION['tellimusID'] = ''; }
                                  if($_SESSION['tellimusID'] != '') {
                                    if(isset($_REQUEST['maksa'])) {
                                        $muudaq = 'UPDATE tellimus SET staatus=4 WHERE tellimusID=? AND staatus=3';
                                        $muuda = $yhendus->prepare($muudaq);
                                        $muuda->bind_param('i', $_SESSION['tellimusID']);
                                        $muuda->execute() or trigger_error(mysql_error());
                                        $muuda->close();
                                        
                                    }

                                    $q = 'SELECT tellimusID, staatus as tellimus_staatus FROM tellimus WHERE tellimusID=?';
                                    $tellimus = $yhendus->prepare($q);
                                    $tellimus->bind_param('i', $_SESSION['tellimusID']);
                                    $tellimus->execute();
                                    $tellimus->bind_result($tellimusID, $tellimus_staatus);
                                    $tellimus->fetch();
                                    if($tellimus_staatus == 5) {
                                        session_destroy();
                                        exit();
                                    }
                                    $tellimus->close();

                  

                                    
                                    //Laseme maksta kliendil arve, kui staatus on 2(köögist siia saadetud)
                                    if($tellimus_staatus == 3) {
                                        echo '
                                        <form action="#ready">
                                            <input type="submit" name="maksa" value="Maksa arve" />
                                        </form><br />';
                                    }
                                    elseif($tellimus_staatus == 4) {
                                        echo '<p style="color: green;">Arve makstud</p><p>kuid enne,<p><a href="#grade"> Hinda tellimusi </a>';
                                    } else {
                                        echo '<p>Tellimus on veel täitmisel</p>';
                                    }
                                  }
                              ?>
                              
                        <div class="break">
                    </section>
                </div> 
                <div id="grade">
                    <section class="clearfix">
                       <div class="g1">
                        <?php
                                    //Lubame hinnata sööki
                                    if(isset($_REQUEST['hinda_s88k'])) {
                                        //Kontrollime, et hinne on ikkagi number(et ei esitataks "Vali hinne")
                                        if(is_numeric($_REQUEST['hinne'])) {
                                            //Lisame hinnangu tabelisse
                                            $lisaq = 'INSERT INTO hinnangud_s88k SET tellimusID=?, hinnang=?, lisatud=NOW()';
                                            $lisa = $yhendus->prepare($lisaq);
                                            $lisa->bind_param('is', $_SESSION['tellimusID'], $_REQUEST['hinne']);
                                            $lisa->execute();
                                            $lisa->close();
                                            echo '<div style="color: green;">Hinnang söögile lisatud</div>';
                                        }
                                    }
                                    
                                    //Hinda teenindust
                                    //Lubame hinnata sööki
                                    if(isset($_REQUEST['hinda_teenindus'])) {
                                        //Kontroll
                                        if(is_numeric($_REQUEST['hinne'])) {
                                            //Lisame hinnangu tabelisse
                                            $lisaq = 'INSERT INTO hinnangud_tellimus SET tellimusID=?, hinnang=?, lisatud=NOW()';
                                            $lisa = $yhendus->prepare($lisaq);
                                            $lisa->bind_param('is', $_SESSION['tellimusID'], $_REQUEST['hinne']);
                                            $lisa->execute();
                                            $lisa->close();
                                            echo '<div style="color: green;">Hinnang teenindusele lisatud</div>';
                                        }
                                    }
                          if($tellimus_staatus == 3 || $tellimus_staatus == 4) {
                              echo '
                              <h2>Hinda sööki</h2>
                              <form action="#grade">
                                  <select name="hinne">
                                      <option>Vali hinne</option>
                                      <option value="5">5</option>
                                      <option value="4">4</option>
                                      <option value="3">3</option>
                                      <option value="2">2</option>
                                      <option value="1">1</option>
                                  </select>
                                  <input type="submit" name="hinda_s88k" value="Hinda sööki" />
                              </form><br />';
                          }
                          echo '
                          <h2>Hinda teenindust</h2>
                          <form action="#grade">
                              <select name="hinne">
                                  <option>Vali hinne</option>
                                  <option value="5">5</option>
                                  <option value="4">4</option>
                                  <option value="3">3</option>
                                  <option value="2">2</option>
                                  <option value="1">1</option>
                              </select>
                              <input type="submit" name="hinda_teenindus" value="Hinda tellmust" />
                          </form>';
                        ?>
                       <div class="break"></div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>