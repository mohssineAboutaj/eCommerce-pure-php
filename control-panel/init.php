<?php
/*
**************************************************
===> INCLUDE ALL PAGES TO USE IN EVERY PAGE IN SITE
**************************************************
*/

// include connect file for connect to database
include 'connect.php';

// file routes : functions, libs, langs, header, navbar, footer
$func = 'adminIncludes/functions/';
$langs = 'adminIncludes/langs/';
$libs = 'adminIncludes/libs/';
$inc = 'adminIncludes/templates/';

// control panel layout
$css = 'adminLayout/css/';
$img = 'adminLayout/img/';
$js = 'adminLayout/js/';

/* include the require files ********/

/* global bootstrap4 grid system properties */
$globalFormStyle = 'col-sm-12 col-md-6';
$globalLabelStyle = 'col-sm-12 col-md-3';
$globalInputStyle = 'col-sm-12 col-md-9';
/* global bootstrap4 grid system properties ********/

// global number to fetch data from database
$globalLimit = 10;

// include header and functions
include $func . 'main_functions.php';
include $func . 'functions.php';
include $func . 'settings_functions.php';
include $func . 'action_functions.php';

// change languages of website
$default_dir = "ltr";
$default_lang = "en";
if (isset($_GET['lang'])) {
	$_SESSION['lang'] = $_GET['lang'];
	$lang = $_GET['lang'];
  include $langs . $lang .'.php';
	$default_lang = $lang;
	if ($lang == "ar") {
		$default_dir = "rtl";
	}
} else {
  if (isset($_SESSION['lang'])) {
		$lang = $_SESSION['lang'];
		if ($lang == "ar") {
			$default_dir = "rtl";
		}
		include $langs . $lang .'.php';
  } else {
    include $langs . $default_lang . '.php';
  }
}

include $inc . 'header.php';

// include navbar
if (!isset($noNavbar)) {
	include $inc . 'navbar.php';
}