<?php
	session_start();
	include_once('header.php');
?>



<h1>&#9612; welcome to VirPong! &#9616;</h1>

<p>
This is an unencrypted connection to the VirPong site. Check out the <a href="https://cs340/">secure site</a>. Or use the menus above and below to navigate smoothly between secure and non-secure pages.
</p>

<br /><p><center><h3 style="font-size:1.25em;">&bull;&nbsp;&nbsp; VirPong news &nbsp;&nbsp;&bull;</center></h3>

<?php
	include_once('stories/12.1.11.php');
?>
</p>

<p>
<?php
	include_once('stories/10.31.11.php');
?>
</p>

<p>
<?php
	include_once('stories/9.5.11.php');
?>

</p>

<?php
	include_once('footer.php');
?>
