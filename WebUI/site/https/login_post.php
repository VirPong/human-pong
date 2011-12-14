<?php
	session_start();
	include_once('header.php');
?>


<h1>&#9612; log in &#9616;</h1>

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

	// if it's not set, print an error message
	else
	{
		header('Location:login_form.php?login=false');
	}

	mysql_close($conn);
?>


<?php
	include_once('footer.php');
?>