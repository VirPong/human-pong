<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	
	<head>
		<link href="css/classic.css" rel="stylesheet" type="text/css" />
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
		
		<title>virPONG login</title>

	</head>

	<body>

		<?php
			// connect to the server and open db1
			$conn = mysql_connect('localhost', 'root', 'sawinrocks')
				or die ("Could not connect to server." . mysql_error());
			mysql_select_db('db1', $conn)
				or die ("Could not open database." . mysql_error());

			// select the row associated with the given username
			$getUser = "SELECT username, password FROM Customer WHERE username='" . $_POST['username'] . "';";
			$user = mysql_query($getUser, $conn)
				or die ("Unable to log in.");
			$cust = mysql_fetch_row($user);

			// if the passwords match, set a session cookie
			if($_POST['password']==$cust[1])
			{
				$_SESSION['username'] = $cust[0];
			}

			// close the connection
			mysql_close($conn);

			// if the session cookie is set, tell the user they are logged in
			if (isset($_SESSION['username']))
			{
				echo 'You are now logged in.<br /><a href=login_form.php>Go to log out page</a>.';
			}

			// if it's not set, print an error message
			else
			{
				echo 'Unable to log in.';
			}
		?>

	</body>

</html>
