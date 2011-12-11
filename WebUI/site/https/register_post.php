<?php
	session_start();
	include_once('header.php');
?>


<h1>&#9612; register &#9616;</h1>

<?php

	// connect to the server and open db2
	$conn = mysql_connect('localhost', 'root', 'sawinrocks')
		or die (header('Location:skins/error.php'));
	mysql_select_db('db2', $conn)
		or die (header('Location:skins/error.php'));

	// insert the account information into the Customer table
	$myQuery = "INSERT INTO Customer (username, password, pin, firstname, 
		lastname, email, birthday, gender)"
		 . " VALUES ('" . $_POST['username'] . "', '" . $_POST['password']
		 . "', '" . $_POST['pin'] . "', '" . $_POST['firstname']
		 . "', '" . $_POST['lastname'] . "', '" . $_POST['email']
		 . "', '" . $_POST['year'] . "-" . $_POST['month'] . "-"
		 . $_POST['day'] . "', '" . $_POST['gender'] . "')";
	mysql_query($myQuery, $conn)
		or die("This username is already taken. Please <a href=
			register_form.php>register</a> with a new username.</p>");

	// set a session cookie and direct the user to the login page
	$_SESSION['username'] = $_POST['username'];
	header('Location:login_form.php?reg=true');

	// close the connection
	mysql_close($conn);

	// print a success message
	echo '<p>Thank you for registering!</p>';

?>


<?php
	include_once('footer.php');
?>