<?php
  require_once("functions.php");

  if(!isset($_SESSION["logged_in_user_id"])){
    header("Location: index.php");
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
                <li class='tab' id="tab-reg">
                  <a href="#reg"><i class="icon-user"></i><span> Registeeru</span></a>
                </li>
                <li class='tab' id="tab-login">
                  <a href="#login"><i class="icon-file-text"></i><span> Login</span></a>
                </li>
                <li class='tab'>
                  <a href="#image"><i class="icon-heart"></i><span> pildid</span></a>
                </li>
                <li class='tab'>
                  <a href="#contact"><i class="icon-envelope"></i><span> kontaktid</span></a>
                </li>
            </ul>
          <!-- End Tab List -->
            <div id="tab-data-wrap">
              <!-- reg Tab Data -->
                <div id="reg">
                    <section class="clearfix">
                        
                        <div class="break">
                    </section>
                </div>
              <!-- End reg Tab Data -->
              <!-- login Tab Data -->
                  <div id="login">
                    <section class="clearfix">
                       
                      <div class="break">
                    </section>
                </div>
              <!-- End login Tab Data -->
              <!-- pildid Tab Data -->
                <div id="image">
                    <div class="g1">
                            <div class="image">
                                <img src="https://i.embed.ly/1/display?key=fc778e44915911e088ae4040f9f86dcd&url=http%3A%2F%2Fquinnzpinz.com%2Fwp-content%2Fuploads%2F2012%2F10%2FIMG_3223.jpg" alt="">
                                <div class="image-overlay">
                                    <div class="image-link">
                                        <a href="https://i.embed.ly/1/display?key=fc778e44915911e088ae4040f9f86dcd&url=http%3A%2F%2Fquinnzpinz.com%2Fwp-content%2Fuploads%2F2012%2F10%2FIMG_3223.jpg" class="btn">täisvaade</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="g1">
                            <div class="image">
                                <img src="http://www.sparetimelansing.com/wp-content/uploads/2012/08/banner1.jpg" alt="">
                                <div class="image-overlay">
                                    <div class="image-link">
                                        <a href="http://www.sparetimelansing.com/wp-content/uploads/2012/08/banner1.jpg" class="btn">täisvaade</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="g1">
                            <div class="image">
                                <img src="http://foundry-wp.com/wp-content/Cimy_Header_Images/0/bowling2.jpg" alt="">
                                <div class="image-overlay">
                                    <div class="image-link">
                                        <a href="http://foundry-wp.com/wp-content/Cimy_Header_Images/0/bowling2.jpg" class="btn">täisvaade</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="break"></div>
                        <div class="g1">
                            <div class="image">
                                <img src="http://www.bowlingdutrefle.fr/admin/data/img/gallery/accueil/bowling_28pistes.jpg" alt="">
                                <div class="image-overlay">
                                    <div class="image-link">
                                        <a href="http://www.bowlingdutrefle.fr/admin/data/img/gallery/accueil/bowling_28pistes.jpg" class="btn">täisvaade</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="g1">
                            <div class="image">
                                <img src="https://s-media-cache-ak0.pinimg.com/736x/04/c8/8c/04c88c8d15cdf3b1ac3732bd463ca2fb.jpg" alt="">
                                <div class="image-overlay">
                                    <div class="image-link">
                                        <a href="https://s-media-cache-ak0.pinimg.com/736x/04/c8/8c/04c88c8d15cdf3b1ac3732bd463ca2fb.jpg" class="btn">täisvaade</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="g1">
                            <div class="image">
                                <img src="http://i.telegraph.co.uk/multimedia/archive/02911/bowling_2911347b.jpg" alt="">
                                <div class="image-overlay">
                                    <div class="image-link">
                                        <a href="http://i.telegraph.co.uk/multimedia/archive/02911/bowling_2911347b.jpg" class="btn">täisvaade</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="break"></div>
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