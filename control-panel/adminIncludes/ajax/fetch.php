<?php

// include the connexion file to database
include '../../connect.php';
// include functions file
include '../functions/functions.php';
// include language file
include '../langs/en.php';

// function to fetch all comments from database
function commentsFunction(){
  global $connect;
  $cmntStmt = $connect->prepare("SELECT 
                                  comments.*,
                                  items.name AS item_name,
                                  users.username AS user_name
                                FROM comments INNER JOIN items
                                ON items.id = comments.itemId
                                INNER JOIN users
                                ON users.id = comments.memId
                                ORDER BY id DESC
                                ");
  $cmntStmt->execute();

  $fetch = $cmntStmt->fetchAll();

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
}

// function to fetch all categories from database
function categoriesFunction(){
  global $connect;
  $fetch = getAll('*','category');
  foreach($fetch as $row){
    echo '<tr>';
      echo '<th>'. $row['id'] .'</th>';
      echo '<td>'. $row['name'] .'</td>';
      echo '<td>'. $row['description'] .'</td>';
      echo '<td>'. $row['ordering'] .'</td>';
      echo '<td>';
        if($row['visibility'] == 0){
          echo '<i class="fa fa-check"></i>';
        } else {
          echo '<i class="fa fa-times"></i>';
        }
      echo '</td>';
      echo '<td>';
        if($row['allowComments'] == 0){
          echo '<i class="fa fa-check"></i>';
        } else {
          echo '<i class="fa fa-times"></i>';
        }
      echo '</td>';
      echo '<td>';
        if($row['allowAds'] == 0){
          echo '<i class="fa fa-check"></i>';
        } else {
          echo '<i class="fa fa-times"></i>';
        }
      echo '</td>';
      echo '<td>';
        echo '<a href="?action=edit&id='. $row['id'] .'" class="btn btn-sm btn-success"><i class="fa fa-edit"></i> edit</a>';
        echo '<a href="?action=delete&id='. $row['id'] .'" class="btn btn-sm btn-danger confirm"><i class="fa fa-trash"></i> delete</a>';
      echo '</td>';
    echo '</tr>'; 
  }
}

// function to fetch all items from database
function itemsFunction(){
  global $connect;
  $itemStmt = $connect->prepare("SELECT 
                                     items.*, 
                                     category.name AS itemCat, 
                                     users.username AS itemMem 
                                  FROM 
                                     items
                                  INNER JOIN
                                     category
                                  ON
                                     category.id = items.catId 
                                  INNER JOIN
                                     users
                                  ON
                                     users.id = items.memberId
                                  ORDER BY id DESC");
  $itemStmt->execute();
  $fetch = $itemStmt->fetchAll();

  foreach($fetch as $row){
    echo '<tr>';
      echo '<td>'. $row['id'] .'</td>';
      echo '<td>'. $row['name'] .'</td>';
      echo '<td>'. $row['description'] .'</td>';
      echo '<td>'. $row['price'] .'</td>';
      echo '<td>'. $row['addDate'] .'</td>';
      echo '<td>'. $row['countryMade'] .'</td>';
      echo '<td>'. $row['itemCat'] .'</td>';
      echo '<td>'. $row['itemMem'] .'</td>';
      echo '<td>'. str_replace(',',' ', $row['tags']) .'</td>';
      echo '<td>'; 
        if($row['status'] == 1){echo 'New'; }
        if($row['status'] == 2){echo 'Like New'; }
        if($row['status'] == 3){echo 'Used'; }
        if($row['status'] == 4){echo 'Old'; }
      echo '</td>';
      echo '<td>'. $row['views'] .'</td>';
      echo '<td>';
        echo '<a href="?action=edit&id='. $row['id'] .'" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> edit</a>';
        echo '<a href="?action=delete&id='. $row['id'] .'" class="btn btn-danger btn-sm confirm"><i class="fa fa-trash"></i> delete</a>';
        if ($row['appr'] == 0) {
          echo '<a href="?action=approve&id='. $row['id'] .'" class="btn btn-primary btn-sm"><i class="fa fa-check"></i>'. lang('APPROVE') .'</a>';
        }
      echo '</td>';
    echo '</tr>';
  }
}

// function to fetch all members from database
function membersFunction(){
  global $connect;
  $fetch = getAll('*','users','groupid','0');
  foreach ($fetch as $row) {
    echo '<tr>';
      echo "<th>". $row['id'] ."</th>";
      echo "<td>". $row['username'] ."</td>";
      echo "<td>";
      if (!empty($row['image'])) {
        echo "<img src='". '../data/uploads/profile/' . $row['image'] ."' />";
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
}

// check if fetch request exist and execute the condition
if (isset($_GET['fetching'])) {
  if ($_GET['fetching'] == 'comments'){
    commentsFunction();
  } elseif ($_GET['fetching'] == 'categories') {
    categoriesFunction();
  } elseif ($_GET['fetching'] == 'items') {
    itemsFunction();
  } elseif ($_GET['fetching'] == 'members') {
    membersFunction();
  }
} else {
  echo "<div class='alert alert-danger' role='alert'>";
    echo "You have an error <b>3awtani</b>";
  echo "</div>";
}