<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller, Garrett Dieckmann, Aryn Grause
 *  DATE:	12/13/2011
 *
 *  register_post.php processes the information received from register_form.php. On
 *  connecting to the database, it creates a new record with all the information. If
 *  the user did not enter a unique username, it displays a message asking him to
 *  re-register. If the username is unique and the database is successfully updated,
 *  the user is automatically logged in to his new account.
 *
 *  INCLUDES:	header.php
 *		footer.php
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
?>


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
		or die('<p><span class="errormsg">This username is already taken. 
			Please <a href=register_form.php>register</a> with a new 
			username.</span></p>');

	// close the connection
	mysql_close($conn);

	// set a session cookie and direct the user to the login page
	$_SESSION['username'] = $_POST['username'];
	header('Location:login_form.php?reg=true');

?>


<?php
	include_once('footer.php');
?>