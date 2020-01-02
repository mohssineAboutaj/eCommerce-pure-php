<?php
ob_start();
session_start();
$pageTitle = "Settings";
if (isset($_SESSION['adminLogin'])) {
  include 'init.php';
?>
  <div class="container settings">
    <h1><?php echo lang('ADMIN_SETTINGS') ?></h1>
<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sorting = $_POST['show-sorting'];
    $defaultLimit = $_POST['default-limit'];

    echo "sort : $sorting <br> defaultL : $defaultLimit";
  }
?>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
      <div class="option">
        <label for="show-sorting">show sorting select in every page adminstrate</label>
        <input type="checkbox" name="show-sorting" id="show-sorting" />
        <span class="checkmark"></span>
      </div>
      <div class="option">
        <label>default number of element in table in administrate page</label>
        <select name="default-limit">
        <?php
          for ($i = 2;$i <= 20;$i++) { 
            echo '<option value="'. $i * 5 .'">'. $i * 5 .'</option>';
          }
        ?>
        </select>
      </div>
      <input type="submit" value="<?php echo lang('SAVE') ?>" class="btn btn-success btn-md" />
    </form>
  </div>
<?php
// include the footer
  include $inc . 'footer.php';
} else {
  header('location: index.php');
  exit();
}
ob_end_flush();
?>