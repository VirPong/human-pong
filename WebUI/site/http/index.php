<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller, Garrett Dieckmann
 *  DATE:	12/10/2011
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

<p>
This is an unencrypted connection to the VirPong site. Check out the <a href="https://cs340/">secure site</a>. Or use the menus above and below to navigate smoothly between secure and non-secure pages.
</p>

<p>
<?php
	include_once('news/index.php');
?>
</p>

<?php
	include_once('footer.php');
?>
