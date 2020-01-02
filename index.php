<?php
/*
==================================================
===> MAIN X-shop PAGE
==================================================
*/
ob_start();
session_start();
$pageTitle = 'shop-go';
include 'init.php';

echo '<h1>'. lang('ALL_ITEMS') .'</h1>';
echo '<div class="container">';
	echo '<div class="row">';
		foreach (getAll('*','items','appr','1') as $item) {
			echo '<a class="col-sm-6 col-md-4 col-lg-3" href="showAds.php?id='. $item['id'] .'">';
			  echo '<div class="item-box card">';
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
			    echo '<div class="card-body">';
				    echo '<h3 class="card-text">'. $item['name'] .'</h3>';
					  echo '<p class="card-text">'. $item['description'] .'</p>';
					  echo '<div class="card-text date">'. $item['addDate'] .'</div>';
					echo '</div>';
				echo '</div>';
			echo '</a>';
		}
	echo '</div>';
echo '</div>';

include $inc .'footer.php';
ob_end_flush();
?>