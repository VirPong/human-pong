<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller, Garrett Dieckmann, Aryn Grause
 *  DATE:	12/13/2011
 *
 *  index_nojs.php is a JavaScript free version of the main page of the VirPong
 *  site. It displays a short welcome message and the latest in VirPong news.
 *
 *  INCLUDES:	header.php
 *		footer.php
 *		stories/*
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
?>


<?php
	session_start();
	include_once('header.php');
?>



<h1>&#9612; welcome to VirPong! &#9616;</h1>

<p>Welcome to the VirPong community! Please navigate around the VirPong website to get	a sense of what VirPong is all about. Be sure to take a look at <a href=systemrequirements.php>what it takes</a> to get VirPong running on your own device, as well as look at <a href=topplayers.php>the stats</a> of some of our current players.</p>

<p>Even as a guest, please feel free to <a href=gameplay.php>try out a game</a> of VirPong online. If you like it, consider <a href=https://cs340.pugetsound.edu/register_form.php>registering</a> a VirPong account, which will allow you to track your games and your game stats.</p>

<p>Thanks,<br /><a href=contactus.php>The VirPong Team</a></p>

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
