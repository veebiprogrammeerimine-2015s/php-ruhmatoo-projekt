<?php
	require_once("functions.php");
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
		
	}
	
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: login.php");
	}
		$poll = "";
		$topic_poll_ID = "";
		
		$poll_error = "";
		$topic_poll_error = "";
		
	
	
		if(isset($_POST["poll"])){
			if ( empty($_POST["poll"]) ) {
					$poll_error = "See väli on kohustuslik";
				}else{
					$poll = cleanInput($_POST["poll"]);
			}
			
			
			
		if($poll_error  == "" ){
				$var = $_POST['topic_poll_ID'];
				$message = adminView($var, $poll);
				if(	$poll_error == "" && $topic_poll_error == ""){
					
					
				
				echo "Küsimus on ".$poll." ja teema on ".$var;
					
				
					
					
				}
				if($message != ""){
					
					
					// õnnestus, teeme inputi väljad tühjaks
					$poll = "";
					
					echo $message;
					
				}
			}
		if(empty($_POST["topic_poll_ID"])) {
				$topic_poll_error = "Peab valima teema";
			} else {
				
				$topic_poll_ = cleanInput($_POST["topic_poll_ID"]);
			}
	}
	 $comment_array = getCommentData();
?>
<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?> 
	<a href="?logout=1"> Logi välja <a> 
</p>

<h2>Admini vaade</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="poll" >Sisesta küsitlus:</label><br>
	<input id="poll" name="poll" type="text" value="<?php echo $poll; ?>"> <?php echo $poll_error; ?>
	<select id="topic_poll" name="topic_poll_ID" onchange="showInput()">
				<option value="">Vali teema</option> 
				<option value="1"<?=$topic_poll_ID == "1" ? "selected='selected'" : ""?>>Varia</option>
				<option value="2"<?=$topic_poll_ID == "2" ? "selected='selected'" : ""?>>Autod</option>
				<option value="3"<?=$$topic_poll_ID == "3" ? "selected='selected'" : ""?>>Muusika</option>
			</select> <?php echo $topic_poll_error;?><br><br>
	<input type="submit" name="sisesta" value="Salvesta">
</form>

<h2>Kasutajad on kirjutanud:</h2>
<table border=1>
<tr>
    <th>Nr.</th>
    <th>Sisu</th>
</tr>
<?php 
    
    // küsimused ükshaaval läbi käia
    for($i = 0; $i < count($comment_array); $i++){
    
            echo "<tr>";
            echo "<td>".$comment_array[$i]->comment_ID."</td>";
            echo "<td>".$comment_array[$i]->comment."</td>";
            echo "</tr>";
            
        }
        
?>
</table>