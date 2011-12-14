<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller
 *  DATE:	12/10/2011
 *
 *  setskin.php allows users to select their preferred color scheme for the VirPong
 *  site. It displays a small version of the logo of each color scheme with the
 *  accompanying name displayed in the background color (which is not present in the
 *  logo). Clicking on any one of these schemes returns to setskin.php, passing the
 *  skin number as the "skin" variable in the query string.
 *
 *  When setskin.php receives a "skin" variable in the query string it tests to make
 *  sure that variable is a valid skin identifier. If so, it sets a cookie on the
 *  user's computer identifying the skin they have chosen.
 *
 *  Skinning was achieved with assistance from a tutorial available at:
 *  http://girlswhogeek.com/tutorials/2006/skinning-theming-your-website-with-php
 *
 *  INCLUDES:	header.php
 *		footer.php
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
?>


<?php
	session_start();

	if (	isset($_GET['skin'])
		&& is_numeric($_GET['skin'])
		&& is_dir(getcwd() . '/skins/' . $_GET['skin'])
	)
	{
		setcookie('myskin', $_GET['skin'], time()+(31*86400));
		header('Location: setskin.php');
	}

	include_once('header.php');

?>

<h1>&#9612; choose your theme &#9616;</h1>

<p><a href="setskin.php?skin=1" style="text-decoration:none">
<img src="skins/1/logo.png" width=106px height=80px style="vertical-align:middle" />
<span style="color:#7788CC">VirPong Classic</span>
</a></p>

<p><a href="setskin.php?skin=2" style="text-decoration:none">
<img src="skins/2/logo.png" width=106px height=80px style="vertical-align:middle" />
<span style="color:#AAAAAA">Logger Pride</span>
</a></p>

<p><a href="setskin.php?skin=3" style="text-decoration:none">
<img src="skins/3/logo.png" width=106px height=80px style="vertical-align:middle" />
<span style="color:#BCBCBC">Panda</span>
</a></p>

<p><a href="setskin.php?skin=4" style="text-decoration:none">
<img src="skins/4/logo.png" width=106px height=80px style="vertical-align:middle" />
<span style="color:#88DD88">Watermelon</span>
</a></p>


<?php
	include_once('footer.php');
?>