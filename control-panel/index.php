<?php
/*
**************************************************
===> MAIN PAGE TO LOGIN TO CONTROL PANEL
**************************************************
*/

ob_start();
session_start();
	$noNavbar = '';
	$pageTitle = "Admin Login";
	if (isset($_SESSION['adminLogin'])) {
		header('location: adminArea.php');
	}
	include 'init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$adminUsername = $_POST['username'];
	$password = $_POST['pass'];
	$codedPass = hashed_pass($password);

	$stmt = $connect->prepare("SELECT * FROM users WHERE username = ? AND password = ? AND groupId = 1 LIMIT 1");
	$stmt->execute(array($adminUsername, $codedPass));
	$fetch = $stmt->fetch();
	$recordResult = $stmt->rowCount();
	if ($recordResult > 0) {
		$_SESSION['adminLogin'] = $adminUsername;
		$_SESSION['id'] = $fetch['id'];
		header('location: adminArea.php');
		exit();
	}
}

?>

<div class="adminAreaLoginPage">
	<div class="container">
		<h1 class="text-center">wellcome to x-website control panel</h1>
		<h2 class="text-center">get in sir</h2>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="adminLogin col-sm-12 col-md-6">
			<h3>login form</h3>
			<div class="form-group row">
				<label class="col-sm-12 col-md-4" for="user">username</label>
				<div class="col-sm-12 col-md-8">
					<input id="user" type="text" name="username" autocomplete="off" required="required" placeholder="type your username" autofocus="on" />
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-12 col-md-4" for="pass">password</label>
				<div class="col-sm-12 col-md-8">
					<input id="pass" type="password" name="pass" autocomplete="new-password" required="required" placeholder="type your password" />
				</div>
			</div>
			<div class="form-group row">
				<div class="offset-md-4 col-sm-12 col-md-8">
					<input class="btn btn-primary btn-block" type="submit" value="&#xf3c1; login" />
				</div>
			</div>
		</form>
	</div>
</div>

<?php
include $inc . 'footer.php';
ob_end_flush();
?>