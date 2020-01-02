<?php
/*
**************************************************
===> PAGE PROFILE
**************************************************
*/
ob_start();
session_start();
$pageTitle = "My Profile";
include 'init.php';
if (isset($_SESSION['userId'])) {
	$action = isset($_GET['action']) ? $action = $_GET['action'] : null;
	if ($action == 'edit') {
		$myInfo = getAll('*','users','username',$sessionUser);
		foreach ($myInfo as $info) {
?>
		<div class="container">
			<h1><?php echo lang('EDIT_PROFILE') ?></h1>
			<div class="col-sm-12 col-md-6 m-auto">
				<div class="card">
					<div class="edit-profile-img">
						<img class="card-img-top" src="
						<?php 
							if($info['image'] > 0){
								echo $profileDirectory . $info['image'];
							} else {
								echo $defaultProfile;
							}
						?>" title="<?php echo $_SESSION['user']; ?>" alt="profile-img" />
						<i class="fa fa-eye-dropper fa-2x" onclick="changeImg()"></i>
					</div>
					<div class="card-body">
						<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
							<input class="hide change-img" type="file" name="image" />
							<input type="hidden" name="id" value="<?php echo $_SESSION['userId']; ?>" />
							<div class="form-group row">
								<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('USERNAME') ?></label>
								<div class="<?php echo $globalInputStyle ?>">
									<input type="text" name="username" placeholder="<?php echo lang('USERNAME_HOLDER') ?>" value="<?php echo $info['username'] ?>" required />
								</div>
								<div class="grid-full " style="color:red">
									if you change username , you will be logout and login other time
								</div>
							</div>
							<div class="form-group row">
								<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('EMAIL') ?></label>
								<div class="<?php echo $globalInputStyle ?>">
									<input type="email" name="email" placeholder="<?php echo lang('EMAIL_HOLDER') ?>" value="<?php echo $info['email'] ?>" required />
								</div>
							</div>
							<div class="form-group row">
								<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('PASSWORD') ?></label>
								<div class="<?php echo $globalInputStyle ?>">
									<input type="hidden" name="old_pass" value="<?php echo $info['password'] ?>" />
									<input type="password" name="new_pass" placeholder="<?php echo lang('LEAVEBLANC') ?>" />
								</div>
							</div>
							<div class="form-group row">
								<label class="<?php echo $globalLabelStyle ?>"><?php echo lang('FULLNAME') ?></label>
								<div class="<?php echo $globalInputStyle ?>">
									<input type="text" name="fullname" placeholder="<?php echo lang('FULLNAME_HOLDER') ?>" value="<?php echo $info['fullname'] ?>" />
								</div>
							</div>
							<div class="<?php echo $globalInputStyle ?> float-right">
								<input type="submit" class="btn btn-success btn-block" value="<?php echo lang('EDIT') ?>" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
<?php
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$pass = empty($_POST['new_pass']) ? $_POST['old_pass'] : $_POST['new_pass'];
				$username = str_replace(' ', '', filter_var($_POST['username'], FILTER_SANITIZE_STRING));
				$hashedPass = hashed_pass($pass);
				$email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
				$fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
				$id       = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
				// profileImg tricks
				$allowedExt = array('jpeg','jpg','png','gif');
				$profileImg = $_FILES['image'];
				$imgName = str_replace(' ', '', 'Xshop_'. date('Y-m-d_h-m-s') .'_'. rand(0,999999999999) .'_'. $profileImg['name']);
				$imgExt  = strtolower(end(explode('/',$profileImg['type'])));
				$imgTmp  = $profileImg['tmp_name'];
				$imgSize = $profileImg['size'];
				$imgError   = $profileImg['error'];
				// get the inputs errors and set into formError
				$formError = array();
				if(empty($username)){ $formError[] = lang('USERNAME_EMPTY'); }
				if(empty($email)){ $formError[] = lang('FULLNAME_EMPTY'); }
				$fetch = getAll('username','users','id',$id);
				foreach ($fetch as $col) {
					if ($username != $col['username']) {
						$check = checkItemExist("username", "users", $username);
						if ($check > 0) { $formError[] = lang('USERNAME') ." <b>". $username ."</b> ". lang('ALREADY_EXIST'); }
					}
				}
				if ($profileImg['error'] == 0) {
					if ($imgSize >= fileMaxSize(2)) {
						$formError[] = lang('IMG_SIZE_>2MB');
					}
					if (!in_array($imgExt, $allowedExt)) {
						$formError[] = lang('IMG_NOT_ALLOWED');
					}
				}

				if (empty($formError)) {
					if ($imgError > 0) {
						$stmt = $connect->prepare("UPDATE users SET username = ?, password = ?, email = ?, fullname = ? WHERE id = ?");
						$stmt->execute(array($username, $hashedPass, $email, $fullname, $id));
					} else {
						move_uploaded_file($imgTmp, $profileDirectory . $imgName);
						$stmt = $connect->prepare("UPDATE users SET username = ?, password = ?, email = ?, fullname = ?, image = ? WHERE id = ?");
						$stmt->execute(array($username, $hashedPass, $email, $fullname, $imgName, $id));
					}
						if ($stmt) {
							echo '<div class="container">';
								echo '<div class="alert alert-success" role="alert">';
									echo '<i class="fa fa-check"></i> '. lang('ACC_UPDATE');
								echo '</div>';
							echo '</div>';
							if ($username == $info['username']) {
								redirectTo('','profile.php');
							} else {
								redirectTo('','logout.php');		
							}
						}
				} else {
					foreach ($formError as $err) {
						echo '<div class="container">';
							echo '<div class="alert alert-danger" role="alert">';
								echo '<i class="fa fa-times"></i> '. $err;
							echo '</div>';
						echo '</div>';
					}
				}
			}
		}
	}	elseif ($action == 'showAll') {
		$allItems = getAll('*','items','memberId',$_SESSION['userId']);
		if (!empty($allItems)) {
?>
		<div class="container">
			<h1><?php echo lang('ALL_ITEMS_ME') ?></h1>
			<div class="card">
				<div class="card-header">
					<?php echo lang('ALL_ITEMS_ME') ?>
				</div>
				<div class="card-body">
<?php
					echo "<div class='row'>";
					foreach ($allItems as $item) {
						echo "<div class='col-sm-12 col-md-4 col-lg-3'>";
							echo "<a href='"; 
							if ($item['appr'] != 0){
								echo "showAds.php?action=show&id=". $item['id'] ."'";}
							echo "'>";
								echo '<div class="card item-box">';
									echo '<div class="ads-img">';
										echo '<span class="price">'. $item['price'] .'$</span>';
										echo '<img class="card-img-top" src="';
											if (!empty($item['image'])) {
												echo $itemDirectory . $item['image'];
											} else {
												echo $defaultItem;
											}
										echo '" alt="item" title="'. $item['name'] .'" />';
									echo '</div>';
									echo '<div class="card-body">';
										if($item['appr'] == 0){
											echo "<span class='not-approve'>". lang('NOT_APPR') ."</span>";}
										echo "<h3 class='card-text'>". $item['name'] ."</h3>";
										echo '<p class="card-text">'. $item['description'] .'</p>';
										echo '<div class="date">'. $item['addDate'] .'</div>';
									echo '</div>';
								echo '</div>';
							echo "</a>";
						echo "</div>";
					}
					echo '</div>';
?>					
				</div>
			</div>
		</div>
<?php
		} else {
			header("location: index.php");
			exit();
		}
	} else {
	?>
	<div class="container">
		<h1><?php echo $sessionUser; ?> profile</h1>
		<div class="card">
			<div class="card-header">
				<i class="fa fa-info-circle"></i>
				<?php echo lang('MY_INFO') ?>
				<a href="?action=edit"><i class="fa fa-edit float-right"></i></a>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-sm-12 col-md-4">
						<?php 
						$user = getAll('*', 'users', 'username', $sessionUser);
						if ($user > 0) {
							foreach ($user as $info) {
								echo '<img src="';
									if (!empty($info['image'])) {
										echo $profileDirectory . $info['image'];
									} else {
										echo $defaultProfile;
									}
								echo '" width="100%" alt="profile img" title="'. $_SESSION['user'] .'" />';
							}
						}
						?>
					</div>
					<div class="col-sm-12 col-md-8">
					<?php
						if ($user > 0) {
							echo "<ul class='list-group list-group-flush'>";
							foreach ($user as $info) {
								echo '<li class="list-group-item"><i class="fa fa-user-circle"></i> '. lang('USERNAME') .' : <b>'. $info['username'] .'</b></li>';
								echo '<li class="list-group-item"><i class="fa fa-envelope"></i> '. lang('EMAIL') .' : <b>'. $info['email'] .'</b></li>';
								echo '<li class="list-group-item"><i class="fa fa-user-md"></i> '. lang('FULLNAME') .' : <b> '. $info['fullname'] .'</b></li>';
								echo '<li class="list-group-item"><i class="fa fa-calendar-times-o"></i> '. lang('DATE_REG') .' : <b> '. $info['date'] .'</b></li>';
							}
						}
						echo "</ul>";
					?>
					</div>
				</div>
			</div>
		</div>
		<div id="ads" class="card">
			<div class="card-header">
				<a href="?action=showAll" class="float-left"><i class="fa fa-eye"></i> <?php echo lang('SHOW_ALL') ?></a>
				<i class="fa fa-shopping-cart"></i>
				<?php echo lang('LATEST_4_ADS') ?></a>
			<?php
				if (userStatus($_SESSION['user']) == 0) {
						echo '<a class="float-right" href="newAds.php"><i class="fa fa-plus"></i></a>';
				}
			?>
			</div>
			<div class="card-body">
			<?php
				$myLatestItems = getIts('memberId', $info['id'], 4);
				if (!empty($myLatestItems)) {
					echo "<div class='row'>";
					foreach ($myLatestItems as $item) {
						echo '<a class="col-sm-12 col-md-4 col-lg-3" href="showAds.php?action=show&id='. $item['id'] .'">';
							echo '<div class="card item-box">';
								echo '<div class="ads-img">';
									echo '<span class="price">'. $item['price'] .'$</span>';
									echo '<img class="card-img-top" src="';
									if (!empty($item['image'])) {
										echo $itemDirectory . $item['image'];
									} else {
										echo $defaultItem;
									}
									echo '" alt="item" title="'. $item['name'] .'" />';
								echo '</div>';
								echo "<div class='card-body'";
									if($item['appr'] == 0){
										echo "<span class='not-approve'>". lang('NOT_APPR') ."</span>";}
									echo '<h3 class="card-text">'. $item['name'] .'</h3>';
									echo '<p class="card-text">'. $item['description'] .'</p>';
									echo '<div class="date">'. $item['addDate'] .'</div>';
								echo '</div>';
							echo '</div>';
						echo '</a>';
					}
					echo '</div>';
				} else {
					echo "<div class='alert alert-danger' role='alert'>". lang('NO_ITEM') ."</div>";
				}
				?>
			</div>
		</div>
		<div id="comments" class="card">
			<div class="card-header">
				<i class="fa fa-comments"></i>
				<?php echo lang('ALL_MY_CMNTS') ?>
			</div>
			<div class="card-body">
			<?php
			$comments = getAll('*','comments','memId',$info['id']);
			echo "<ul class='list-group list-group-flush'>";
			if (!empty($comments)) {
				foreach ($comments as $cmnt) {
					echo '<li class="list-group-item">';
						echo '<div class="row">';
							echo '<div class="col-8"><i class="fa fa-comment text-primary"></i> '. $cmnt['comment'] .'</div>';
							echo '<div class="col-4"><a href="showAds.php?action=show&id="'. $cmnt['itemId'] .'">'; 
								$itemInfo = getAll('name', 'items', 'id', $cmnt['itemId']);
								foreach ($itemInfo as $info) {
									echo $info['name'];
								} 
							echo '</a></div>';
						echo '</div>';
					echo '</li>';
				}
			echo "</ul>";
			} else {
				echo "<div class=''>". lang('NO_CMNTS') ."</div>";
			}
			?>
			</div>
		</div>
	</div>
	<?php
	}
	include $inc .'footer.php'; 
} else {
	header("location: index.php");
	exit();
}
ob_end_flush();
?>