<nav class="navbar navbar-expand-lg navbar-dark">
  <a class="navbar-brand" href="index.php">
  	<?= lang('WESITE_NAME'); ?>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<i class="fas fa-bars"></i>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
			<li class="nav-item" <?php addClassActive('Admin Area'); ?>>
        <a class="nav-link" href="index.php"><?=lang('CONTROL_PANEL'); ?></a>
      </li>
      <li class="nav-item" <?php addClassActive('categories'); ?>>
				<a class="nav-link" href="categories.php"><?= lang('CATEGORY'); ?></a>
			</li>
			<li class="nav-item" <?php addClassActive('items') ?>>
				<a class="nav-link" href="items.php"><?= lang('ITEMS'); ?></a>
			</li>
			<li class="nav-item" <?php addClassActive('members') ?>>
				<a class="nav-link" href="members.php"><?= lang('MEMBERS'); ?></a>
			</li>
			<li class="nav-item" <?php addClassActive('comments') ?>>
				<a class="nav-link" href="comments.php"><?= lang('COMMENTS'); ?></a>
			</li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?= lang('OPTIONS'); ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="../index.php"><?= lang('VIS_SHOP'); ?></a>
					<a class="dropdown-item" href="categories.php?action=add"><i class="fa fa-cart-plus"></i><?= lang('ADD_NEW_CAT'); ?></a>
					<a class="dropdown-item" href="items.php?action=add"><i class="fa fa-plus"></i> <?= lang('ADD_NEW_ITEM'); ?></a>
					<a class="dropdown-item" href="members.php?action=add"><i class="fa fa-user-plus"></i><?= lang('ADD_NEW_MEMBER'); ?></a>
					<a class="dropdown-item" href="members.php?action=edit&id=<?= $_SESSION['id'] ?>"><?= lang('EDIT PROFIL'); ?></a>
					<a class="dropdown-item" href="logout.php"><?= lang('LOGOUT'); ?></a>
        </div>
      </li>
			<li class="nav-item">
				<a class="nav-link" href="settings.php"><?= lang('SETTINGS'); ?></a>
			</li>
    </ul>
  </div>
</nav>