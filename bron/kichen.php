<?php
  require_once("functions.php");
  require_once("../../config.php");

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

 <?php require('layout/header.php');  ?>
         <header id="header">
            <div id="logo">
                <h2>
                    Bowling
                </h2>
                <h4>
                    <p>Tere, <?=$_SESSION["logged_in_userW_username"];?>
                      <a href="?logout=1"> Logi välja </a>
                </h4>
            </div>
        </header>
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
							<div id="menu">
							<center>
                               <?php
									if(isset($_REQUEST['change_food'])) {
										$foodid = $_REQUEST['food'];
										$q = 'UPDATE order_food_t SET staatus_t=1 WHERE order_food_ID_t=?';
										$upgrade = $connection->prepare($q);
										$upgrade->bind_param('i', $foodid);
										$upgrade->execute();
										$upgrade->close();
										header('Location: '.$_SERVER['PHP_SELF']);
									}
	                                if(isset($_REQUEST['send_table'])) {
	                                    $orderid = $_REQUEST['orderID'];
	                                    $q = 'UPDATE order_t SET staatus_t=3 WHERE orderID_t=?';
	                                    $upgrade = $connection->prepare($q);
	                                    $upgrade->bind_param('i', $orderid);
	                                    $upgrade->execute();
	                                    $upgrade->close();
	                                }
										$q = 'SELECT orderID_t as  tID FROM order_t WHERE staatus_t=1';
										$order = $connection->prepare($q);
										$order->execute();
										$order->bind_result($tID);    
										$repository=array();
										$i = 0;
										while($order->fetch()){
											$i++;
											$repository[$i] = $tID;
										}
										$order->close();
										$ready = 1;
										for($j = $i; $j>0; $j--) {
											$q = 'SELECT t.order_food_ID_t, t.staatus_t, m.name_t, m.price_t, t.amount_t FROM order_food_t t LEFT JOIN menu_t m ON m.menuID_t=t.menuID_t WHERE t.orderID_t=?';
											$food = $connection->prepare($q) or trigger_error($connection->error); 
											$food->bind_param('i', $repository[$j]);
											$food->execute();
											$food->bind_result($order_food_ID, $status, $name, $price, $amount);
											echo '<h3>Laua '.$repository[$j].' tellimus</h3>
											<ul>';
											$price_total = 0;
											while($food->fetch()) {
												echo '
												<form action="#">
													<li'; if($status != 0) {  echo ' style="text-decoration:line-through;"'; } echo '>'.$name.' <strong>'. $amount.'tk.</strong> Hind: '.($price*$amount).'€<input type="hidden" name="food" value="'.$order_food_ID.'" />';
														if($status == 0) { $ready = 0;
															echo '<input type="submit" name="change_food" value="Valmis" />';
														} echo '
													</li>
												</form>';
												$price_total = $price_total + ($price*$amount);
											}
											$food->close();
											echo '</ul><h4>Arve kokku: '. $price_total .'€</h4>';
											if($ready == 1) { echo '
												<form action="#">
													<input type="hidden" name="orderID" value="'.$repository[$j].'" />
													<input type="submit" name="send_table" value="Saada lauda" />
												</form><br />';
											}
											$ready = 1;
										}
										if(''){
											echo "Pole tellimusi";
										}


        						?>
        						</center>
        						  <div class="break">
								</div>
						</section>
					</div>
			          <div id="grade">
			              <section class="clearfix">
										<div id="grade">
										<center>
												<?php

                                    $foodsq = 'SELECT AVG(grade_t) as toidu_keskmine, COUNT(grade_t) as kokku_toit FROM grade_food_t';
                                    $foods = $connection->prepare($foodsq);
                                    $foods->execute();
                                    $foods->bind_result($foods_avarage, $total_food);
                                    $foods->fetch();
                                    $foods->close();

                                    $serviceq = 'SELECT AVG(grade_t) as teeninduse_keskmine, COUNT(grade_t) as kokku_teenindus FROM grade_service_t';
                                    $service = $connection->prepare($serviceq);
                                    $service->execute();
                                    $service->bind_result($services_avarage, $kokku_teenindus);
                                    $service->fetch();
                                    $service->close();
                                    echo '<h3><p>Püüame ennast parandada Töölised vaatame kuida on teid hinnatud</p><h3>';
                                    
                                    echo '<h4>Toit</h4>
                                    <p>Teenindust on kokku hinnatud '.$total_food.' korda. Keskmise hinde '.round($foods_avarage, 1) .' järgi on teenindus ';
                                    if($foods_avarage < 1) { echo 'Väga HULLLLLLL.</p>'; }
                                    if($foods_avarage < 2) { echo 'Mida Te teete.</p>'; }
                                    if($foods_avarage < 3) { echo 'Proovige Paremini.</p>'; }
                                    if($foods_avarage < 4) { echo 'Hea Pane täierauaga edasi.</p>'; }
                                    if($foods_avarage > 4) { echo 'Supppper jätka samas vaimus.</p>'; }
                                    
                                    echo '<h4>Teenindus</h4>
                                    <p>Teenindust on kokku hinnatud '.$kokku_teenindus.' korda. Keskmise hinde '.round($services_avarage, 1) .' järgi on teenindus ';
                                    if($services_avarage < 1) { echo 'Väga HULLLLLLL.</p>'; }
                                    if($services_avarage < 2) { echo 'Mida Te teete.</p>'; }
                                    if($services_avarage < 3) { echo 'Proovige Paremini.</p>'; }
                                    if($services_avarage < 4) { echo 'Hea Pane täierauaga edasi.</p>'; }
                                    if($services_avarage > 4) { echo 'Supppper jätka samas vaimus.</p>'; }
                                ?>
                                </center>
        						  <div class="break">
        						  </div>
								</div>
								</section>	
								</div>

								<?php require('layout/footer.php');  ?>
<?php
  $connection->close();
?>
