<?php

        require_once("../config_global.php");
        $database = "if15_Martin_Siim";

        session_start();
		
        function createUser($reg_username, $reg_email, $hash){
                echo $reg_username;
                echo $reg_email;
                echo $hash;
                $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
               
                $stmt =  $mysqli->prepare("INSERT INTO user_creation (Email, Username, Password) VALUES (?,?,?)");
                $stmt->bind_param("sss", $reg_email, $reg_username, $hash);
                $stmt->execute();
                $stmt->close();
               
                $mysqli->close();
               
        }
       
        function loginUser($username_or_email, $hash){
                echo "Login launched";
                echo $username_or_email;
                echo $hash;
                $mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);          
                $stmt = $mysqli->prepare("SELECT id, Email, Username FROM user_creation WHERE Password = ? AND (Email LIKE ? OR Username LIKE ?)");
                $stmt->bind_param("sss", $hash, $username_or_email, $username_or_email);
                $stmt->bind_result($id_from_db, $username_from_db, $email_from_db);
                $stmt->execute();
               
                if($stmt->fetch()){


                        $_SESSION["logged_in_user_id"] = $id_from_db;
                        $_SESSION["logged_in_user_username"] = $username_from_db;
                        $_SESSION["logged_in_user_email"] = $email_from_db;
                       
                       
                }else{
                        echo "Wrong credidentials!";
                }
                       
                $stmt->close();
                       
                $mysqli->close();
               
        }

?>