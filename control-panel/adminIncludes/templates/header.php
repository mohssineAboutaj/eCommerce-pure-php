<!DOCTYPE html>
<html lang="<?=$default_lang;?>" dir="<?=$default_dir?>">
<head>
	<meta charset="utf-8" />
	<title><?php printTitle() ?></title>
<!-- Start META tags -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="author" content="Mohssine Aboutaj" />
	<meta name="description" content="" />
<!-- End META tags -->
<!-- Start Css files -->
<?php
  foreach(scandir($css) as $cssFile) {
    if (pathinfo($cssFile, PATHINFO_EXTENSION) === 'css' && $cssFile !== 'style.css') {
      echo '<link rel="stylesheet" type="text/css" href="'. $css . $cssFile .'" />';
    }
  }
  echo '<link rel="stylesheet" type="text/css" href="'. $css .'style.css" />';
?>
<!-- End Css files -->
</head>
<body data-main-color="#26A65B" data-second-color="#eaeaea">
