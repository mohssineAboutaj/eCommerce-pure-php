<footer class="no-decore">
	<div class="container">
    <div class="row">
      <div class="col">
    		&copy; 2017 , designed and programming by <b>Mohssine Aboutaj</b>
    	</div><br/>
    	<div class="col">
    		<a href="?lang=ar">العربية</a>
    		<a href="?lang=en">english</a>
    	</div>
    </div>
  </div>
</footer>
<?php
  echo '<script src="'. $js .'jquery-3.1.1.min.js"></script>';
  foreach(scandir($js) as $jsFile) {
    if (pathinfo($jsFile, PATHINFO_EXTENSION) === 'js' && $jsFile !== 'custom.js' && $jsFile !== 'jquery-3.1.1.min.js') {
      echo '<script src="'. $js . $jsFile .'"></script>';
    }
  }
  echo '<script src="'. $js .'custom.js"></script>';
?>
</body>
</html>