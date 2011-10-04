<?php
	session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


	<head>

		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

		<title>virPONG</title>

		<script src="login.js" type="text/javascript"></script>

	</head>


	<body>

		<?php
			if (isset($_SESSION['username']))
			{
				echo 'You are currently logged in as ' . $_SESSION['username'] . '<br />';
				echo '<form name="logout" id="logout" method="post" action="logout_post.php">';
				echo '<input type="submit" name="submitButton" value="Log out" />';
				echo '</form>';
			}
			else
			{
				echo '<form name="login" id="login" method="post" action="login_post.php">';
				echo 'Username: <input type="text" name="username" /><br />';
				echo 'Password: <input type="password" name="password" /><br />';
				echo '<input type="submit" name="submitButton" value="Log in" onclick="return validLogin();" />';
				echo '</form>';
				echo 'Not a member? <a href=register_form.php>Register</a> now!';
			}
		?>

	</body>


</html>