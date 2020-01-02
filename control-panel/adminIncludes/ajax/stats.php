<?php
  include '../../connect.php';
  include '../functions/functions.php';
?>
<div class="row">
  <div class="column col-xs-6 col-md-6">
    <a href="members.php?action=adminArea&activate=activate">
      <div class="card">
        <h6>handing members</h6>
        <div class="row">
          <i class="col fa fa-user-plus"></i>
          <span class="col"><?php echo count(getAll('id', 'users', 'regStatus', 0)); ?></span>
        </div>
      </div>
    </a>
  </div>
  <div class="column col-xs-6 col-md-6">
    <a href="items.php?action=adminArea&activate=activate">
      <div class="card">
        <h6>handing items</h6>
        <div class="row">
          <i class="col fa fa-shopping-cart"></i>
          <span class="col"><?php echo count(getAll('id', 'items', 'appr', 0)); ?></span>
        </div>
      </div>
    </a>
  </div>
  <div class="column col-xs-12 col-md-4">
    <a href="members.php">
      <div class="card">
        <h6>total members</h6>
        <div class="row">
          <i class="col fa fa-users"></i>
          <span class="col"><?php echo count(getAll('id', 'users')); ?></span>
        </div>
      </div>
    </a>
  </div>
  <div class="column col-xs-12 col-md-4">
    <a href="items.php">
      <div class="card">
        <h6>total items</h6>
        <div class="row">
          <i class="col fa fa-shopping-cart"></i>
          <span class="col"><?php echo count(getAll('id', 'items')); ?></span>
        </div>
      </div>
    </a>
  </div>
  <div class="column col-xs-12 col-md-4">
    <a href="comments.php">
      <div class="card">
        <h6>total comments</h6>
        <div class="row">
          <i class="col fa fa-comments"></i>
          <span class="col"><?php echo count(getAll("id", "comments")); ?></span>
        </div>
      </div>
    </a>
  </div>
</div>
