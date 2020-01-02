<?php
/*
**************************************************
===> PAGE SHOW ADS
**************************************************
*/
ob_start();
session_start();
$pageTitle = "Items";
include 'init.php';
$action = isset($_GET['action']) ? $action = $_GET['action'] : 'show';
if ($action == 'show') {
	$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $id = intval($_GET['id']) : 0;

	$itemStmt = $connect->prepare("SELECT 
		                                 items.*, 
																	   category.name AS item_cat, 
																	   users.username AS item_user 
																	FROM items
																	INNER JOIN category
																	ON category.id = items.catId 
																	INNER JOIN users
																	ON users.id = items.memberId
																	WHERE items.id = ?
																	AND appr = 1");
	$itemStmt->execute(array($id));
	$item = $itemStmt->fetch();
	$recordResult = $itemStmt->rowCount();
	if ($recordResult > 0) {
?>
	<div class="container showAds">
		<h1><?php echo $item['name'] ?></h1>
		<div class="row">
			<div class="item-img col-sm-12 col-md-6">
			<?php
				echo "<img src='"; 
					if(!empty($item['image'])){ 
						echo $itemDirectory . $item['image']; 
					} else { 
						echo $defaultItem;
					}
						echo "'";
						echo "width='100%' title='". $item['name'] ."' />";
			?>
			</div>
			<div class="item-info col-sm-12 col-md-6">
				<ul class="list-greoup">
					<li class="list-group-item">
						<h3><?php echo $item['name'] ?></h3>
					</li>
					<li class="list-group-item">
						<i class="fa fa-info-circle"></i>
						<b><?php echo lang('DESCR') ?> : </b><?php echo $item['description'] ?>
					</li>
					<li class="list-group-item">
						<i class="fa fa-shopping-cart"></i>
						<b><?php echo lang('CAT') ?> : </b><a href="categories.php?pageId=<?php echo $item['catId'] ?>&pagename=<?php echo $item['item_cat'] ?>"><?php echo $item['item_cat'] ?></a>
					</li>
					<li class="list-group-item">
						<i class="fa fa-user-circle"></i>
						<b><?php echo lang('ADD_BY') ?> : </b><a href="#"><?php echo $item['item_user'] ?></a>
					</li>
					<li class="list-group-item">
						<i class="fa fa-calendar"></i>
						<b><?php echo lang('ADD_DATE') ?> : </b><?php echo $item['addDate'] ?>
					</li>
					<li class="list-group-item">
						<i class="fa fa-money-bill-alt"></i>
						<b><?php echo lang('PRICE') ?> : </b><span class="price"><?php echo $item['price'] ?>$</span>
					</li>
					<li class="list-group-item">
						<i class="fa fa-tags"></i>
						<b><?php echo lang('TAGS') ?> : </b>
						<?php
							$tags = explode(',', $item['tags']);
							foreach ($tags as $tag) {
								$tag = strtolower(str_replace(' ', '-', $tag));
								echo '<a href="tags.php?tag='. $tag .'">'. $tag .'</a> | ';
							}
						?>
					</li>
					<li class="list-group-item">
						<i class="fa fa-eye"></i>
						<b><?php echo lang('VIEWS') ?> : </b>
						<?php echo calcViews() ?>
					</li>
				</ul>
			<?php
				if (isset($_SESSION['userId']) && $item['item_user'] == $_SESSION['user']) {
					echo "<div class='row'>";
						echo '<a href="?action=delete&id='. $item['id'] .'" class="btn btn-danger"><i class="fa fa-trash"></i> '. lang('DELETE') .'</a>';
						echo '<a href="?action=edit&id='. $item['id'] .'" class="btn btn-success"><i class="fa fa-edit"></i> '. lang('EDIT') .'</a>';
					echo "</div>";
				}
			?>
			</div>
		</div>
	</div>
<?php
	}
	$cmntStmt = $connect->prepare("SELECT 
	                              	comments.*, 
	                              	users.username AS user_name
																FROM comments
																INNER JOIN users
																ON users.id = comments.memId 
																WHERE status = 1
																AND itemId = ? 
																ORDER BY id DESC");
	$cmntStmt->execute(array($id));
	$cmnts = $cmntStmt->fetchAll();
	echo '<div class="container itemComments">';
		echo '<div id="">';
			foreach ($cmnts as $cmnt){
				echo '<div class="row">';
					echo '<div class="user-info col-2">';
						echo $cmnt['user_name'];
					echo '</div>';
					echo '<div class="user-cmnt col-10">';
						echo $cmnt['comment'] .'<div>'. $cmnt['cmntDate'] .'</div>';
					echo '</div>';
				echo '</div>';
			}
		echo '</div>';
	echo '</div>';
	// comments form
	if (isset($_SESSION['userId'])) {
?>
		<div class="row">
			<form class="offset-3 col-9" action="<?php echo $_SERVER['PHP_SELF'] . '?action=show&id='. $id; ?>" method="POST" onsubmit="singlePageApplication('<?php echo $_SERVER['PHP_SELF'] ?>', '?action=show&id=<?php echo $id; ?>')">
				<div class="form-group row">
					<textarea placeholder="<?php echo lang('CMNT_HOLDER') ?>" name="comment" rows="2"></textarea>
					<input class="offset-8 col-4 btn btn-primary" type="submit" value="<?php echo lang('ADD_CMNT') ?>" />
				</div>
			</form>
		</div>
<?php
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
			if (!empty($comment)) {
				$Xstmt = $connect->prepare("INSERT INTO 
									comments(comment,	status,	cmntDate,	itemId,	memId) 
									VALUES(:cmnt, 1, now(), :item, :member)");
				$Xstmt->execute(array(
					'cmnt'    => $comment,
					'item'    => $id,
					'member'  => $_SESSION['userId']
				));
			}
		}
	} else {
		echo "<div class='container'>";
			echo "<a class='btn btn-danger please-log' href='login.php'>". lang('PLEASE_LOG') ."</a>";
		echo "</div>";
	}
} elseif ($action == 'edit') {
	if (isset($_SESSION['userId'])) {
		$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $id = intval($_GET['id']) : 0;
		$info = getAll('*','items','id',$id .' AND memberId = '. $_SESSION['userId']);
?>
		<div class="container">
			<h1><?php echo lang('EDIT') . ' - ' . $info[0]['name']; ?></h1>
			<div class="row row-reverse">
				<form class="<?php echo $globalFormStyle ?>" action="?action=update" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $id; ?>" />
					<div class="form-group row">
						<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('ADS_NAME'); ?></label>
						<div class="<?php echo $globalInputStyle ?>">
							<input id="name" type="text" name="name" placeholder="<?php echo lang('ADS_NAME_HOLDER'); ?>" value="<?php echo $info[0]['name']; ?>" required />
						</div>
					</div>
					<div class="form-group row">
						<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('ADS_DESCR'); ?></label>
						<div class="<?php echo $globalInputStyle ?>">
							<textarea id="desc" name="description" placeholder="<?php echo lang('ADS_DESCR_HOLDER'); ?>" rows="6" required ><?php echo $info[0]['description'] ?></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('ADS_PRICE'); ?></label>
						<div class="<?php echo $globalInputStyle ?>">
							<input id="price" type="text" name="price" placeholder="<?php echo lang('ADS_PRICE_HOLDER'); ?>" value="<?php echo $info[0]['price'] ?>" required />
						</div>
		      </div>
		      <div class="form-group row">
						<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('ADS_MADE'); ?></label>
						<div class="<?php echo $globalInputStyle ?>">
							<input type="text" name="countryMade" placeholder="<?php echo lang('ADS_MADE_HOLDER'); ?>" value="<?php echo $info[0]['countryMade'] ?>" required />
						</div>
		      </div>
		      <div class="form-group row">
						<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('ITEM_IMG') ?></label>
						<div class="<?php echo $globalInputStyle ?>">
							<input type="file" name="image" class="input-file" />
						</div>
		      </div>
		      <div class="form-group row">
						<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('ADS_STATUS'); ?></label>
						<div class="<?php echo $globalInputStyle ?>">
							<select name="status" required >
						    <option <?php if($info[0]['status'] == 1){echo 'selected';} ?> value="1">New</option>
						    <option <?php if($info[0]['status'] == 2){echo 'selected';} ?>  value="2">Like New</option>
						    <option <?php if($info[0]['status'] == 3){echo 'selected';} ?>  value="3">Used</option>
						    <option <?php if($info[0]['status'] == 4){echo 'selected';} ?>  value="4">old</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('CAT'); ?></label>
							<div class="<?php echo $globalInputStyle ?>">
								<select name="catId" required >
			 		        <?php
										$cats = getAll('*','category');
										foreach($cats as $cat){
											echo "<option value='". $cat['id'] ."'";
												if($info[0]['catId'] == $cat['id']){echo 'selected';}
											echo ">". $cat['name'] ."</option>";
										}
									?>
								</select>
							</div>
					</div>
					<div class="form-group row">
						<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('TAGS'); ?></label>
						<div class="<?php echo $globalInputStyle ?>">
							<input type="text" name="tags" placeholder="<?php echo lang('TAGS_EX'); ?>" value="<?php echo $info[0]['tags'] ?>" />
						</div>
		      </div>
					<div class="form-group row float-right">
						<input class="btn btn-success" type="submit" value="<?php echo lang('UPDATE_ADS'); ?>" />
						<input class="btn btn-danger" type="reset" value="<?php echo lang('RESET'); ?>" />
					</div>
				</form>
				<div class="live-preview item-box col-sm-12 col-md-6">
					<div class="ads-img">
						<span class="price"><?php echo $info[0]['price'] .'$' ?></span>
						<img src="<?php 
							if(!empty($info[0]['image'])){ 
								echo $itemDirectory . $info[0]['image']; 
							} else {
								echo $defaultItem;
							} ?>" width="100%" height="100%" alt="item" id="img" />
					</div>
					<h3><?php echo $info[0]['name'] ?></h3>
					<p><?php echo $info[0]['description'] ?></p>
				</div>
			</div>
		</div>
<?php
	} else {
		header("location: index.php");
		exit();
	}
} elseif ($action == 'update') {
	if (isset($_SESSION['userId'])) {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			echo '<h1>update item - '. $_POST['name'] .'</h1>';
			$adsName  = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
			$adsDesc  = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
			$adsPrice = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
			$made     = filter_var($_POST['countryMade'], FILTER_SANITIZE_STRING);
			$status   = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
			$category = filter_var($_POST['catId'], FILTER_SANITIZE_NUMBER_INT);
			$tags     = filter_var($_POST['tags'], FILTER_SANITIZE_STRING);
			$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
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
			if(strlen($adsName) < 2){array_push($formError, lang('ITEM_NAME_<_2'));}
			if(empty($adsPrice)){array_push($formError, lang('ITEM_PRICE_EMPTY'));}
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
			if (empty($formError)) {
				if ($itemImg['error'] > 0) {
					$itemStmt = $connect->prepare("UPDATE items SET name = ?, description = ?, price = ?, countryMade = ?, status = ?,catId = ?, tags = ? WHERE id = ? AND memberId = ?");
					$itemStmt->execute(array($adsName, $adsDesc, $adsPrice, $made, $status, $category, $tags, $id, $_SESSION['userId']));
				} else {
					$itemStmt = $connect->prepare("UPDATE items SET name = ?, description = ?, price = ?, countryMade = ?, status = ?,catId = ?, tags = ?, image = ? WHERE id = ? AND memberId = ?");
					$itemStmt->execute(array($adsName, $adsDesc, $adsPrice, $made, $status, $category, $tags, $imgName, $id, $_SESSION['userId']));
				}
				if ($itemStmt) {
					move_uploaded_file($imgTmp, $itemDirectory . $imgName);
					echo '<div class="container">';
						echo '<div class="alert alert-valide">';
							echo '<i class="fa fa-check"></i> '. lang('ITEM_UPDATED');
						echo '</div>';
						redirectTo('','?action=show&id='. $id);
					echo '</div>';
				}
			} else {
				if (isset($formError)) {
					foreach ($formError as $err) {
						echo '<div class="container">';
							echo '<div class="alert alert-error">';
								echo '<i class="fa fa-close"></i>'. $err;
							echo '</div>';
							redirectTo('','back',false);
						echo '</div>';
					}
				}
			}
		}
	}
} elseif ($action == 'delete') {
	$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $id = intval($_GET['id']) : 0;
	$item = getAll('name','items','id',$id);
	$check = checkItemExist('id', 'items', $id);
	if ($check > 0) {
		$catStmt = $connect->prepare("DELETE FROM items WHERE id = ?");
		$catStmt->execute(array($id));
		echo "<div class='container'>";
			echo "<h1 class='txt-c'>". lang('DELETE_ADS') .' - '. $item[0]['name'] ."</h1>";
			echo '<p class="alert alert-valide"><i class="fa fa-check"></i> <b class="upper">'. $item[0]['name'] .'</b> '. lang('DELETED') .'</p>';
			redirectTo('','index.php');
		echo "</div>";
	} else {
		header("location: index.php");
		exit();
	}
} else {
	echo '<div class="container">';
		echo '<div class="alert alert-error txt-c">'. lang('NO_ID_ITEM_WAIT') .'</div>';
		redirectTo('','back',false);
	echo '</div>';
}
include $inc .'footer.php';
ob_end_flush();
?>