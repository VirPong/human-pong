<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller, Kyle Monnett
 *  DATE:	12/10/2011
 *
 *  404.php is displayed when the server cannot find the requested page. It contains
 *  a somewhat rude message to the user.
 *
 *  INCLUDES:	header.php
 *		footer.php
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
?>


<?php
	session_start();
	include_once('header.php');
?>


<h1>&#9612; 404 error &#9616;</h1>

<p>You're a horrible person for landing here.</p>


<?php
	include_once('footer.php');
?>