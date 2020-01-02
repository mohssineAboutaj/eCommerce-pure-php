<!DOCTYPE html>
<html dir="<?php echo $siteDirection ?>">
<head>
	<meta charset="utf-8" />
	<title><?php printTitle() ?></title>
<!-- Start META tags -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<?php
echo "\t";
$meta = array(
					'viewport'    => 'width=device-width, initial-scale=1',
					'author'      => 'Mohssine Aboutaj',
					'description' => ''
				);
foreach ($meta as $name => $content) {
	echo '<meta name="'. $name .'" constant="'. $content .'" />';
	echo "\n\t";
}
?>
<!-- End META tags -->
<!-- Start Css files -->
<?php
echo "\t";
	foreach (scandir($css) as $file) {
		if (pathinfo($file, PATHINFO_EXTENSION) === "css" && $file !== 'style.css') {
			echo '<link rel="stylesheet" type="text/css" href="'. $css . $file .'" />';
			echo "\n\t";
		}
	}
  echo '<link rel="stylesheet" type="text/css" href="'. $css .'style.css" />';
?>
<!-- End Css files -->
<!-- Start ads -->
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-1826219043190800",
    enable_page_level_ads: true
  });
</script>
<!-- End ads -->

</head>
<body data-main-color="#26A65B" data-second-color="#eaeaea">
