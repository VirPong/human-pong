<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller
 *  DATE:	12/10/2011
 *
 *  javascript.php is displayed when the user has JavaScript disabled and tries to
 *  navigate to a page that requires JavaScript. It displays a message informing the
 *  user that the requested feature requires JavaScript and asking that they enable
 *  it in order to continue.
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


<h1>&#9612; content unavailable &#9616;</h1>

<p>We're sorry, but this feature requires the use of JavaScript. Please edit your browser settings to enable JavaScript in order to continue enjoying the VirPong experience.</p>


<?php
	include_once('footer.php');
?>