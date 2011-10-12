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

	</head>

	<body>
	
 	       <?php

			// connect to the server and open db1
	          	$conn = mysql_connect('localhost', 'root', 'sawinrocks')
				or die ("Connection failed. " . mysql_error());
			mysql_select_db('db1', $conn)
				or die ("Could not open connection. " . mysql_error());

			// pull out information on the logged in user
			$myQuery = "SELECT * FROM Customer WHERE username='" . $_SESSION['username'] . "';";
			$row = mysql_query($myQuery, $conn)
				or die ("Could not check password. " . mysql_error());
			$user = mysql_fetch_row($row);

			// if the user entered an incorrect password, send them back with an error
			if ($user[1] != $_POST['password']) {
				header("Location: accountsettings.php?pw=false");
				die();
			}

			// update the user's password
			$myQuery = "UPDATE Customer";
			$myQuery .= " SET password = '" . $_POST['newpassword'] . "'";
			$myQuery .= " WHERE username = '" . $_SESSION['username'] . "';";
			mysql_query($myQuery, $conn)
				or die("Could not update account." . mysql_error());

			// open db2
			mysql_select_db('db2', $conn)
				or die ("could not open connection" . mysql_error());

			// update the user's information
			$myQuery = "UPDATE Customer";
			$myQuery .= " SET firstname='" . $_POST["firstname"] . "', lastname='" . $_POST["lastname"] . "', email='" . $_POST["email"] . "', birthday='" . $_POST["year"] . "-" . $_POST["month"] . "-" . $_POST["day"] . "', gender='" . $_POST["gender"] . "'";
			$myQuery .= " WHERE username = '" . $_SESSION['username'] . "';";
			mysql_query($myQuery, $conn)
				or die("Could not update account." . mysql_error());

			// close the connection
			mysql_close($conn);

			// display a success message
			echo 'Your account information has been updated.';

        	?>

	</body>

</html>
