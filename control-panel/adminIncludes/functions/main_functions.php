<?php
/*
** this file for main functions on website
*/

// show styling success message
function success($msg = '', $url = 'index.php', $time = 3){
  if ($msg == '') {
    header("location: index.php");
    exit();
  } else {
    echo '<div class="alert alert-success">';
      echo '<h3 style="text-align:center">';
        echo '<i class="fa fa-check"></i>';
        echo " $msg successfully";
      echo '</h3>';
    echo '</div>';
//    header("refresh: $time;url = $url");
//    exit();
  }
}

// show styling error message
function error(){}
