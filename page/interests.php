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