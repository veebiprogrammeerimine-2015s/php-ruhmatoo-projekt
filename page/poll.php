<?php  
    require_once("functions.php");
	require_once("functions.php");
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
	}
	
	if(isset($_GET["logout"])){
		include 'user_class.php';
		logoutUser();
		header("Location: login.php");
	}
    	$comment = "";
		
		$comment_error = "";
	
	
		if(isset($_POST["comment"])){
			if ( empty($_POST["comment"]) ) {
					$comment_error = "See väli on kohustuslik";
				}else{
					$comment = cleanInput($_POST["comment"]);
			}
			
			
			
		if($comment_error  == "" ){
				$message = addComment($comment);
				
				if($message != ""){
					// õnnestus, teeme inputi väljad tühjaks
					$comment = "";
					
					echo $message;
					
				}
			}
	}
	
    // kuulan, kas kasutaja tahab vastata
    if(isset($_GET["yes"])) {
        ///saadan kustutatava auto id
        yesAnswer($_GET["yes"]);
    }
	   if(isset($_GET["no"])) {
        ///saadan kustutatava auto id
        noAnswer($_GET["no"]);
    }
    
    // kõik autod objektide kujul massiivis
    $poll_array = getAllData();
?>
<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?> 
		Tere, <?=$_SESSION["logged_in_user_id"];?> 
	<a href="login.php"> Logi välja <a> 
</p>

<h1>Nendele küsimustele saab vastata</h1>
<table border=1>
<tr>
    <th>Nr.</th>
    <th>Küsimus</th>
	<th>Jah</th>
    <th>Ei</th>
</tr>
<?php 
    
    // küsimused ükshaaval läbi käia
    for($i = 0; $i < count($poll_array); $i++){
        
       
            // lihtne vaade
            echo "<tr>";
            echo "<td>".$poll_array[$i]->poll_ID."</td>";
            echo "<td>".$poll_array[$i]->poll."</td>";
			echo "<td><a href='?yes=".$poll_array[$i]->poll_ID."'>[✓]</a></td>";
			echo "<td><a href='?no=".$poll_array[$i]->poll_ID."'>[X]</a></td>";
            echo "</tr>";
            
        }
        
?>
</table>

<h1>Sellised on vastused:</h1>
<table border=1>
<tr>
    <th>Nr.</th>
    <th>Küsimus</th>
	<th>Jah</th>
    <th>Ei</th>
</tr>
<?php 
    
    // küsimused ükshaaval läbi käia
    for($i = 0; $i < count($poll_array); $i++){
        
       
            // lihtne vaade
            echo "<tr>";
            echo "<td>".$poll_array[$i]->poll_ID."</td>";
            echo "<td>".$poll_array[$i]->poll."</td>";
			 echo "<td>".$poll_array[$i]->yes."</td>";
            echo "<td>".$poll_array[$i]->no."</td>";
            echo "</tr>";
            
        }
        
?>
</table>

<h2>Kirjuta lehekülje loojatele:</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="comment" >Sisesta oma sõnum:</label><br>
	<input id="comment" name="comment" type="text" value="<?php echo $comment; ?>"> <?php echo $comment_error; ?>
	<input type="submit" name="edasta" value="Edasta">
</form>