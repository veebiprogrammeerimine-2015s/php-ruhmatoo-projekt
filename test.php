<?php
	//load header
	require_once("header.php");
?>
<div class="container">
<div class="row">
	<form>
		<div class="form-group">
		<label for="datepicker" class="col-sm-2 control-label">Kuupäev:</label>
		<input type="text" name="dob" class="form-control datepicker" id="datepicker" placeholder="kuupäev" value="<?php if(isset($_POST["dob"])){echo $create_age;} ?>">
		</div>
		
		<div class="form-group">
		<label for="starttime" name="dob" class="col-sm-2 control-label">Algus:</label>
		<select class="form-control" name="starttime">
		<option>7:00</option>
		<option>8:00</option>
		<option>9:00</option>
		<option>10:00</option>
		<option>11:00</option>
		<option>12:00</option>
		<option>13:00</option>
		<option>14:00</option>
		<option>15:00</option>
		<option>16:00</option>
		<option>17:00</option>
		</select>
		</div>
		
		<div class="form-group">
		<label for="endtime" class="col-sm-3 control-label">Lõpp:</label>
		<select class="form-control" name="endtime">
		<option>8:00</option>
		<option>9:00</option>
		<option>10:00</option>
		<option>11:00</option>
		<option>12:00</option>
		<option>13:00</option>
		<option>14:00</option>
		<option>15:00</option>
		<option>16:00</option>
		<option>17:00</option>
		<option>18:00</option>
		</select><br>
		</div>
		
		<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
		<button type="submit" class="btn btn-success pull-right" name="create" id="addtime">Sisesta</button>
		</div>
		</div>
	</form>
</div>
</div>

<?php
	//load footer
	require_once("footer.php");	
?> 