<?php

	require_once("../header.php");

?>
 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

<textarea name="comment" rows="4" cols="75">
Siin saad anda tagasisidet professori kohta.
</textarea>



  <h2>Saada oma vastus</h2>
  <button type="submit" class="btn btn-success" name="saada">Saada</button>
</form>

<?php


	require_once("../footer.php");


?>
