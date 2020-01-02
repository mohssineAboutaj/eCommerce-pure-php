<?php
/*
==================================================
===> INCLUDE ALL PAGES TO USE IN EVERY PAGE IN WEBSITE
==================================================
*/

// include connect file for connect to database
include 'control-panel/connect.php';

// if session exist
$sessionUser = '';
if (isset($_SESSION['user'])) {
	$sessionUser = $_SESSION['user'];
}

// file routes : functions, libs, langs, header, navbar, footer
$func = 'includes/functions/';
$langs = 'includes/langs/';
$libs = 'includes/libs/';
$inc = 'includes/templates/';

// control panel layout
$css = 'layout/css/';
$img = 'layout/img/';
$js = 'layout/js/';

// change languages of website
if (isset($_GET['lang'])) {
  $_SESSION['lang'] = $_GET['lang'];
  include $langs . $_SESSION['lang'] .'.php';
} else {
  if (isset($_SESSION['lang'])) {
    include $langs . $_SESSION['lang'] .'.php';
  } else {
    include $langs . 'en.php';
  }
}
// change website direction
if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'ar') {
  $siteDirection = 'rtl';
} else {
  $siteDirection = 'ltr';
}


// include header and functions
include $func . 'functions.php';
include $inc . 'header.php';
include $inc . 'navbar.php';

// uploads directory
$uploads = 'data/uploads/';
// profile images directory
$profileDirectory = $uploads . 'profile/';
$defaultProfile = $profileDirectory .'defaultProfile.png';
// items images directory
$itemDirectory = $uploads . 'items/';
$defaultItem = $itemDirectory . 'defaultItem.jpg';

/* global bootstrap4 grid system properties */
$globalFormStyle = 'col-sm-12 col-md-6';
$globalLabelStyle = 'col-sm-12 col-md-3';
$globalInputStyle = 'col-sm-12 col-md-9';
/* global bootstrap4 grid system properties ********/
