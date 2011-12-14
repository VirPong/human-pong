<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller
 *  DATE:	12/10/2011
 *
 *  error.php is displayed when the database encounters an unexpected error. It
 *  apologizes to the user and asks them to try again or contact us.
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


<h1>&#9612; we're sorry &#9616;</h1>

<p>An error has occurred. Please try again.</p>

<p>If the problem persists, please <a href=http://cs340/contactus.php>contact</a>
	 our management.</p>



<?php
	include_once('footer.php');
?>