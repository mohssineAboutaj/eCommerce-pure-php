<?php
/*
**************************************************
===> ITEMS PAGE
**************************************************
*/
ob_start();
session_start();
$pageTitle = "Items";
if (isset($_SESSION['adminLogin'])) {
	include 'init.php';
	$action = isset($_GET['action']) ? $action = $_GET['action'] : 'itemsArea';
// main item page
	if ($action == 'itemsArea') {
		echo '<div class="add-new"><a href="?action=add">+</a></div>';
		// approve trick
		$q = '';
		if (isset($_GET['approve']) && $_GET['approve'] == 'approve' ) {
			$q = 'WHERE appr = 0';
		} else {
			$q = 'LIMIT '. $globalLimit;
		}
		$itemStmt = $connect->prepare("SELECT 
		                                   items.*, 
																		   category.name AS itemCat, 
																		   users.username AS itemMem 
																		FROM 
																		   items
																		INNER JOIN
																		   category
																		ON
																		   category.id = items.catId 
																		INNER JOIN
																		   users
																		ON
																		   users.id = items.memberId
																		ORDER BY id DESC
																		   $q");
		$itemStmt->execute();
		$fetch = $itemStmt->fetchAll();
?>
		<div class="container">
			<h1><?php echo lang('ADMIN_ITEMS'); ?></h1>
<?php
			if (!empty($fetch)) { ?>
			<table class="table table-striped">
				<thead class="thead-dark">
					<tr>
					<?php
					$colsName = array('id','name','description','price','addDate','country made','category','user','tags','status','views','control');
						foreach ($colsName as $col) {
							echo "<th>". $col ."</th>";
						}
					?>
					</tr>
				</thead>
				<tbody id="pageContent" data-request="items">
				<?php
					foreach($fetch as $row){
						echo '<tr>';
							echo '<td>'. $row['id'] .'</td>';
							echo '<td>'. $row['name'] .'</td>';
							echo '<td>'. $row['description'] .'</td>';
							echo '<td>'. $row['price'] .'</td>';
							echo '<td>'. $row['addDate'] .'</td>';
							echo '<td>'. $row['countryMade'] .'</td>';
							echo '<td>'. $row['itemCat'] .'</td>';
							echo '<td>'. $row['itemMem'] .'</td>';
							echo '<td>'. str_replace(',',' ', $row['tags']) .'</td>';
							echo '<td>'; 
								if($row['status'] == 1){echo 'New'; }
								if($row['status'] == 2){echo 'Like New'; }
								if($row['status'] == 3){echo 'Used'; }
								if($row['status'] == 4){echo 'Old'; }
							echo '</td>';
							echo '<td>'. $row['views'] .'</td>';
							echo '<td>';
								echo '<a href="?action=edit&id='. $row['id'] .'" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> edit</a>';
								echo '<a href="?action=delete&id='. $row['id'] .'" class="btn btn-danger btn-sm confirm"><i class="fa fa-trash"></i> delete</a>';
								if ($row['appr'] == 0) {
									echo '<a href="?action=approve&id='. $row['id'] .'" class="btn btn-primary btn-sm"><i class="fa fa-check"></i>'. lang('APPROVE') .'</a>';
								}
							echo '</td>';
						echo '</tr>';
					}
				?>
				</tbody>
			</table>
			<div class="btn btn-block btn-light" id="show-all">show all</div>
<?php
			} else {
				echo '<div class="alert alert-danger" role="alert">There is no items to show</div>';
			}
?>
			<a class="btn btn-primary" href="items.php?action=add"><i class="fa fa-plus"></i> <?php echo lang('ADD_NEW_ITEM'); ?></a>
		</div>
<?php
// add page
	} elseif ($action == 'add') {
?>
		<div class="container">
			<h1><?php echo lang('ADD_NEW_ITEM'); ?></h1>
			<form class="<?php echo $globalFormStyle ?>" action="items.php?action=insert" method="POST">
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('ITEM_NAME'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="text" name="name" placeholder="<?php echo lang('ITEM_NAME'); ?>" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" required />
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-12 col-md-3"><?php echo lang('ITEM_DESCR'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<textarea name="description" placeholder="<?php echo lang('ITEM_DESCR'); ?>" required rows="6" ></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-12 col-md-3"><?php echo lang('ITEM_PRICE'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="number" min="0" name="price" placeholder="<?php echo lang('ITEM_PRICE'); ?>" required />
					</div>
        </div>
        <div class="form-group row">
					<label class="col-sm-12 col-md-3"><?php echo lang('ITEM_MADE'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="text" name="countryMade" placeholder="<?php echo lang('ITEM_MADE'); ?>" required />
					</div>
        </div>
        <div class="form-group row">
					<label class="col-sm-12 col-md-3"><?php echo lang('ITEM_STATUS'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<select name="status" >
					    <option value="0">---</option>
					    <option value="1">New</option>
					    <option value="2">Like New</option>
					    <option value="3">Used</option>
					    <option value="4">old</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-12 col-md-3"><?php echo lang('MEMBER'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<select name="memberId" >
	   				  <option value="0">---</option>
							<?php
							$users = getAll('*','users');
								foreach($users as $user){
									echo "<option value='". $user['id'] ."'>". $user['username'] ."</option>";
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-12 col-md-3"><?php echo lang('CAT'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<select name="catId" >
	 		        <option value="0">---</option>
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
					<label class="col-sm-12 col-md-3"><?php echo lang('TAGS'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="text" name="tags" placeholder="<?php echo lang('TAGS_EX'); ?>" />
					</div>
        </div>
        <input class="<?php echo $globalInputStyle ?>" type="submit" value="<?php echo lang('ADD_ITEM'); ?>" />
			</form>
		</div>
<?php
// insert page
	} elseif ($action == 'insert') {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            echo '<div class="container">';
							echo '<h1>'. lang('CREATE_ITEM') .'</h1>';
							$itemName    = $_POST['name'];
							$itemDesc    = $_POST['description'];
							$itemPrice   = $_POST['price'];
							$countryMade = $_POST['countryMade'];
							$itemStatus  = $_POST['status'];
							$catId       = $_POST['catId'];
							$memberId    = $_POST['memberId'];
							$tags        = $_POST['tags'];
									
							$formWarn = array();
							if(empty($itemName)){ $formWarn[] = 'item name can be empty'; }
							if(empty($itemDesc)){ $formWarn[] = 'item description can be empty'; }
							if(empty($itemPrice)){ $formWarn[] = 'item price can be empty'; }
							if(!is_numeric($itemPrice)){ $formWarn[] = 'item price most be number'; }
							if($itemPrice <= 0){ $formWarn[] = 'item price most be greather than 0'; }
							if($itemStatus == 0){ $formWarn[] = 'you must be choose the status'; }
							if($memberId == 0){ $formWarn[] = 'you must be choose the member'; }
							if($catId == 0){ $formWarn[] = 'you must be choose the categorie'; }
							
							if(!empty($formWarn)){
								foreach ($formWarn as $warn) {
										echo "<div class='alert alert-danger' role='alert'>";
												echo "<i class='fa fa-times'></i> ". $warn;
										echo "</div>";
								}
								redirectTo('','back',false);
							}
							if (empty($formWarn)) {
								$itemStmt = $connect->prepare("INSERT INTO items (
													name, 
													description, 
													price, 
													countryMade, 
													status, 
													appr, 
													addDate, 
													catId, 
													memberId,
													tags)
												VALUES (
													:itemName, 
													:itemDesc, 
													:itemPrice, 
													:itemMade, 
													:itemStatus, 
													1, 
													now(), 
													:catId, 
													:memberId,
													:tags )");
								$itemStmt->execute(array(
															'itemName'   => $itemName,
															'itemDesc'   => $itemDesc,
															'itemPrice'  => $itemPrice,
															'itemMade'   => $countryMade,
															'itemStatus' => $itemStatus,
															'catId'      => $catId,
															'memberId'   => $memberId,
															'tags'       => $tags
														));
					if ($itemStmt) {
						redirectTo('<p class="alert alert-valide" role="alert"><i class="fa fa-check"></i> '. $itemStmt->rowCount() .' record inserted</p>', 'back');
                }
					}
          echo '</div>';
        } else {
			redirectTo('<p class="alert alert-danger" role="alert">Sorry !! you cannot browse this page directly</p>');
        }
// edit page
	} elseif ($action == 'edit') {
		$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $id = intval($_GET['id']) : 0;
		$itemStmt = $connect->prepare("SELECT * FROM items WHERE id = ?");
		$itemStmt->execute(array($id));
		$fetch = $itemStmt->fetch();
		$recordResult = $itemStmt->rowCount();
		if ($recordResult > 0) {
?>
		<div class="container">
			<h1><?php echo lang('EDIT_ITEM'); ?></h1>
			<form class="form-data" action="items.php?action=update" method="POST">
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<div class="form-group row">
					<label class="col-sm-12 col-md-3"><?php echo lang('ITEM_NAME'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="text" name="name" placeholder="<?php echo lang('ITEM_NAME'); ?>" value="<?php echo $fetch['name']; ?>" required />
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-12 col-md-3"><?php echo lang('ITEM_DESCR'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<textarea name="description" placeholder="<?php echo lang('ITEM_DESCR'); ?>" required rows="6" ><?php echo $fetch['description']; ?></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-12 col-md-3"><?php echo lang('ITEM_PRICE'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="number" min="0" name="price" placeholder="<?php echo lang('ITEM_PRICE'); ?>" value="<?php echo $fetch['price']; ?>" required />
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-12 col-md-3"><?php echo lang('ITEM_MADE'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="text" name="countryMade" placeholder="<?php echo lang('ITEM_MADE'); ?>" value="<?php echo $fetch['countryMade']; ?>" required />
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-12 col-md-3"><?php echo lang('ITEM_STATUS'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<select name="status" >
							<option value="1" <?php if($fetch['status'] == 1){ echo 'selected'; } ?> >New</option>
							<option value="2" <?php if($fetch['status'] == 2){ echo 'selected'; } ?> >Like New</option>
							<option value="3" <?php if($fetch['status'] == 3){ echo 'selected'; } ?> >Used</option>
							<option value="4" <?php if($fetch['status'] == 4){ echo 'selected'; } ?> >old</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-12 col-md-3"><?php echo lang('MEMBER'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<select name="memberId" >
	   				  <option value="0">---</option>
							<?php
							$users = getAll('*','users');
								foreach($users as $user){
									echo "<option value='". $user['id'] ."'";
									if($fetch['memberId'] == $user['id']){ echo 'selected'; }
									echo ">". $user['username'] ."</option>";
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-12 col-md-3"><?php echo lang('CAT'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<select name="catId" >
	 		        <option value="0">---</option>
							<?php
							$cats = getAll('*','category');
								foreach($cats as $cat){
									echo "<option value='". $cat['id'] ."'";
									if($fetch['catId'] == $cat['id']){ echo 'selected'; }
									echo ">". $cat['name'] ."</option>";
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-12 col-md-3"><?php echo lang('TAGS'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="text" name="tags" placeholder="<?php echo lang('TAGS_EX'); ?>" value="<?php echo $fetch['tags']; ?>" data-role="tagsinput" />
					</div>
        </div>
        <input class="<?php echo $globalInputStyle ?>" type="submit" value="<?php echo lang('UPDATE'); ?>" />
			</form>
		</div>
<?php
		}
// update page
	} elseif ($action == 'update') {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		echo '<div class="container">';
			echo '<h1>'. lang('UPDATE_ITEM') .'</h1>';
			$id = $_POST['id'];
			$itemName    = $_POST['name'];
			$itemDesc    = $_POST['description'];
			$itemPrice   = $_POST['price'];
			$countryMade = $_POST['countryMade'];
			$itemStatus  = $_POST['status'];
			$catId       = $_POST['catId'];
			$memberId    = $_POST['memberId'];
			$tags        = $_POST['tags'];
            
			$formWarn = array();
			if(empty($itemName)){ $formWarn[] = 'item name can be empty'; }
			if(empty($itemDesc)){ $formWarn[] = 'item description can be empty'; }
			if(empty($itemPrice)){ $formWarn[] = 'item price can be empty'; }
			if(!is_numeric($itemPrice)){ $formWarn[] = 'item price most be number'; }
			if($itemPrice <= 0){ $formWarn[] = 'item price most be greather than 0'; }
			foreach ($formWarn as $warn) {
				echo "<div class='alert alert-danger' role='alert'>";
				echo "<i class='fa fa-times'></i> ". $warn;
				echo "</div>";
			}
			if(!empty($formWarn)){ redirectTo('','back',false); }
			$check = checkItemExist("id", "items", $id);
			if (empty($formWarn) && $check > 0) {
				$itemStmt = $connect->prepare("UPDATE 
													items 
										   	   SET
													name = ?, 
													description = ?, 
													price = ?, 
													countryMade = ?, 
													status = ?, 
													catId = ?, 
													memberId = ?,
													tags = ?
											    WHERE id = ?");
				$itemStmt->execute(array($itemName, $itemDesc, $itemPrice, $countryMade, $itemStatus, $catId, $memberId, $tags, $id));
				if ($itemStmt) {
					redirectTo('<p class="alert alert-valide" role="alert"><i class="fa fa-check"></i> '. $itemStmt->rowCount() .' record updated</p>','items.php');
				}
			}
		echo '</div>';
		} else { 
			redirectTo('<div class="alert alert-danger" role="alert">Sorry !! you cannot browse this page directly</div>');
		}
// delete page
	} elseif ($action == 'delete') {
		$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $id = intval($_GET['id']) : 0;
		$check = checkItemExist('id', 'items', $id);
		if ($check > 0) {
			$itemStmt = $connect->prepare("DELETE FROM items WHERE id = ?");
			$itemStmt->execute(array($id));
			echo "<div class='container'>";
				echo "<h1>". lang('DELETE_ITEM') ."</h1>";
				redirectTo('<p class="alert alert-valide" role="alert"><i class="fa fa-check"></i> '. $itemStmt->rowCount() .' record deleted</p>','back');
			echo "</div>";
		} else {
			echo "<div class='container'>";
				redirectTo('<p class="alert alert-danger" role="alert"><i class="fa fa-times"></i> Sorry !! the id '. $id .' is not exist</p>');
			echo "</div>";
		}
// approve page
	} elseif ($action == 'approve') {
		$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $id = intval($_GET['id']) : 0;
		$check = checkItemExist('id', 'items', $id);
		if ($check > 0){
			$itemStmt = $connect->prepare("UPDATE items SET appr = 1 WHERE id = ?");
			$itemStmt->execute(array($id));
			echo "<div class='container'>";
				echo "<h1>". lang('APPROVE_ITEM') ."</h1>";
				redirectTo('<p class="alert alert-valide" role="alert"><i class="fa fa-check"></i> '. $itemStmt->rowCount() .' record deleted</p>','back', 3);
			echo "</div>";
		} else {
			echo "<div class='container'>";
				redirectTo('<p class="alert alert-danger" role="alert"><i class="fa fa-times"></i> Sorry !! the id '. $id .' is not exist</p>');
			echo "</div>";
		}
// if the page not exist
    } else {
		redirectTo("Sorry !! no page with this name");
	}
// include the footer
	include $inc . 'footer.php';
} else {
	header('location: index.php');
	exit();
}
ob_end_flush();
?>