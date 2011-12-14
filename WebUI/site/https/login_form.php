<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller
 *  DATE:	12/13/2011
 *
 *  login_form.php displays differently depending on whether the user is logged in
 *  to a VirPong account or not.
 *
 *  Logged in users see a message saying they are logged in and displaying their
 *  username. If they have just registered, they also see a message thanking them for
 *  joining VirPong.
 *
 *  Logged out users see a form allowing them to log in. If they have just logged
 *  out, they also see a message informing them that their logout was successful.
 *
 *  The form validation (checking for valid user input as a means of preventing SQL
 *  injection) requires the use of JavaScript. In the case of disabled Javascript
 *  the user is immediately redirected to skins/javascript.php, which asks that the
 *  user enable JavaScript to use this feature.
 *
 *  INCLUDES:	header.php
 *		footer.php
 *
 *  Javascript:	login.js
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
?>


<?php
	session_start();
	include_once('header.php');
?>


<script type="text/javascript" src="login.js"></script>
<noscript>
	<meta HTTP-EQUIV="REFRESH" content="0; url=skins/javascript.php">
</noscript>


<h1>&#9612; log in &#9616;</h1>

<?php
	// if the user is logged in, tell them so and display the log out button
	if (isset($_SESSION['username']))
	{
		// if the user just registered, tell them so
		if(@$_GET['reg']=='true') {
			echo '<p>Thank you for registering!</p>';
		}
		echo '<p>You are currently logged in as <b>'
			. $_SESSION['username'] . '</b>.</p>';
	}

	// if not logged in, display the log in form and a registration link
	else
	{
		// if the user just logged out, tell them so
		if(@$_GET['logout']=='true') {
			echo '<p>You are now logged out.</p>';
		}
		// if the user could not log in, tell them so
		if(@$_GET['login']=='false') {
			echo '<p><span class="errormsg">Unable to log in. 
				Please try again.</span></p>';
		}
		echo '<p><form name="login" class="inputarea" id="login" 
			method="post" action="login_post.php">';
		echo '<label for="username">Username</label>';
		echo '<input type="text" name="username" /><br />';
		echo '<label for="password">Password</label>';
		echo '<input type="password" name="password" /><br />';
		echo '<label for="submit">&nbsp;</label>';
		echo '<input type="submit" value="Log in" 
			onclick="return validate();" />';
		echo '</form></p>';
		echo '<p>Not a member? <a href=register_form.php>Register</a> 
			now!</p>';
	}
?>


<?php
	include_once('footer.php');
?>