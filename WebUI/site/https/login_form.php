<?php
	session_start();
	include_once('header.php');
?>


<h1>&#9612; log in &#9616;</h1>

<?php
	// if the user is logged in, tell them so and display the log out button
	if (isset($_SESSION['username']))
	{
		echo '<p>You are currently logged in as <b>'
			. $_SESSION['username'] . '</b>.<br />';
	}

	// if not logged in, display the log in form and a registration link
	else
	{
		// if the user just logged out, tell them so
		if(@$_GET['logout']=='true') {
			echo '<p>You are now logged out.</p><br />';
		}
		// if the user just logged out, tell them so
		if(@$_GET['login']=='false') {
			echo '<p><span class="errormsg">Unable to log in. 
				Please try again.</span></p>';
		}
		echo '<p><form name="login" id="login" method="post" 
			action="login_post.php">';
		echo 'Username: <input type="text" name="username" /><br />';
		echo 'Password: <input type="password" name="password" /><br />';
		echo '<input type="submit" name="submitButton" value="Log in" 
			onclick="return validate();" />';
		echo '</form></p>';
		echo '<p>Not a member? <a href=register_form.php>Register</a> 
			now!</p>';
	}
?>


<?php
	include_once($footer);
?>