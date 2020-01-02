<?php
/*
**************************************************
===> COMMENTS PAGE
**************************************************
*/
ob_start();
session_start();
$pageTitle = "Comments";
if (isset($_SESSION['adminLogin'])) {
	include 'init.php';
	$action = isset($_GET['action']) ? $action = $_GET['action'] : 'commentsArea';
// main comments page
	if ($action == 'commentsArea') {
		$cmntStmt = $connect->prepare("SELECT 
                                	comments.*,
																	items.name AS item_name,
																	users.username AS user_name
																FROM comments INNER JOIN items
																ON items.id = comments.itemId
																INNER JOIN users
																ON users.id = comments.memId
																ORDER BY id DESC
																LIMIT $globalLimit");
		$cmntStmt->execute();
		$fetch = $cmntStmt->fetchAll();
?>
		<div class="container">
			<h1><?php echo lang('ADMIN_CMNT'); ?></h1>
<?php if (!empty($fetch)) { ?>
			<table class="table table-striped">
				<thead class="thead-dark">
					<tr>
						<th>id</th>
						<th>comment</th>
						<th>item</th>
						<th>user</th>
						<th>addDate</th>
						<th>control</th>
					</tr>
				</thead>
				<tbody id="pageContent" data-request="comments">
				<?php
					foreach($fetch as $row){
						echo '<tr>';
							echo '<th>'. $row['id'] .'</th>';
							echo '<td>'. $row['comment'] .'</td>';
							echo '<td>'. $row['item_name'] .'</td>';
							echo '<td>'. $row['user_name'] .'</td>';
							echo '<td>'. $row['cmntDate'] .'</td>';
							echo '<td>';
								echo '<a href="?action=edit&id='. $row['id'] .'" class="btn btn-success"><i class="fa fa-edit"></i> edit</a>';
								echo '<a href="?action=delete&id='. $row['id'] .'" class="btn btn-danger confirm"><i class="fa fa-trash"></i> delete</a>';
								if ($row['status'] == 0) {
									echo '<a href="?action=approve&id='. $row['id'] .'" class="btn btn-primary"><i class="fa fa-check"></i>'. lang('APPROVE') .'</a>';
								}
							echo '</td>';
						echo '</tr>';
					}
				?>
				</tbody>
			</table>
			<div class="btn btn-block btn-light" id="show-all">show all</div>
<?php } else {
				echo '<div class="alert alert-danger" role="alert">There is no comments to show</div>';
			}
?>
		</div>
<?php
// edit page
	} elseif ($action == 'edit') {
		$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $id = intval($_GET['id']) : 0;
		$cmntStmt = $connect->prepare("SELECT * FROM comments WHERE id = ?");
		$cmntStmt->execute(array($id));
		$fetch = $cmntStmt->fetch();
		$recordResult = $cmntStmt->rowCount();
		if ($recordResult > 0) {
?>
		<div class="container">
			<h1><?php echo lang('EDIT_CMNT'); ?></h1>
			<form class="<?php echo $globalFormStyle ?>" action="comments.php?action=update" method="POST">
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<div class="form-group row">
					<label class="col-12"><?php echo lang('CMNT'); ?></label>
					<textarea rows="5" class="col-12" name="cmnt" placeholder="<?php echo lang('CMNT'); ?>" required ><?php echo $fetch['comment']; ?></textarea>
          <input class="col-12" type="submit" value="<?php echo lang('UPDATE'); ?>" />
				</div>
			</form>
		</div>
<?php
	} else { redirectTo("<div class='container'><div class='alert alert-danger' role='alert'>Sorry !! There is no ". $id ." in members list</div></div"); }
// update page
	} elseif ($action == 'update') {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		echo '<div class="container">';
			echo '<h1>'. lang('UPDATE_CMNT') .'</h1>';
				$id   = $_POST['id'];
				$cmnt = $_POST['cmnt'];

				$formWarning = array();
				if (empty($cmnt)) { $formWarning[] = "comment can be empty"; }
				foreach ($formWarning as $warn) {
					echo "<div class='alert alert-danger' role='alert'>";
					echo "<i class='fa fa-times'></i> ". $warn;
					echo "</div>";
				}
				
				if (!empty($formWarning)) { 
					echo '<a class="btn btn-primary" href="?action=edit&id='. $id .'"><i class="fa fa-arrow-left"></i> back</a>';
				}
				
				$check = checkItemExist("id", "comments", $cmnt);
				if (empty($formWarning) && $check <= 1) {
					$stmt = $connect->prepare("UPDATE comments SET comment = ? WHERE id = ?");
					$stmt->execute(array($cmnt, $id));
					redirectTo('<p class="alert alert-success" role="alert"><i class="fa fa-check"></i> '. $stmt->rowCount() .' record updated</p>', 'back');
				}
		echo '</div>';
		} else {
			redirectTo('<div class="alert alert-danger" role="alert">Sorry !! you cannot browse this page directly</div>');
		}
// approve page
	} elseif ($action == 'approve') {
		$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $id = intval($_GET['id']) : 0;
		$check = checkItemExist('id', 'comments', $id);
		if ($check == 1){
			$stmt = $connect->prepare("UPDATE comments SET status = 1 WHERE id = ?");
			$stmt->execute(array($id));
			echo "<div class='container'>";
				echo "<h1>". lang('APPROVE_CMNT') ."</h1>";
				redirectTo('<p class="alert alert-success" role="alert"><i class="fa fa-check"></i> '. $stmt->rowCount() .' record approved</p>','back', 3);
			echo "</div>";
		} else {
			echo "<div class='container'>";
				redirectTo('<p class="alert alert-danger" role="alert"><i class="fa fa-times"></i> Sorry !! the id '. $id .' is not exist</p>');
			echo "</div>";
		}
// delete page
	} elseif ($action == 'delete') {
		$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $id = intval($_GET['id']) : 0;
		$check = checkItemExist('id', 'comments', $id);
		if ($check > 0){
			$stmt = $connect->prepare("DELETE FROM comments WHERE id = ?");
			$stmt->execute(array($id));
			echo "<div class='container'>";
				echo "<h1>". lang('DELETE_CMNT') ."</h1>";
				redirectTo('<p class="alert alert-success" role="alert"><i class="fa fa-check"></i> '. $stmt->rowCount() .' record deleted</p>','back', 3);
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