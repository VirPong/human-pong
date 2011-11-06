<?php
	session_start();
	include_once('header.php');
?>


<h1>&#9612; log out &#9616;</h1>

<?php
	// destory the session and redirect the user to the login form
	session_destroy();
	header('Location:login_form.php?logout=true');
?>


<?php
	include_once($footer);
?>