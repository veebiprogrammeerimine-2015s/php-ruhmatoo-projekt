<?php
	//load header
	require_once("header.php");
?>
<label>Type of Business</label>
<select class="form-control">
    <option>small</option>
    <option>medium</option>
    <option>large</option>
</select> 

<br>

<div class="btn-group">
    <button type="button" class="form-control btn btn-default dropdown-toggle" data-toggle="dropdown">
        Select Business type <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <li><a href="#">small</a></li>
        <li><a href="#">medium</a></li>
        <li><a href="#">large</a></li>
    </ul>
</div>
<?php
	//load footer
	require_once("footer.php");	
?> 