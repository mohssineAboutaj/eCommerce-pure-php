<?php
  if (isset($_SESSION['user']) && userStatus($_SESSION['user']) == 1) {
    echo '<div class="text-center bg-white text-danger"><i class="fa fa-times"></i> '. lang('NOT_ACIVATE_YET') .'</div>';
  }
?>
<nav class="navbar navbar-expand-lg">
  <a class="navbar-brand" href="index.php">
  	<?php echo lang('X_SHOP'); ?>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<i class="fas fa-bars"></i>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo lang('CATEGORIES') ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <?php
          foreach(getAll('*','category') as $cat){
            echo '<a class="dropdown-item" href="categories.php?pageId='. $cat['id'] .'">'. $cat['name'] .'</a>';
          }
        echo '</div>';
      echo '</li>';
      if(isset($_SESSION['user'])){
			?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php
            $userImg = getAll('*','users','id',$_SESSION['userId']);
            foreach ($userImg as $info) {
              echo $_SESSION['user'] ." <img src='";
                if($info['image'] > 0){
                  echo $profileDirectory . $$info['image'];
                } else {
                  echo 'data/uploads/profile/defaultProfile.png';
                }
              echo "' alt=". $_SESSION['user'] ." />";
            }
          ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<?php
					if (userStatus($_SESSION['user']) == 0) {
				  	echo "<a class='dropdown-item' href='newAds.php'><i class='fa fa-plus'></i> ". lang('NEW_ITEM') ."</a>";
				  	echo "<a class='dropdown-item' href='profile.php'><i class='fa fa-user'></i> ". lang('MY_PROFILE') ."</a>";
				  	echo "<a class='dropdown-item' href='profile.php#ads'><i class='fa fa-shopping-bag'></i> ". lang('MY_ITEMS') ."</a>";
				  	echo "<a class='dropdown-item' href='profile.php#comments'><i class='fa fa-comments'></i> ". lang('MY_COMMENTS') ."</a>";
          } else {
            echo "<a class='dropdown-item not-allowed' href='#'><i class='fa fa-plus'></i> ". lang('NEW_ITEM') ."</a>";
            echo "<a class='dropdown-item not-allowed' href='#'><i class='fa fa-user'></i> ". lang('MY_PROFILE') ."</a>";
            echo "<a class='dropdown-item not-allowed' href='#'><i class='fa fa-shopping-bag'></i> ". lang('MY_ITEMS') ."</a>";
            echo "<a class='dropdown-item not-allowed' href='#'><i class='fa fa-comments'></i> ". lang('MY_COMMENTS') ."</a>";
          }
          echo "<a class='dropdown-item' href='logout.php'><i class='fa fa-sign-out-alt'></i> ". lang('LOGOUT') ."</a>";
				echo "</div>";
			} else {
				echo "<li class='nav-item'>";
					echo "<a class='nav-link' href='login.php'><i class='fa fa-sign-in'></i> ". lang('LOGIN_SIGNUP') ."</a>";
				echo "</li>";
			}
			?>
		</ul>
	</div>
</nav>