<?php
/*
==================================================
===> PAGE ADD NEW ADS
==================================================
*/
ob_start();
session_start();
$pageTitle = "New ADS";
include 'init.php';
if (isset($_SESSION['userId'])) {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$adsName  = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
		$adsDesc  = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
		$adsPrice = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
		$made     = filter_var($_POST['countryMade'], FILTER_SANITIZE_STRING);
		$status   = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
		$category = filter_var($_POST['catId'], FILTER_SANITIZE_NUMBER_INT);
		$tags     = filter_var($_POST['tags'], FILTER_SANITIZE_STRING);
		// itemImg tricks
		$allowedExt = array('jpeg','jpg','png','gif');
		$itemImg = $_FILES['image'];
		$imgName = str_replace(' ', '', 'Xshop_'. date('Y-m-d_h-m-s') .'_'. rand(0,999999999999) .'_'. $itemImg['name']);
		$imgExt  = strtolower(end(explode('/',$itemImg['type'])));
		$imgTmp  = $itemImg['tmp_name'];
		$imgSize = $itemImg['size'];

		$formError = array();
		if(empty($adsName)){array_push($formError, lang('ITEM_NAME_EMPTY'));}
		if(empty($adsDesc)){array_push($formError, lang('ITEM_DESC_EMPTY'));}
		if(empty($adsPrice)){array_push($formError, lang('ITEM_PRICE_EMPTY'));}
		if(strlen($adsName) < 2){array_push($formError, lang('ITEM_NAME_<_2'));}
		if(strlen($adsDesc) < 10){array_push($formError, lang('ITEM_DESC_<_10'));}
		if(strlen($made) < 3){array_push($formError, lang('ITEM_MADE_<_3'));}
		if(strlen($adsPrice) < 1){array_push($formError, lang('ITEM_PRICE_<_1'));}
		if(!is_numeric($adsPrice)){array_push($formError, lang('ITEM_PRICE_NUM'));}
		if ($itemImg['error'] == 0) {
			if ($imgSize >= fileMaxSize(2)) {
				array_push($formError, lang('IMG_SIZE_>2MB'));
			}
			if (!in_array($imgExt, $allowedExt)) {
				array_push($formError, lang('IMG_NOT_ALLOWED') .' <b>'. join(', ',$allowedExt) .'</b>');
			}
		}
		if (empty($itemImg)) {
			array_push($formError, lang('IMG_EMPTY'));
		}
	}
?>
	<div class="container newAds">
		<h1><?php echo lang('ADD_NEW_ADS'); ?></h1>
		<div>
		<?php
			if (empty($formError) && $_SERVER['REQUEST_METHOD'] == 'POST') {
				$itemStmt = $connect->prepare("INSERT INTO items (
																					name, 
																					description, 
																					price, 
																					countryMade, 
																					status, 
																					addDate, 
																					catId, 
																					memberId,
																					tags,
																					image)
																			 VALUES (
																					:itemName, 
																					:itemDesc, 
																					:itemPrice, 
																					:itemMade, 
																					:itemStatus, 
																					now(), 
																					:catId, 
																					:memberId,
																					:tags,
																					:img )");
				$itemStmt->execute(array(
							'itemName'   => $adsName,
							'itemDesc'   => $adsDesc,
							'itemPrice'  => $adsPrice . '$',
							'itemMade'   => $made,
							'itemStatus' => $status,
							'catId'      => $category,
							'memberId'   => $_SESSION['userId'],
							'tags'       => $tags,
							'img'        => $imgName
						));
				if ($itemStmt) {
					move_uploaded_file($imgTmp, $itemDirectory . $imgName);
					echo '<div class="alert alert-success" role="alert"><i class="fa fa-check"></i> '. lang('ITEM_ADDED') .'</div>';
				}
			} else {
				if (isset($formError)) {
					foreach ($formError as $err) {
						echo '<div class="alert alert-danger" role="alert"><i class="fa fa-times"></i>';
							echo $err;
						echo '</div>';
					}
				}
			}
		?>
		</div>
		<div class="row">
			<form class="<?php echo $globalFormStyle ?>" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('ADS_NAME'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input id="name" type="text" name="name" placeholder="<?php echo lang('ADS_NAME_HOLDER'); ?>" required />
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('ADS_DESCR'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<textarea id="desc" name="description" placeholder="<?php echo lang('ADS_DESCR_HOLDER'); ?>" rows="6" required ></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('ADS_PRICE'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input id="price" type="number" min="1" name="price" placeholder="<?php echo lang('ADS_PRICE_HOLDER'); ?>" required />
					</div>
	      </div>
	      <div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('ADS_MADE'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="text" name="countryMade" placeholder="<?php echo lang('ADS_MADE_HOLDER'); ?>" required />
					</div>
	      </div>
	      <div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('ITEM_IMG') ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="file" name="image" required class="input-file" />
					</div>
	      </div>
	      <div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('ADS_STATUS'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<select name="status" required >
					    <option value="">---</option>
					    <option value="1">New</option>
					    <option value="2">Like New</option>
					    <option value="3">Used</option>
					    <option value="4">old</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('CAT'); ?></label>
						<div class="<?php echo $globalInputStyle ?>">
							<select name="catId" required >
		 		        <option value="">---</option>
								<?php
									$cats = getAll('*','category');
									foreach($cats as $cat){
										echo "<option value='". $cat['id'] ."'>". $cat['name'] ."</option>";
									}
								?>
							</select>
						</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('TAGS'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="text" name="tags" placeholder="<?php echo lang('TAGS_EX'); ?>" />
					</div>
	      </div>
				<div class="<?php echo $globalInputStyle ?> float-right">
					<input class="btn btn-success" type="submit" value="<?php echo lang('ADD_ADS'); ?>" />
					<input class="btn btn-danger" type="reset" value="<?php echo lang('RESET'); ?>" />
				</div>
			</form>
			<div class="live-preview item-box <?php echo $globalFormStyle ?>">
				<div class="card">
					<div class="ads-img">
						<span class="price"><?php echo lang('ADS_PRICE') ?></span>
						<img src="<?php echo $defaultItem; ?>" width="100%" height="100%" alt="item" id="img" />
					</div>
					<h3 class="card-text"><?php echo lang('ADS_NAME') ?></h3>
					<p class="card-text"><?php echo lang('ADS_DESCR') ?></p>
				</div>
			</div>
		</div>
	</div>
<?php
} else {
	header("location: index.php");
	exit();
}
include $inc .'footer.php';
ob_end_flush();
?>