<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller
 *  DATE:	12/12/2011
 *
 *  logout_post.php logs the user out by deleting all session data, including the
 *  session cookie that stored the username. It then redirects the user to
 *  login_form.php, which will inform the user of his successful log out.
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

<?php
	// destory the session and redirect the user to the login form
	session_destroy();
	header('Location:login_form.php?logout=true');
?>


<?php
	include_once('footer.php');
?>