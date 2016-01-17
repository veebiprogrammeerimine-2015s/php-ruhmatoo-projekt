<?php 
    $connect= mysql_connect ("localhost:5555", "if15", "ifikad15")
      or die("Невозможно установить соединение: " . mysql_error());
echo "Соединение установлено";

mysql_select_db("if15_vitamak");



$sql = "SELECT * FROM post_tech";
         $result = mysql_query($sql)  or die(mysql_error());
    
         while ($row = mysql_fetch_assoc($result))
            $ID = $row['post_id'];
            $Name = $row['name'];
          echo $ID;
echo $Name;
         }



?>