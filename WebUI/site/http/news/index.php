<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller, Garrett Dieckmann
 *  DATE:	12/12/2011
 *
 *  index.php is a file that maintains the news sliders on the main VirPong page.
 *  The php file includes the seperate news stories, so that news stories do not 
 *  need to be completely copied each time, but can instead be saved within their own
 *  file, in the news directory.
 *
 *  The news sliders are built ontop of Coda-Slider, a jquery plugin that provides
 *  the format of the VirPong sliders, as well as the automatic transitions between
 *  the slides. Coda-Slider can be found at:
 * 				http://www.ndoherty.biz/2009/10/coda-slider-2/
 *  This software is distributed by the author, under the GPL license, which can be
 *  found within the news directory.
 *
 *  INCLUDES:	header.php
 *				footer.php
 *				12.1.11.php
 *				10.31.1.php
 *				9.5.11.php
 *
 *  JavaScript: jquery-1.3.2.min.js
 *				jquery.easing.1.3.js
 *				jquery.coda-slider-2.0.js
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
?>

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


<div class="coda-slider-wrapper">
	<div class="coda-slider preload" id="coda-slider-1">

<?php
	include_once('stories/12.1.11.php');
	include_once('stories/10.31.11.php');
	include_once('stories/9.5.11.php');
?>

	</div> 
</div> 