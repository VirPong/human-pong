<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller, Garrett Dieckmann, Aryn Grause
 *  DATE:	12/13/2011
 *
 *  index.php is the main page of the VirPong site. It displays a short welcome
 *  message and a slider box with the latest in VirPong news.
 *
 *  The slider box requires the use of JavaScript. In the case of disabled JavaScript
 *  the user is immediately redirected to index_nojs.php which displays the same
 *  information in a different format.
 *
 *  INCLUDES:	header.php
 *		footer.php
 *		news/index.php
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
?>


<?php
	session_start();
	include_once('header.php');
?>


<noscript>
	<meta HTTP-EQUIV="REFRESH" content="0; url=index_nojs.php">
</noscript>



<h1>&#9612; welcome to VirPong! &#9616;</h1>

<p>Welcome to the VirPong community! Please navigate around the VirPong website to get	a sense of what VirPong is all about. Be sure to take a look at <a href=systemrequirements.php>what it takes</a> to get VirPong running on your own device, as well as look at <a href=topplayers.php>the stats</a> of some of our current players.</p>

<p>Even as a guest, please feel free to <a href=gameplay.php>try out a game</a> of VirPong online. If you like it, consider <a href=https://cs340.pugetsound.edu/register_form.php>registering</a> a VirPong account, which will allow you to track your games and your game stats.</p>

<p>Thanks,<br /><a href=contactus.php>The VirPong Team</a></p>

<p>
<?php
	include_once('news/index.php');
?>
</p>

<?php
	include_once('footer.php');
?>
