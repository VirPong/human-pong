<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<title>Coda-Slider 2.0</title>
	<meta http-equiv="Content-Language" content="en-us" />
	
	<meta name="author" content="Niall Doherty" />
	
	<!-- Begin Stylesheets -->
		<!-- Text size and fonts are within reset.css -->
		<link rel="stylesheet" href="../main.css" type="text/css" media="screen" />
	<!-- End Stylesheets -->
	
	<!-- Begin JavaScript -->
		<script type="text/javascript" src="news/javascripts/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="news/javascripts/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="news/javascripts/jquery.coda-slider-2.0.js"></script>
		 <script type="text/javascript">
			$().ready(function() {
				$('#coda-slider-1').codaSlider({
					autoSlide: true,
					autoSlideInterval: 4000,
					autoSlideStopWhenClicked: true,
					dynamicArrows: false
				});
			});
		 </script>
	<!-- End JavaScript -->
	
</head>

<body class="coda-slider-no-js">
	

<div class="coda-slider-wrapper">
	<div class="coda-slider preload" id="coda-slider-1">
	<?php
		include_once('stories/9.5.11.php');
	?>
	<?php
		include_once('stories/10.31.11.php');
	?>
	<?php
		include_once('stories/12.1.11.php');
	?>
	</div> <!-- .coda-slider -->
</div> <!-- .coda-slider-wrapper -->

</body>
</html>