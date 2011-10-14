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
					or die ("connection failed." . mysql_error());
			mysql_select_db('db1', $conn)
				or die ("could not open connection" . mysql_error());

			// insert the login information into the Customer table
			$myQuery = "INSERT INTO Customer (username, password)";
			$myQuery .= " VALUES ('" . $_POST["username"] . "', '" . $_POST["password"] . "')";
			mysql_query($myQuery, $conn)
				or die("This username is already taken. Please <a href=register_form.php>register</a> with a new username.");

			// open db2
			mysql_select_db('db2', $conn)
				or die ("could not open connection" . mysql_error());

			// insert the account information into the Customer table
			$myQuery = "INSERT INTO Customer (username, firstname, lastname, email, birthday, gender)";
			$myQuery .= " VALUES ('" . $_POST["username"] . "', '" . $_POST["firstname"] . "', '" . $_POST["lastname"] . "', '" . $_POST["email"] . "', '" . $_POST["year"] . "-" . $_POST["month"] . "-" . $_POST["day"] . "', '" . $_POST["gender"] . "')";
			mysql_query($myQuery, $conn)
				or die("This username is already taken. Please <a href=register_form.php>register</a> with a new username.");

			// close the connection
			mysql_close($conn);

			// print a success message
			echo 'Thank you for registering!<br /><a href=login_form.php>Log in</a>';

        	?>

	</body>

</html>
