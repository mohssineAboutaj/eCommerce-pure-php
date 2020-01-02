<?php
/*
==================================================
===> MAIN PAGE LOGIN TO X-shop
==================================================
*/
ob_start();
session_start();
$pageTitle = "Login/SignUp";
if (isset($_SESSION['userId'])) {
  header('location: index.php');
}
include 'init.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['login'])) {
    $username   = $_POST['username'];
    $hashedPass = hashed_pass($_POST['password']);

    $stmt = $connect->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute(array($username, $hashedPass));
    $fetch = $stmt->fetch();
    $recordResult = $stmt->rowCount();
    if ($recordResult > 0) {
      $_SESSION['user'] = $username;
      $_SESSION['userId'] = $fetch['id'];
      header('location: index.php');
      exit();
    }
  } else {
    $name  = str_replace(" ", "", $_POST['name']);
    $full  = $_POST['full'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $email = $_POST['email'];
    // the errors
    $formErr = array();
    if(empty($name)){ array_push($formErr, lang('USERNAME_EMPTY')); }
    if(strlen($name) < 4){ array_push($formErr, lang('USERNAME_<_4')); }
    if(empty($full)){ array_push($formErr, lang('FULLNAME_EMPTY')); }
    if(strlen($full) < 6){ array_push($formErr, lang('FULLNAME_<_6'));}
    if(empty($pass1)){ array_push($formErr, lang('PASS_EMPTY')); }
    if($pass1 !== $pass2){ array_push($formErr, lang('PASS_NO_MUTCH')); }
    if(empty($email)){ array_push($formErr, lang('EMAIL_EMPTY')); }
    $filterName = filter_var($name, FILTER_SANITIZE_STRING);
    $filterFullname = filter_var($full, FILTER_SANITIZE_STRING);
    $filterMail = filter_var($email, FILTER_VALIDATE_EMAIL);
    $hashed = hashed_pass($pass1);
    $check = checkItemExist('username', 'users', $name);
    if($check == 1){ array_push($formErr, "sorry this username already exist"); }
    if (empty($formErr) && $check == 0) {
      $signUpStmt = $connect->prepare("INSERT INTO users(
                                            username, 
                                            password, 
                                            fullname, 
                                            email, 
                                            regStatus, 
                                            date) 
                                        VALUES (
                                            :name, 
                                            :pass, 
                                            :full, 
                                            :mail, 
                                            0, 
                                            now()) 
                                        ");
      $signUpStmt->execute(array(
            'name' => $filterName,
            'pass' => $hashed,
            'full' => $filterFullname,
            'mail' => $filterMail
      ));
    }
  }
}
?>

<div class="loginPage">
  <div class="container containerForms">
    <h1>
      <span class="selected" id="log"><?php echo lang('LOGIN') ?></span> | 
      <span id="sig"><?php echo lang('SIGN_UP') ?></span>
    </h1>
    <div class="msgs">
    <?php
      if (!empty($formErr)) {
        foreach ($formErr as $err) {
          echo '<div class="alert alert-danger" role="alert">'. $err .'</div>';
        }
      } else {
        if (isset($_POST['sign-up']) && empty($formErr)) {
          echo '<div class="alert alert-success" role="alert">'. lang('REG_OK') .'</div>';
        }
      }
    ?>
    </div>
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" class="loginForm">
      <label><?php echo lang('USERNAME') ?></label>
      <input type="text" name="username" placeholder="<?php echo lang('USERNAME_HOLDER') ?>" />
      <label><?php echo lang('PASSWORD') ?></label>
      <input type="password" name="password" placeholder="*************" />
      <input type="submit" name="login" value="<?php echo lang('LOGIN_BTN') ?>" class="btn btn-success" />
    </form>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="signUpForm">
      <label><?php echo lang('USERNAME') ?></label>
      <div>
        <input type="text" name="name" placeholder="<?php echo lang('USERNAME_HOLDER') ?>" required pattern=".{4,}" title="<?php echo lang('USERNAME_<_4') ?>" />
      </div>
      <label><?php echo lang('FULLNAME') ?></label>
      <div>
        <input type="text" name="full" placeholder="<?php echo lang('FULLNAME_HOLDER') ?>" required pattern=".{6,}" title="<?php echo lang('FULLNAME_<_6') ?>" />
      </div>
      <label><?php echo lang('NEW_PASS') ?></label>
      <div>
        <input type="password" name="pass1" placeholder="*************" required />
      </div>
      <label><?php echo lang('CON_PASS') ?></label>
      <div>
        <input type="password" name="pass2" placeholder="*************" required />
      </div>
      <label><?php echo lang('EMAIL') ?></label>
      <div>
        <input type="email" name="email" placeholder="<?php echo lang('EMAIL_HOLDER') ?>" required />
      </div>
      <input name="sign-up" type="submit" value="<?php echo lang('SIGN_UP_BTN') ?>" class="btn btn-success" />
    </form>
  </div>
</div>

<?php
include $inc . 'footer.php';
ob_end_flush();
?>