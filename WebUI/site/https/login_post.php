<?php
	session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	
	<head>
	
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
		
		<title>virPONG login</title>

	</head>

	<body>

		<?php
			$conn = mysql_connect('localhost', 'root', 'sawinrocks')
				or die ("Could not connect to server." . mysql_error());
			mysql_select_db('db1', $conn)
				or die ("Could not open database." . mysql_error());

			$getUsers = "SELECT username, password FROM Customer";
			$users = mysql_query($getUsers, $conn);

			while($user = mysql_fetch_row($users))
			{
				if($_POST['username']==$user[0] && $_POST['password']==$user[1])
				{
					$_SESSION['username'] = $user[0];
				}
				
			}

			mysql_close($conn);

			if (isset($_SESSION['username']))
			{
				echo 'You are now logged in.<br /><a href=login_form.php>Log out</a>.';
			}
			else
			{
				echo 'Unable to login.';
			}
		?>

	</body>

</html>
