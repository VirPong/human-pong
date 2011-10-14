<?php
	session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


	<head>
		<link href="css/classic.css" rel="stylesheet" type="text/css" />
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

		<title>virPONG</title>

		<script src="login.js" type="text/javascript"></script>

	</head>


	<body>

		<?php
			// if the user is logged in, tell them so and display the log out button
			if (isset($_SESSION['username']))
			{
				echo 'You are currently logged in as ' . $_SESSION['username'] . '<br />';
				echo '<form name="logout" id="logout" method="post" action="logout_post.php">';
				echo '<input type="submit" name="submitButton" value="Log out" />';
				echo '</form>';
			}

			// if the user is not logged in, display the log in form and a registration link
			else
			{
				echo '<form name="login" id="login" method="post" action="login_post.php">';
				echo 'Username: <input type="text" name="username" /><br />';
				echo 'Password: <input type="password" name="password" /><br />';
				echo '<input type="submit" name="submitButton" value="Log in" onclick="return validate();" />';
				echo '</form>';
				echo 'Not a member? <a href=register_form.php>Register</a> now!';
			}
		?>

	</body>


</html>