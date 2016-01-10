<form action="feedout.php" method="post">

<?php
$ipi = getenv("REMOTE_ADDR"); 
$httprefi = getenv ("HTTP_REFERER");
$httpagenti = getenv ("HTTP_USER_AGENT");
?>
<input type="hidden" name="ip" value="<?php echo $ipi ?>" />
<input type="hidden" name="httpref" value="<?php echo $httprefi ?>" />
<input type="hidden" name="httpagent" value="<?php echo $httpagenti ?>" />
<h2 align="center">Feedback</h2>
<p>Saada andmed: <select name="attn" size="1">
<option value=" Doctor ">Doktor1</option>
<option value=" Doctor ">Doktor2</option>
<option value=" Doctor ">Doktor3</option>

</select>
<br />
<p>
Nimi: <input type="text" name="nameis" size="20" /> 
</p>
<p>
Email:<input type="text" name="visitormail" size="20" />
</p>

<br/> Anna hinnang:<br/> [<input checked="checked" name="rating" type="radio" value="good" /> Good]   [<input name="rating" type="radio" value="bad" /> Bad]   

<br />
<h3 align="left">Kommentaarid</h3> 
<p align="left">
<textarea name="feedback" rows="6" cols="30">kommentaarid</textarea>
</p>
<hr />
<p align="left">
<input type="submit" value="Submit Feedback" />
</p>
</form>