<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	
	<head>
	
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
		
		<title>virPONG</title>

<!--do i need this line?-->
		<script src="register.js" type="text/javascript"></script>

	</head>

	<body>
	
 	       <?php
	
	          	$conn = mysql_connect('localhost', 'root', 'sawinrocks')
					or die ("connection failed." . mysql_error());
			mysql_select_db('db1', $conn)
				or die ("could not open connection" . mysql_error());

			$myQuery = "INSERT INTO Customer (username, password)";
			$myQuery .= " VALUES ('" . $_POST["username"] . "', '" . $_POST["password"] . "')";
			
			mysql_query($myQuery, $conn)
				or die("This username is already taken. Please <a href=register_form.php>register</a> with a new username.");

			mysql_close($conn);


	          	$conn = mysql_connect('localhost', 'root', 'sawinrocks')
					or die ("connection failed." . mysql_error());
			mysql_select_db('db2', $conn)
				or die ("could not open connection" . mysql_error());

			$myQuery = "INSERT INTO Customer (username, firstname, lastname, email)";
			$myQuery .= " VALUES ('" . $_POST["username"] . "', '" . $_POST["firstname"] . "', '" . $_POST["lastname"] . "', '" . $_POST["email"] . "')";
//also birthday and gender...

			mysql_query($myQuery, $conn)
				or die("This username is already taken. Please <a href=register_form.php>register</a> with a new username.");

			mysql_close($conn);

			echo 'Thank you for registering!<br /><a href=login_form.php>Log in</a>';

        	?>

	</body>

</html>
