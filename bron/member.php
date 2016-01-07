<?php
  require_once("functions.php");
  require_once("../../config.php");
  require('layout/header.php'); 
  function test_input($data) {  
    $data = trim($data);  //võtab ära tühikud,enterid,tabid
    $data = stripslashes($data);  //võtab ära tagurpidi kaldkriipsud
    $data = htmlspecialchars($data);  //teeb htmli tekstiks, nt < läheb &lt
    return $data;
  }
    if(!isset($_SESSION["logged_in_user_id"])){
    header("Location: member.php");
  }
    if(isset($_GET["logout"])){
  $q = 'UPDATE rows_t SET staatus_t=0 WHERE staatus_t=1 LIMIT 1';
   $change = $connection->prepare($q);
   $change->bind_param('i',$_REQUEST['row']);
   $change->execute();
   $change->close();
     session_destroy();
      header("Location: index.php");
  }
  ?>
        <header id="header">
            <div id="logo">
                <h2>
                    Bowling
                </h2>
                <h4>
                  <p>Tere, 
                  <?=$_SESSION["logged_in_user_username"];?>
                  <p><a href="?logout=1"> Lõpeta Mängimine </a>
                </h4>
            </div>
        </header>

        <!-- Main Tab Container -->

        <div id="tab-container" class="tab-container">
          <!-- Tab List -->
            <ul class='etabs'>
                <li class='false tab' id="tab-row">
                  <a href="#row "><i class="icon-user" ></i><span> Vali rada</span></a>
                </li>
                <li class='false tab' id="tab-row">
                  <a href="#food"><i class="icon-file-text"></i><span> vali toit soovil</span></a>
                </li>
                <li class='false tab' id="tab-ready">
                  <a href="#ready"><i class="icon-heart"></i><span> Valmis</span></a>
                </li>
                <li class='tab false' id="tab-grade">
                  <a href="#grade"><i class="icon-envelope"></i><span> hinda</span></a>
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
                        $q = 'SELECT ID, seats_t FROM rows_t WHERE staatus_t=0';
                        $rows = $connection->prepare($q);
                        $rows->execute();
                        $rows->store_result();
                        $free = $rows->num_rows;
                        if($free == 0) {
                          echo 'Vabandame, hetkel pole ühtegi vaba rada.';
                        } else { echo "
                            <select name='rows'>
                            <option></option>";
                            $rows->bind_result($ID, $seats);                            
                            while($rows->fetch()) {
                              echo '<option value="'.$ID.'">'.$seats.' kohaga rada</option>';
                          }
                          $rows->close();
                          echo "
                           </select>";
                        } echo"
                        </dd>                                   
                        <br>
                        <input"; if($free == 0) { echo " disabled='disabled' "; } echo" class='button' type='submit' name='row' value='Edasi' />
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
                  if(isset($_REQUEST['rows'])) {
                    if($_REQUEST['rows'] != '') {
                    $row = $connection->prepare('SELECT seats_t FROM rows_t WHERE ID=?');
                    $row->bind_param('i',$_REQUEST['rows']);
                    $row->execute();
                    $row->bind_result($seats);
                    $row->fetch();
                    $_SESSION['max_seats'] = $seats;
                    $row->close();
                    echo "
                    <p>Valisite ".$_SESSION['max_seats']." kohaga raja. <a href='member.php'>Muuda</a></p>
                    <h3>Vali menüüst</h3>
                    <form action='#ready'>
                      <input type='hidden' name='row' value='".$_REQUEST['rows']."' />
                       <dl>
                       <h4>snaks:</h4>
                      <dd><ul>";
                      $q = 'SELECT menuID_t, name_t, price_t FROM menu_t WHERE type_t=2';
                      $snak = $connection->prepare($q);
                      $snak->execute();
                      $snak->bind_result($menuID, $name, $price); 
                      $i = 0;
                      while($snak->fetch()) {
                         $i++;
                         echo '<li><input type="hidden" name="snak'.$i.'" value="'.$menuID.'" />'.$name.' - '.$price.'€ Kogus: 0 <input type="range" name="snak'.$i.'_amount" value="0" min="0" max="'.$_SESSION['max_seats'].'" />'.$_SESSION['max_seats'].'</li>';
                      }
                      $_SESSION['snaks'] = $i;
                      $snak->close();
                      echo "</ul>
                      
                      </dd>
                       
                      <h4>Joogid:</h4>
                      <dd><ul>";
                      $q = 'SELECT menuID_t, name_t, price_t FROM menu_t WHERE type_t=1';
                      $drink = $connection->prepare($q);
                      $drink->execute();
                      $drink->bind_result($menuID, $name, $price);
                      $j = 0;
                      while($drink->fetch()) {
                        $j++;
                        echo '<li><input type="hidden" name="drink'.$j.'" value="'.$menuID.'" />'.$name.' - '.$price.'€ Kogus: 0 <input type="range" name="drink'.$j.'_amount" value="0" min="0" max="'.$_SESSION['max_seats'].'" />'.$_SESSION['max_seats'].'</li>';
                      }
                      $_SESSION['drinks'] = $j;
                      $drink->close();
                      echo "</ul>
                      </dd>
                      
                       <h4>vodka:</h4>
                      <dd><ul>";
                      $q = 'SELECT menuID_t, name_t, price_t FROM menu_t WHERE type_t=3';
                      $sweet = $connection->prepare($q);
                      $sweet->execute();
                      $sweet->bind_result($menuID, $name, $price);
                      $k = 0;
                      while($sweet->fetch()) {
                        $k++;
                        echo '<li><input type="hidden" name="mt'.$k.'" value="'.$menuID.'" />'.$name.' - '.$price.'€ Kogus: 0 <input type="range" name="mt'.$k.'_amount" value="0" min="0" max="'.$_SESSION['max_seats'].'" />'.$_SESSION['max_seats'].'</li>';
                      }
                      $_SESSION['vodka'] = $k;
                      $sweet->close();
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
                                //service on algul puudu, notice vältimine
                                if(!isset($_SESSION['orderID'])) { $_SESSION['orderID'] = ''; }
                                //tellimus haldamine
                                if($_SESSION['orderID'] != '') {
                                  $q = 'SELECT orderID_t FROM order_t WHERE orderID_t=?';
                                  $service = $connection->prepare($q);
                                  $service->bind_param('i', $_SESSION['orderID']);
                                  $service->execute();
                                  $service->bind_result($orderID);
                                  $service->fetch();
                                  $service->close();
                                  echo '<h3>tellimuse '.$orderID.' tellimus</h3>';
                                  $price_total = 0;
                                  $q = 'SELECT m.name_t, m.price_t, t.amount_t FROM order_food_t t LEFT JOIN menu_t m ON m.menuID_t=t.menuID_t WHERE t.orderID_t=?';
                                  $snaks = $connection->prepare($q);
                                  $snaks->bind_param('i', $_SESSION['orderID']);
                                  $snaks->execute();
                                  $snaks->bind_result($name, $price, $amount);
                                  echo '<ul>';
                                  while($snaks->fetch()) {
                                    echo '<li>'.$name.' '. $amount.'tk. Hind: '.($price*$amount).'€</li>';
                                    $price_total = $price_total + ($price*$amount);
                                  }
                                  $snaks->close();
                                  echo '</ul><br /><br /><h3>Arve kokku: '. $price_total .'€</h3>';
                                  
                                  
                                } else {
                                  if(isset($_REQUEST['food'])) {
                                    $q = 'INSERT INTO order_t SET rowID_t=?, staatus_t=1';
                                    $add = $connection->prepare($q);
                                    $add->bind_param('i', $_REQUEST['row']);
                                    $add->execute() or trigger_error($add->error); 
                                    $_SESSION['orderID'] = $add->insert_id;
                                    $add->close();
                                   $q = 'UPDATE rows_t SET staatus_t=1 WHERE ID=? LIMIT 1';
                                    $change = $connection->prepare($q);
                                    $change->bind_param('i',$_REQUEST['row']);
                                    $change->execute();
                                    $change->close();
                                    for($i = 1; $i <= $_SESSION['snaks']; $i++) {
                                      if($_REQUEST['snak'.$i.'_amount'] != 0) {
                                        $addpq = 'INSERT INTO order_food_t SET orderID_t=?, menuID_t=?, amount_t=?';
                                        $addp = $connection->prepare($addpq);
                                        $addp->bind_param('iii', $_SESSION['orderID'], $_REQUEST['snak'.$i], $_REQUEST['snak'.$i.'_amount']);
                                        $addp->execute();
                                        $addp->close();
                                      }
                                    }
                                    for($j = 1; $j <= $_SESSION['drinks']; $j++) {
                                      if($_REQUEST['drink'.$j.'_amount'] != 0) {
                                        $addsq = 'INSERT INTO order_food_t SET orderID_t=?, menuID_t=?, amount_t=?';
                                        $adds = $connection->prepare($addsq);
                                        $adds->bind_param('iii', $_SESSION['orderID'], $_REQUEST['drink'.$j], $_REQUEST['drink'.$j.'_amount']);
                                        $adds->execute();
                                        $adds->close();
                                      }
                                    }
                                    for($k = 1; $k <= $_SESSION['vodka']; $k++) {
                                      if($_REQUEST['mt'.$k.'_amount'] != 0) {
                                        $addmtq = 'INSERT INTO order_food_t SET orderID_t=?, menuID_t=?, amount_t=?';
                                        $addmt = $connection->prepare($addmtq);
                                        $addmt->bind_param('iii', $_SESSION['orderID'], $_REQUEST['mt'.$k], $_REQUEST['mt'.$k.'_amount']);
                                        $addmt->execute();
                                        $addmt->close();
                                      }
                                    }
                                    
                                  }
                                  
                                }                              
                                  if(!isset($_SESSION['orderID'])) { $_SESSION['orderID'] = ''; }
                                  if($_SESSION['orderID'] != '') {
                                    if(isset($_REQUEST['pay'])) {
                                        $changeq = 'UPDATE order_t SET staatus_t=4 WHERE orderID_t=? AND staatus_t=3';
                                        $change = $connection->prepare($changeq);
                                        $change->bind_param('i', $_SESSION['orderID']);
                                        $change->execute() or trigger_error(mysql_error());
                                        $change->close();
                                        
                                    }
                                    $q = 'SELECT orderID_t, staatus_t as order_staatus FROM order_t WHERE orderID_t=?';
                                    $service = $connection->prepare($q);
                                    $service->bind_param('i', $_SESSION['orderID']);
                                    $service->execute();
                                    $service->bind_result($orderID, $service_status);
                                    $service->fetch();
                                    if($service_status == 5) {
                                        session_destroy();
                                        exit();
                                    }
                                    $service->close();
                  
                                    
                                    //Laseme maksta kliendil arve, kui status on 2(köögist siia saadetud)
                                    if($service_status == 3) {
                                        echo '
                                        <form action="#ready">
                                            <input type="submit" name="pay" value="Maksa arve" />
                                        </form><br />';
                                    }
                                    elseif($service_status == 4) {
                                        echo '<p style="color: green;">Arve makstud</p><p>kuid enne,<p><a href="#grade"> hinda tellimust </a>';
                                    } else {
                                        echo '<p style="color: red;">tellimus on veel täitmisel</p>';
                                    }
                                  }
                              ?>
                              
                        <div class="break">
                    </section>
                </div> 
                <div id="grade">
                    <section class="clearfix">

                        <?php
                                    //Lubame hinnata sööki
                                    if(isset($_REQUEST['grade_food'])) {
                                        //Kontrollime, et hinne on ikkagi number(et ei esitataks "Vali hinne")
                                        if(is_numeric($_REQUEST['grade'])) {
                                            //addme hinnangu tabelisse
                                            $addq = 'INSERT INTO grade_food_t SET orderID_t=?, grade_t=?, submited_t=NOW()';
                                            $add = $connection->prepare($addq);
                                            $add->bind_param('is', $_SESSION['orderID'], $_REQUEST['grade']);
                                            $add->execute();
                                            $add->close();
                                            echo '<center><div style="color: green;">Hinnang söögile lisatud</div></center>';
                                        }
                                    }
                                    
                                    //Lubame hinnata sööki
                                    if(isset($_REQUEST['grade_service'])) {
                                        //Kontroll
                                        if(is_numeric($_REQUEST['grade'])) {
                                            //addme hinnangu tabelisse
                                            $addq = 'INSERT INTO grade_service_t SET orderID_t=?, grade_t=?, submited_t=NOW()';
                                            $add = $connection->prepare($addq);
                                            $add->bind_param('is', $_SESSION['orderID'], $_REQUEST['grade']);
                                            $add->execute();
                                            $add->close();
                                            echo '<center><div style="color: green;">Hinnang teenindusele lisatud</div></center>';
                                        }
                                    }
                          if($service_status == 3 || $service_status == 4) {
                              echo '
                              <center>
                              <h3>hinda sööki</h3>
                              <form action="#grade">
                                  <select name="grade">
                                      <option>Vali hinne</option>
                                      <option value="5">5</option>
                                      <option value="4">4</option>
                                      <option value="3">3</option>
                                      <option value="2">2</option>
                                      <option value="1">1</option>
                                  </select>
                                  <input type="submit" name="grade_food" value="hinda sööki" />
                              </form><br /></center>';
                          }
                          echo '<center>
                          <h3>hinda teenindust</h3>
                          <form action="#grade">
                              <select name="grade">
                                  <option>Vali hinne</option>
                                  <option value="5">5</option>
                                  <option value="4">4</option>
                                  <option value="3">3</option>
                                  <option value="2">2</option>
                                  <option value="1">1</option>
                              </select>
                              <input type="submit" name="grade_service" value="hinda tellimust" />
                          </form></center>';
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
<?php require('layout/footer.php');  ?>