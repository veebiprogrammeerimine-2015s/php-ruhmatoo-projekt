<?php
    // kõik mis seotud andmetabeliga, lisamine ja tabeli kujul esitamine
    require_once("functions.php");
    require_once("../classes/InterestManager.class.php");
    
    
    if(!isset($_SESSION['logged_in_user_id'])){
        header("Location: login.php");
    }
 
    //****************
    //****HALDUS******
    //****************

    
    $InterestManager = new InterestManager($mysqli, $_SESSION['user_id']);
    
    if(isset($_GET["new_interest"])){
        $add_interest_response = $InterestManager->addInterest($_GET["new_interest"]);
    }
    
    if(isset($_GET["dropdown_interest"])){
        $add_user_interest_response = $InterestManager->addUserInterest($_GET["dropdown_interest"]);
    }

?>


<h2>Lisa huviala</h2>
<?php if(isset($add_interest_response->error)): ?>
  
  <p style="color:red"><?=$add_interest_response->error->message;?></p>
<?php elseif(isset($add_interest_response->success)): ?>

<p style="color:green;">
    <?=$add_interest_response->success->message;?>
</p>
  <?php endif; ?>
<form>
    <input name="new_interest"> <br><br>
  	<input type="submit" value="Lisa">
</form>

<h2>Minu huvialad</h2>
<?php if(isset($add_user_interest_response->error)): ?>
  
  <p style="color:red"><?=$add_user_interest_response->error->message;?></p>
<?php elseif(isset($add_user_interest_response->success)): ?>

<p style="color:green;">
    <?=$add_user_interest_response->success->message;?>
</p>
  <?php endif; ?>
    <form>
    <?=$InterestManager->createDropdown();?>
  	<input type="submit" value="Lisa">
</form>

<h2>Loetelu</h2>
<?=$InterestManager->getUserInterests();?>
   
