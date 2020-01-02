<?php
/*
**************************************************
===> MEMBERS PAGE
**************************************************
*/
ob_start();
session_start();
$pageTitle = "Members";
if (isset($_SESSION['adminLogin'])) {
	include 'init.php';
	$action = isset($_GET['action']) ? $action = $_GET['action'] : 'adminArea';
	// uploads directory
	$uploads = '../data/uploads/';
	$profileDirectory = $uploads . 'profile/';
// control panel home page
	if ($action == 'adminArea') {
		echo '<div class="add-new"><a href="?action=add">+</a></div>';
		// activate trick
		$q = '';
		if (isset($_GET['activate']) && $_GET['activate'] == 'activate') {
			$q = 'AND regStatus = 0';
		} else {
			$q = 'LIMIT '. $globalLimit;
		}
		$fetch = getAll('*','users','groupid','0',$q);
?>
		<div class="container">
			<h1><?php echo lang('ADMIN_MEMBERS'); ?></h1>
<?php if (!empty($fetch)) { ?>
			<table class="table members-table">
				<thead class="thead-dark table-striped">
					<tr>
						<th>id</th>
						<th><?php echo lang('USERNAME') ?></th>
						<th><?php echo lang('PROFILE_IMG') ?></th>
						<th><?php echo lang('EMAIL') ?></th>
						<th><?php echo lang('FULLNAME') ?></th>
						<th><?php echo lang('REG_DATE') ?></th>
						<th><?php echo lang('CTRL') ?></th>
					</tr>
				</thead>
				<tbody id="pageContent" data-request="members">
				<?php
					foreach ($fetch as $row) {
						echo '<tr>';
							echo "<th>". $row['id'] ."</th>";
							echo "<td>". $row['username'] ."</td>";
							echo "<td>";
							if (!empty($row['image'])) {
								echo "<img src='". $profileDirectory . $row['image'] ."' />";
							} else {
								echo "no image";
							}
							echo "</td>";
							echo "<td>". $row['email'] ."</td>";
							echo "<td>". $row['fullname'] ."</td>";
							echo "<td>". $row['date'] ."</td>";
							echo '<td>';
								echo '<a class="btn btn-success" href="members.php?action=edit&id='. $row['id'] .'"><i class="fa fa-edit"></i> '. lang('EDIT') .'</a>';
								echo '<a class="btn btn-danger confirm" href="members.php?action=delete&id='. $row['id'] .'"><i class="fa fa-trash"></i> '. lang('DELETE') .'</a>';
								if ($row['regStatus'] == 0) {
									echo '<a class="btn btn-primary" href="members.php?action=activate&id='. $row['id'] .'"><i class="fa fa-check"></i> '. lang('ACTIVATE') .'</a>';
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
				echo '<div class="alert alert-danger" role="alert">There is no member to show</div>';
			}
?>
			<a class="btn btn-primary" href="members.php?action=add"><i class="fa fa-plus"></i> <?php echo lang('ADD_NEW_MEMBER'); ?></a>
		</div>
<?php
// add page
	} elseif ($action == 'add') {
?>
		<div class="container">
			<h1><?php echo lang('ADD_MEMBER'); ?></h1>
			<form class="<?php echo $globalFormStyle ?>" action="members.php?action=insert" method="POST" enctype="multipart/form-data">
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('USERNAME'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="text" name="username" placeholder="<?php echo lang('USERNAME'); ?>" required autocomplet="off" />
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('PASSWORD'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="password" name="password" placeholder="<?php echo lang('PASSWORD'); ?>" required />
						<i class="fa fa-eye" onmouseover="showPassword('password')" onmouseout="hidePassword('password')"></i> visible password
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('FULLNAME'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="text" name="fullname" placeholder="<?php echo lang('FULLNAME'); ?>" required autocomplet="off" />
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('PROFILE_IMG') ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="file" name="image" class="input-file" />
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('EMAIL'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="email" name="email" placeholder="<?php echo lang('EMAIL'); ?>" required autocomplet="off" />
					</div>
				</div>
				<input class="<?php echo $globalInputStyle ?>" type="submit" value="<?php echo lang('INSERT'); ?>" />
			</form>
		</div>
<?php
// insert page
	} elseif ($action == 'insert') {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		echo '<div class="container">';
			echo '<h1>'. lang('CREATE_MEMBER') .'</h1>';
				$username = $_POST['username'];
				$password = $_POST['password'];
				$fullname = $_POST['fullname'];
				$email = $_POST['email'];
				// check if username exist
				$check = checkItemExist("username", "users", $username);
				// profileImg tricks
				$allowedExt = array('jpeg','jpg','png','gif');
				$profileImg = $_FILES['image'];
				$imgName = str_replace(' ', '', 'Xshop_'. date('Y-m-d_h-m-s') .'_'. rand(0,999999999999) .'_'. $profileImg['name']);
				$imgExt  = strtolower(end(explode('/',$profileImg['type'])));
				$imgTmp  = $profileImg['tmp_name'];
				$imgSize = $profileImg['size'];
				// get the inputs errors and set into formWarning
				$formWarning = array();
				if (empty($username)) { $formWarning[] = "username can be <b>empty</b>"; }
				if (strlen($username) < 4) { $formWarning[] = "username can be less then 4 char"; }
				if (empty($password)) { $formWarning[] = "password can be <b>empty</b>"; }
				if (strlen($password) < 4) { $formWarning[] = "password can be less then 4 char"; }
				if (empty($fullname)) { $formWarning[] = "fullname can be <b>empty</b>"; }
				if (strlen($fullname) <5) { $formWarning[] = "username can be less than 5 char"; }
				if (empty($email)) { $formWarning[] = "e-mail can be <b>empty</b>"; }
				if ($check > 0) { $formWarning[] = "the username <b>". $username ."</b> already exist"; }
				if ($profileImg['error'] == 0) {
					if ($imgSize >= fileMaxSize(2)) {
						$formWarning[] = 'image size cant be larger than <b>2MB</b>';
					}
					if (!in_array($imgExt, $allowedExt)) {
						$formWarning[] = 'the image type is not allowed <br/> The extensions allowed is : <b>'. join(', ',$allowedExt) .'</b>';
					}
				}

				if (empty($formWarning)) {
					if (isset($imgError) && $imgError > 0) {
						$stmt = $connect->prepare("INSERT INTO users (username, password, fullname, email, regStatus, date, image) 
												VALUES (:xuser, :xpass, :xfull, :xmail, 1, now()) ");
						$stmt->execute(array(
							'xuser' => $username,
							'xpass' => hashed_pass($pass),
							'xfull' => $fullname,
							'xmail' => $email
						));
					} else {
						move_uploaded_file($imgTmp, $profileDirectory . $imgName);
						$stmt = $connect->prepare("INSERT INTO users (username, password, fullname, email, regStatus, date, image) 
												VALUES (:xuser, :xpass, :xfull, :xmail, 1, now(), :ximg) ");
						$stmt->execute(array(
							'xuser' => $username,
							'xpass' => hashed_pass($pass),
							'xfull' => $fullname,
							'xmail' => $email,
							'ximg'  => $imgName
						));
					}
					if ($stmt) {
						redirectTo('<p class="alert alert-success" role="alert"><i class="fa fa-check"></i> '. $stmt->rowCount() .' record inserted</p>', 'back');
					}
				} else {
					// print the errors in formWarning
					foreach ($formWarning as $warn) {
						echo "<div class='alert alert-danger' role='alert'>";
						echo "<i class='fa fa-times'></i> ". $warn;
						echo "</div>";
					}
					redirectTo('','back',false);
				}
		echo '</div>';
		} else { redirectTo("Sorry !! you cannot browse this page directly"); }
// edit page
	} elseif ($action == 'edit') {
		$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $id = intval($_GET['id']) : 0;
		$stmt = $connect->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
		$stmt->execute(array($id));
		$fetch = $stmt->fetch();
		$recordResult = $stmt->rowCount();
		if ($recordResult > 0) {
?>
		<div class="container">
			<h1><?php echo lang('EDIT_MEMBER'); ?></h1>
			<form class="<?php echo $globalFormStyle ?>" action="members.php?action=update" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('USERNAME'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="text" name="username" placeholder="<?php echo lang('USERNAME'); ?>" value="<?php echo $fetch['username']; ?>" required />
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('PASSWORD'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="hidden" name="oldPass" value="<?php echo $fetch['password']; ?>" />
						<input type="password" name="newPass" placeholder="<?php echo lang('LEAVEBLANC'); ?>" />
						<i class="fa fa-eye" onmouseover="showPassword('newPass')" onmouseout="hidePassword('newPass')"></i> visible password
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('FULLNAME'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="text" name="fullname" placeholder="<?php echo lang('FULLNAME'); ?>" value="<?php echo $fetch['fullname']; ?>" required />
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('PROFILE_IMG') ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="file" name="image" class="input-file" />
					</div>
				</div>
				<div class="form-group row">
					<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('EMAIL'); ?></label>
					<div class="<?php echo $globalInputStyle ?>">
						<input type="email" name="email" placeholder="<?php echo lang('EMAIL'); ?>" value="<?php echo $fetch['email']; ?>" required />
					</div>
				</div>
				<input class="<?php echo $globalInputStyle ?>" type="submit" value="<?php echo lang('UPDATE'); ?>" />
			</form>
		</div>
<?php
	} else { redirectTo("<div class='container'><div class='alert alert-danger' role='alert'>Sorry !! There is no ". $id ." in members list</div></div"); }
// update page
	} elseif ($action == 'update') {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		echo '<div class="container">';
			echo '<h1>'. lang('UPDATE_MEM') .'</h1>';
				$user     = $_POST['username'];
				$fullname = $_POST['fullname'];
				$email    = $_POST['email'];
				$id       = $_POST['id'];
				$pass = empty($_POST['newPass']) ? $_POST['oldPass'] : hashed_pass($_POST['newPass']);
				// profileImg tricks
				$allowedExt = array('jpeg','jpg','png','gif');
				$profileImg = $_FILES['image'];
				$imgName    = str_replace(' ', '', 'Xshop_'. date('Y-m-d_h-m-s') .'_'. rand(0,999999999999) .'_'. $profileImg['name']);
				$imgExt     = strtolower(end(explode('/',$profileImg['type'])));
				$imgTmp     = $profileImg['tmp_name'];
				$imgSize    = $profileImg['size'];
				$imgError   = $profileImg['error'];
				// get the inputs errors and set into formWarning
				$formWarning = array();
				// check if username exist
				$fetch = getAll('username','users','id',$id);
				if ($user != $fetch[0]['username']) {
					$check = checkItemExist("username", "users", $user);
					if ($check > 0) { $formWarning[] = "the username <b>". $user ."</b> already exist"; }
				}
				
				if ($imgError == 0) {
					if ($imgSize >= fileMaxSize(2)) {
						$formWarning[] = 'image size cant be larger than <b>2MB</b>';
					}
					if (!in_array($imgExt, $allowedExt)) {
						$formWarning[] = 'the image type is not allowed';
					}
				}
				if (empty($user)) { $formWarning[] = "username can be <b>empty</b>"; }
				if (empty($fullname)) { $formWarning[] = "fullname can be <b>empty</b>"; }
				if (empty($email)) { $formWarning[] = "e-mail can be <b>empty</b>"; }
				if (strlen($user) < 4) { $formWarning[] = "username can be less then 4 char"; }
				if (strlen($fullname) <5) { $formWarning[] = "username can be greater than 5 char"; }

				if (empty($formWarning)) {
					if ($imgError > 0) {
						$stmt = $connect->prepare("UPDATE users SET username = ?, fullname = ?, email = ?, password = ? WHERE id = ?");
						$stmt->execute(array($user, $fullname, $email, $pass, $id));
					} else {
						move_uploaded_file($imgTmp, $profileDirectory . $imgName);
						$stmt = $connect->prepare("UPDATE users SET username = ?, fullname = ?, email = ?, password = ?, image = ? WHERE id = ?");
						$stmt->execute(array($user, $fullname, $email, $pass, $imgName, $id));
					}
					if ($stmt) {
						redirectTo('<p class="alert alert-success" role="alert"><i class="fa fa-check"></i> '. $stmt->rowCount() .' record updated</p>','members.php');
					}
				} else {
					foreach ($formWarning as $warn) {
						echo "<div class='alert alert-danger' role='alert'>";
							echo "<i class='fa fa-times'></i> ". $warn;
						echo "</div>";
					}
					echo '<a class="btn btn-primary" href="?action=edit&id='. $id .'"><i class="fa fa-arrow-left"></i> back</a>';
				}
		echo '</div>';
		} else { 
			redirectTo('<div class="alert alert-danger" role="alert">Sorry !! you cannot browse this page directly</div>');
		}
// activate page
	} elseif ($action == 'activate') {
		$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $id = intval($_GET['id']) : 0;
		$check = checkItemExist('id', 'users', $id);
		if ($check == 1){
			$stmt = $connect->prepare("UPDATE users SET regStatus = 1 WHERE id = ?");
			$stmt->execute(array($id));
			echo "<div class='container'>";
				echo "<h1>". lang('ACTIVATE_MEMBER') ."</h1>";
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
		$check = checkItemExist('id', 'users', $id);
		if ($check > 0){
			$stmt = $connect->prepare("DELETE FROM users WHERE id = ?");
			$stmt->execute(array($id));
			echo "<div class='container'>";
				echo "<h1>". lang('DELETE_MEMBER') ."</h1>";
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
	include $inc . 'footer.php';
} else {
	header('location: index.php');
	exit();
}
ob_end_flush();
?>