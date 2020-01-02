<?php
/*
**************************************************
===> THE MAIN CONTROL PANEL PAGE
**************************************************
*/
ob_start();
session_start();
if (isset($_SESSION['adminLogin'])) {
  $pageTitle = "Admin Area";
  include 'init.php';

  // get latest members
  $latestMembers = 5;
  $members = getItems('*', 'users WHERE groupId != 1', 'id', $latestMembers);

  // get latest items
  $latestItems = 5;
  $items = getItems('*', 'items', 'id', $latestItems);
?>
<div class="container adminArea">
  <h1>admin area</h1>
  <div class="stat" id="all-stats"></div>
</div>

<div class="container adminArea">
  <div class="latest row">
    <div class="column col-sm-12 col-md-6">
<?php
      if (empty($members)){
        echo '<div class="container"><div class="alert alert-danger" role="alert">Sorry !! there is no members to show</div></div>';
      } else {
?>
        <table class="table table-hover">
          <thead class="thead-dark">
            <tr>
              <th class="col">
                <i class="fa fa-users"></i> 
                latest <?php echo $latestMembers; ?> memebers
              </th>
            </tr>
          </thead>
          <tbody>
<?php
        foreach ($members as $member) {
          echo "<tr>";
            echo "<td class='d-flex justify-content-between'>";
              echo "<div><i class='fa fa-user-circle'></i> ". $member['username'] ."</div>";
              echo "<div>";
                echo "<a class='btn btn-success btn-sm' href='members.php?action=edit&id=". $member['id'] ."'><i class='fa fa-edit'></i></a>";
                echo "<a class='btn btn-danger btn-sm confirm' href='members.php?action=delete&id=". $member['id'] ."'><i class='fa fa-trash'></i></a>";
              echo "</div>";
            echo "</td>";
          echo"</tr>";
        }
?>
          </tbody>
        </table>
<?php } ?>
    </div>
    <div class="column col-sm-12 col-md-6">
<?php
      if (empty($items)){
        echo '<div class="container"><div class="alert alert-danger" role="alert">Sorry !! there is no items to show</div></div>';
      } else {
?>
        <table class="table table-hover">
          <thead class="thead-dark">
            <tr>
              <th class="col">
                <i class="fa fa-shopping-cart"></i> 
                latest <?php echo $latestItems ?> items
              </th>
            </tr>
          </thead>
          <tbody>
<?php
        foreach ($items as $item) {
          echo "<tr>";
            echo "<td class='d-flex justify-content-between'>";
              echo "<div><i class='fa fa-shopping-basket'></i> ". $item['name'] ."</div>";
              echo "<div>";
                if ($item['appr'] == 0) {
                  echo "<a class='btn btn-primary btn-sm' href='items.php?action=approve&id=". $item['id'] ."'><i class='fa fa-check'></i></a>";
                }
                echo "<a class='btn btn-success btn-sm' href='items.php?action=edit&id=". $item['id'] ."'><i class='fa fa-edit'></i></a>";
                echo "<a class='btn btn-danger btn-sm confirm' href='items.php?action=delete&id=". $item['id'] ."'><i class='fa fa-trash'></i></a>";
              echo "</div>";
            echo "</tr>";
          echo "</td>";
        }
?>
          </tbody>
        </table>
<?php } ?>
    </div>
    <div class="column col-sm-12 col-md-6">
<?php
    $latestComments = 5;
    $cmntStmt = $connect->prepare("SELECT 
                                      comments.*, 
                                      users.username AS user_name
                                    FROM comments
                                    INNER JOIN users
                                    ON users.id = comments.memId
                                    WHERE comments.status != 0 
                                    AND users.regStatus != 0
                                    ORDER BY id DESC
                                    LIMIT $latestComments");
    $cmntStmt->execute();
    $cmnts = $cmntStmt->fetchAll();
    if (empty($cmnts)){
        echo '<div class="alert alert-danger" role="alert">Sorry !! there is no comments to show</div>';
    } else {
?>
      <table class="table table-hover">
        <thead class="thead-dark">
          <tr>
            <th class="col">
              <i class="fa fa-comments"></i> 
              latest <?php echo $latestComments ?> items
            </th>
          </tr>
        </thead>
        <tbody>
<?php
        foreach($cmnts as $cmnt){
          echo '<tr class="comments row">';
            echo '<td class="col-4"><b>'. $cmnt['user_name'] .'</b></td>';
            echo '<td class="col-8">';
              echo $cmnt['comment'];
            echo '</td>';
          echo '</tr>';
        }
      }
?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php
  include $inc . 'footer.php';
} else {
  header('location: index.php');
  exit();
}
ob_end_flush();
?>