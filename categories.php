<?php
/*
==================================================
===> All categories X-shop
==================================================
*/
ob_start();
session_start();
$pageTitle = 'Categories';
include 'init.php';

if (isset($_GET['pageId']) && is_numeric($_GET['pageId'])) {
echo '<div class="container">';
	echo '<h1>'. lang('ALL_ITEMS') .'</h1>';
	echo "<div class='row'>";
	$items = getAll('*','items','catId',$_GET['pageId']);
	foreach ($items as $item) {
		echo '<a class="col-sm-12 col-md-4 col-lg-3" href="showAds.php?action=show&id='. $item['id'] .'">';
			echo '<div class="card">';
			if($item['appr'] != 0){
			  echo '<div class="item-box">';
			  	echo '<div class="ads-img">';
		 		    echo '<span class="price">'. $item['price'] .'</span>';
				    echo '<img class="card-img" src="';
				    if (!empty($item['image'])) {
				    	echo $itemDirectory . $item['image'];
				    } else {
				    	echo $defaultItem;
				    }
				    echo '" alt="item" title="'. $item['name'] .'" />';
				  echo '</div>';
			    echo '<h3 class="card-text">'. $item['name'] .'</h3>';
			    echo '<p class="card-text">'. $item['description'] .'</p>';
			    echo '<div class="card-text date">'. $item['addDate'] .'</div>';
			  echo '</div>';
			}
			echo '</div>';
		echo '</a>';
	}
	echo '</div>';
echo '</div>';
} else {
	header("location: index.php");
	exit();
}
include $inc . 'footer.php';
ob_end_flush();