<?php
/*
**************************************************
===> TAGS PAGE
**************************************************
*/
ob_start();
session_start();
$pageTitle = 'Tags';
include 'init.php';

if (isset($_GET['tag'])) {
	$tag = $_GET['tag'];
	echo '<h1>'. $tag .'</h1>';
	echo '<div class="container">';
	$stmt = $connect->prepare("SELECT * FROM items WHERE tags LIKE '%$tag%' AND appr = 1");
	$stmt->execute();
	$items = $stmt->fetchAll();
	  echo '<div class="row">';
		foreach ($items as $item) {
			if($item['appr'] != 0){
		  	echo '<a class="col-sm-12 col-md-4 col-lg-3" href="showAds.php?action=show&id='. $item['id'] .'">';
				  echo '<div class="card">';
				  	echo '<div class="item-box">';
					  	echo '<div class="ads-img">';
				 		    echo '<span class="price">'. $item['price'] .'</span>';
								echo "<img class='card-img' src='"; 
									if(!empty($item['image'])){ 
										echo $itemDirectory . $item['image']; 
									} else { 
										echo $defaultItem;
									}
										echo "'";
										echo " title='". $item['name'] ."' alt='". $item['name'] ."' />";
						  echo '</div>';
					    echo '<h3 class="card-text">'. $item['name'] .'</h3>';
					    echo '<p class="card-text">'. $item['description'] .'</p>';
					    echo '<div class="card-text date">'. $item['addDate'] .'</div>';
				  	echo '</div>';
				  echo '</div>';
				echo '</a>';
			}
		}
		echo '</div>';
	echo '</div>';
} else {
	header("location: index.php");
	exit();
}
include $inc . 'footer.php';
ob_end_flush();