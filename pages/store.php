<?php
	require_once(__DIR__."/../functions/functions.php");
	require_once(__DIR__."/../classes/store.class.php");
	$page_title = "Pood";
	$page_file_name = "store.php";
	if(isset($_GET["logout"])){
        session_destroy();
        header("Location: /../index.php");
    }
	$getStoreItems = new getStoreItems($connection);
	$inStore_array = $getStoreItems->getStoreItems();
	require_once(__ROOT__."/header.php");
		echo '<div class="container">
			<div class="row">';
	for($i = 0; $i < count($inStore_array); $i++){
			echo '<div class="col-xs-6 col-md-3">
						<a href="/pages/item.php?item='.$inStore_array[$i]->id.'" class="thumbnail" id="picturs">
						<img style="height:200px;" src="/../pildid/'.$inStore_array[$i]->image.'" alt="'.$inStore_array[$i]->id.'">
						<h3>'.$inStore_array[$i]->name.'</h3>
						<p>'.$inStore_array[$i]->item_price.'€</p>
						</a>
					</div>';
	}
		echo '</div>
		</div>';
require_once(__ROOT__."/footer.php"); ?>
