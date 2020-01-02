<?php
/*
**************************************************
===> CATEGORIES PAGE
**************************************************
*/
ob_start();
session_start();
$pageTitle = "Categories";
if (isset($_SESSION['adminLogin'])) {
	include 'init.php';
	$action = isset($_GET['action']) ? $action = $_GET['action'] : 'categoryArea';
// main category page
	if ($action == 'categoryArea') {
		echo '<div class="add-new"><a href="?action=add">+</a></div>';
		// sorting trick
		$sortDir = 'ASC';
		$sortBy = 'id';
		$sortingDirArray = array('ASC','DESC');
		$sortingByArray = array('id','name','description','ordering','visibility','allowComments','allowAds');
		if (isset($_GET['sort']) && in_array($_GET['sort'], $sortingDirArray)) {
			$sortDir = $_GET['sort'];
		}
		if (isset($_GET['by']) && in_array($_GET['by'], $sortingByArray)) {
			$sortBy = $_GET['by'];
		}
		$fetch = getAll('*','category','','','',$sortBy,$sortDir, $globalLimit);
?>
		<div class="container cat">
			<h1><?php echo lang('ADMIN_CAT'); ?></h1>
			<?php
				if (settings('defaultLimit') > 0) {
					include $inc . 'sorting.php';
				}
			?>
			<table class="table table-striped">
				<thead class="thead-dark">
					<tr>
					<?php
					$colsName = array('id','name','description','ordering','visible','comments','ads','control');
						foreach ($colsName as $col) {
							echo "<th>". $col ."</th>";
						}
					?>
					</tr>
				</thead>
				<tbody id="pageContent" data-request="categories">
				<?php
					foreach($fetch as $row){
						echo '<tr>';
							echo '<th>'. $row['id'] .'</th>';
							echo '<td>'. $row['name'] .'</td>';
							echo '<td>'. $row['description'] .'</td>';
							echo '<td>'. $row['ordering'] .'</td>';
							echo '<td>';
								if($row['visibility'] == 0){
									echo '<i class="fa fa-check"></i>';
								} else {
									echo '<i class="fa fa-times"></i>';
								}
							echo '</td>';
							echo '<td>';
								if($row['allowComments'] == 0){
									echo '<i class="fa fa-check"></i>';
								} else {
									echo '<i class="fa fa-times"></i>';
								}
							echo '</td>';
							echo '<td>';
								if($row['allowAds'] == 0){
									echo '<i class="fa fa-check"></i>';
								} else {
									echo '<i class="fa fa-times"></i>';
								}
							echo '</td>';
							echo '<td>';
								echo '<a href="?action=edit&id='. $row['id'] .'" class="btn btn-sm btn-success"><i class="fa fa-edit"></i> edit</a>';
								echo '<a href="?action=delete&id='. $row['id'] .'" class="btn btn-sm btn-danger confirm"><i class="fa fa-trash"></i> delete</a>';
							echo '</td>';
						echo '</tr>';	
					}
				?>
				</tbody>
			</table>
			<div class="btn btn-block btn-light" id="show-all">show all</div>
			<a class="btn btn-sm btn-primary" href="categories.php?action=add"><i class="fa fa-plus"></i> <?php echo lang('ADD_NEW_CAT'); ?></a>
		</div>
<?php
// add page
	} elseif ($action == 'add') {
?>
		<div class="container">
			<h1><?php echo lang('ADD_NEW_CAT'); ?></h1>
			<form class="<?php echo $globalFormStyle ?>" action="categories.php?action=insert" method="POST">
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('CAT_NAME'); ?></label>
					<div class="<?php echo $globalInputStyle ?>" >
						<input type="text" name="name" placeholder="<?php echo lang('CAT_NAME'); ?>" required />
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('CAT_DESCR'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<textarea name="description" placeholder="<?php echo lang('CAT_DESCR'); ?>" required rows="4" ></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('CAT_ORDER'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="text" name="ordering" placeholder="<?php echo lang('CAT_ORDER'); ?>" />
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('VISIBLE'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input id="vis-yes" type="radio" name="visibility" value="0" checked />
						<label for="vis-yes">yes</label>
						<input id="vis-no" type="radio" name="visibility" value="1" />
						<label for="vis-no">no</label>
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('ALLOW_CMNT'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input id="cmnt-yes" type="radio" name="allowCmnt" value="0" checked />
						<label for="cmnt-yes">yes</label>
						<input id="cmnt-no" type="radio" name="allowCmnt" value="1" />
						<label for="cmnt-no">no</label>
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('ADS'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input id="ads-yes" type="radio" name="allowAds" value="0" checked />
						<label for="ads-yes">yes</label>
						<input id="ads-no" type="radio" name="allowAds" value="1" />
						<label for="ads-no">no</label>
					</div>
				</div>
				<input class="<?php echo $globalInputStyle ?>" type="submit" value="<?php echo lang('ADD_CAT'); ?>" />
			</form>
		</div>
<?php
// insert page
	} elseif ($action == 'insert') {
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		echo '<div class="container">';
			echo '<h1>'. lang('CREATE_CAT') .'</h1>';
			$catName = $_POST['name'];
			$catDesc = $_POST['description'];
			$catOrder = $_POST['ordering'];
			$catVis = $_POST['visibility'];
			$catCmnt = $_POST['allowCmnt'];
			$catAds = $_POST['allowAds'];

			$formWarning = array();
			if(empty($catName)) { $formWarning[] = 'category name must not leave it blanc'; }
			if(empty($catDesc)) { $formWarning[] = 'category description must not leave it blanc'; }
			foreach ($formWarning as $warn) {
				echo "<div class='alert alert-danger' role='alert'>";
				echo "<i class='fa fa-times'></i> ". $warn;
				echo "</div>";
			}
			if(!empty($formWarning)){ redirectTo('','back',false); }
			$check = checkItemExist("name", "category", $catName);
			if (empty($formWarning) && $check == 0) {
				$catStmt = $connect->prepare("INSERT INTO category (name, description, ordering, visibility, allowComments, allowAds) 
			                              VALUES (:catName, :catDesc, :catOrder, :catVis, :catCmnt, :catAds)");
				$catStmt->execute(array(
					'catName' => $catName,
					'catDesc' => $catDesc,
					'catOrder' => $catOrder,
					'catVis' => $catVis,
					'catCmnt' => $catCmnt,
					'catAds' => $catAds
				));
				if ($catStmt) {
					redirectTo('<p class="alert alert-success" role="alert"><i class="fa fa-check"></i> '. $catStmt->rowCount() .' record inserted</p>', 'back');
				}
			}
		echo "</div>";
		} else {
			redirectTo('<p class="alert alert-danger" role="alert">Sorry !! you cannot browse this page directly</p>');
		}
// edit page
	} elseif ($action == 'edit') {
		$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $id = intval($_GET['id']) : 0;
		$catStmt = $connect->prepare("SELECT * FROM category WHERE id = ?");
		$catStmt->execute(array($id));
		$fetch = $catStmt->fetch();
		$recordResult = $catStmt->rowCount();
		if ($recordResult > 0) {
?>
		<div class="container">
			<h1><?php echo lang('EDIT_CAT'); ?></h1>
			<form class="<?php echo $globalFormStyle ?>" action="categories.php?action=update" method="POST">
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('CAT_NAME'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="text" name="name" placeholder="<?php echo lang('CAT_NAME'); ?>" value="<?php echo $fetch['name']; ?>" required />
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('CAT_DESCR'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<textarea type="text" name="description" placeholder="<?php echo lang('CAT_DESCR'); ?>" required rows="4" ><?php echo $fetch['description']; ?></textarea>
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('CAT_ORDER'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="text" name="ordering" placeholder="<?php echo lang('CAT_ORDER'); ?>" value="<?php echo $fetch['ordering']; ?>" />
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('VISIBLE'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input id="ads-yes" type="radio" name="visibility" value="0" <?php if($fetch['visibility'] == 0){ echo 'checked'; } ?> />
						<label for="ads-yes">yes</label>
						<input id="ads-no" type="radio" name="visibility" value="1" <?php if($fetch['visibility'] == 1){ echo 'checked'; } ?>/>
						<label for="ads-no">no</label>
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('ALLOW_CMNT'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input id="cmnt-yes" type="radio" name="allowCmnt" value="0" <?php if($fetch['allowComments'] == 0){ echo 'checked'; } ?> />
						<label for="cmnt-yes">yes</label>
						<input id="cmnt-no" type="radio" name="allowCmnt" value="1" <?php if($fetch['allowComments'] == 1){ echo 'checked'; } ?>/>
						<label for="cmnt-no">no</label>
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('ADS'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input id="ads-yes" type="radio" name="allowAds" value="0" <?php if($fetch['allowAds'] == 0){ echo 'checked'; } ?> />
						<label for="ads-yes">yes</label>
						<input id="ads-no" type="radio" name="allowAds" value="1" <?php if($fetch['allowAds'] == 1){ echo 'checked'; } ?>/>
						<label for="ads-no">no</label>
					</div>
				</div>
				<input class="<?php echo $globalInputStyle ?>" type="submit" value="<?php echo lang('UPDATE'); ?>" />
			</form>
		</div>
<?php
	} else { redirectTo("<div class='container'><div class='alert alert-danger' role='alert'>Sorry !! There is no ". $id ." in category list</div></div"); }
// update page
	} elseif ($action == 'update') {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		echo '<div class="container">';
			echo '<h1>'. lang('UPDATE_CAT') .'</h1>';
			$id = $_POST['id'];
			$catName = $_POST['name'];
			$catDesc = $_POST['description'];
			$catOrder = $_POST['ordering'];
			$catVis = $_POST['visibility'];
			$catCmnt = $_POST['allowCmnt'];
			$catAds = $_POST['allowAds'];

			$formWarning = array();
			if(empty($catName)) { $formWarning[] = 'category name cant leave blanc'; }
			if(empty($catDesc)) { $formWarning[] = 'category description cant leave blanc'; }
			$fetch = getAll('name','category','id',$id);
			if($catName != $fetch[0]['name']){
				$check = checkItemExist("name", "category", $catName);
				if($check > 0){ $formWarning[] = 'category name <b>'. $catName .'</b> is already exist'; }
			}
			if(!empty($formWarning)){
				foreach ($formWarning as $warn) {
					echo "<div class='alert alert-danger' role='alert'>";
						echo "<i class='fa fa-times'></i> ". $warn;
					echo "</div>";
				}
				redirectTo('','back',false);
			}
			if (empty($formWarning)) {
				$catStmt = $connect->prepare("UPDATE category 
																	   	SET 
																	   		name = ?,
																	   		description = ?,
																				ordering = ?,
																				visibility = ?,
																				allowComments = ?,
																				allowAds = ? 
																			WHERE id = ?");
				$catStmt->execute(array($catName, $catDesc, $catOrder, $catVis, $catCmnt, $catAds, $id));
				if ($catStmt) {
					redirectTo('<p class="alert alert-success" role="alert"><i class="fa fa-check"></i> '. $catStmt->rowCount() .' record updated</p>');
				} 
			}
		echo '</div>';
		} else { 
			redirectTo('<div class="alert alert-danger" role="alert">Sorry !! you cannot browse this page directly</div>');
		}
// delete page
	} elseif ($action == 'delete') {
		$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $id = intval($_GET['id']) : 0;
		$check = checkItemExist('id', 'category', $id);
		if ($check > 0) {
			$catStmt = $connect->prepare("DELETE FROM category WHERE id = ?");
			$catStmt->execute(array($id));
			echo "<div class='container'>";
				echo "<h1>". lang('DELETE_CAT') ."</h1>";
				redirectTo('<p class="alert alert-success" role="alert"><i class="fa fa-check"></i> '. $catStmt->rowCount() .' record deleted</p>','back');
			echo "</div>";
		} else {
			echo "<div class='container'>";
				redirectTo('<p class="alert alert-danger" role="alert"><i class="fa fa-times"></i> Sorry !! the id '. $id .' is not exist</p>');
			echo "</div>";
		}
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