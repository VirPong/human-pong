<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller
 *  DATE:	12/12/2011
 *
 *  login_post.php processes the information received from login_form.php. On
 *  connecting to the database, it checks the record for the given username. If the
 *  recorded password and the entered password match, it sets a session cookie with
 *  the username, thereby logging the user in. The user is then sent back to
 *  login_form.php. If the passwords do not match, the user is sent back to
 *  login_form.php with a variable in the query string that will cause an error
 *  message to be displayed to the user.
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

<?php
	// connect to the server and open db2
	$conn = mysql_connect('localhost', 'root', 'sawinrocks')
		or die (header('Location:skins/error.php'));
	mysql_select_db('db2', $conn)
		or die (header('Location:skins/error.php'));

	// select the row associated with the given username
	$getUser = "SELECT username, password FROM Customer WHERE username='"
		 . $_POST['username'] . "';";
	$user = mysql_query($getUser, $conn)
		or die (header('Location:skins/error.php'));
	$cust = mysql_fetch_row($user);

	// if the passwords match, set a session cookie
	if ($_POST['password']==$cust[1])
	{
		$_SESSION['username'] = $cust[0];
	}

	// close the connection
	mysql_close($conn);

	// if the session cookie is set, send them back to the login page
	if (isset($_SESSION['username']))
	{
		header('Location:login_form.php');
	}

	// if it's not set, send them back to the login page with an error
	else
	{
		header('Location:login_form.php?login=false');
	}

	mysql_close($conn);
?>


<?php
	include_once('footer.php');
?>