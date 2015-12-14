<?php
	require_once(__DIR__."/../functions/functions.php");
	require_once(__DIR__."/../classes/temp.class.php");
	$page_title = "";
	$page_file_name = "";
	if(isset($_GET["logout"])){
        session_destroy();
        header("Location: /../index.php");
    }
	$getItem = new getItem($connection);
	$items_array = $getItem->getItem($_GET['item']);
?>

<?php require_once(__ROOT__."/header.php");
	echo '
		<div class="container">
			<div class="row">
				<div class="col-push-2 col-md-4">
					<img style="width:200px;height:200px" src="'.$items_array['0']->item_image.'">
					<p>'.$items_array['0']->item_name.'</p>
					<h3>Hind</h3>
					<p>'.$items_array['0']->price_added.'</p>
				</div>
				<div class="col-push-2 col-md-4">
					<h3>Pikkus</h3>
					<p>'.$items_array['0']->item_length.'</p>
					<h3>Laius</h3>
					<p>'.$items_array['0']->item_width.'</p>
					<h3>Kõrgus</h3>
					<p>'.$items_array['0']->item_height.'</p>
					<h3>Kaal</h3>
					<p>'.$items_array['0']->item_weight.'</p>
				</div>
			</div>
		</div>
	';

require_once(__ROOT__."/footer.php"); ?>
