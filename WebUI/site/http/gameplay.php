<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller, Garrett Dieckmann
 *  DATE:	12/12/2011
 *
 *  gameplay.php
 *
 *  The form validation (checking for valid user input as a means of preventing SQL
 *  injection) requires the use of JavaScript. In the case of disabled Javascript
 *  the user is immediately redirected to skins/javascript.php, which asks that the
 *  user enable JavaScript to use this feature.
 *
 *  INCLUDES:	header.php
 *				footer.php
 *
 *  JavaScript: pong.js
 *  			socket.io.js
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
?>


<?php
	session_start();
	include_once('header.php');
?>


<script type="text/javascript" src="pong.js"></script>
<script src="http://cs340:3000/socket.io/socket.io.js"></script>
<noscript>
	<meta HTTP-EQUIV="REFRESH" content="0; url=skins/javascript.php">
</noscript>


<h1>&#9612; VirPong gameplay &#9616;</h1>

<!--Provides the username from the cookie to the performAuthentication method
	in the pong.js file -->
<?php
	if (isset($_SESSION['username']))
	{
		$userid = $_SESSION['username'];
	}
	if ($userid == NULL)
	{
		$userid = "guest";
	}
?>

<!--Using the username from the cookie, query database to provide the password
	to the pong.js file -->
<?php
	// connect to the server and open db2
	$conn = mysql_connect('localhost', 'root', 'sawinrocks')
		or die (header('Location:skins/error.php'));
	mysql_select_db('db2', $conn)
		or die (header('Location:skins/error.php'));

	// select the row associated with the given username from the Session cookie
	$getPass = "SELECT password FROM Customer WHERE username='"
		 . $userid . "';";
	$password = mysql_query($getPass, $conn)
		or die (header('Location:skins/error.php'));
	$cust = mysql_fetch_row($password);
	$returnPass = $cust[0];
	
	if ($returnPass == NULL)
	{
			$returnPass = "1111";
	}
?>




<!--<body onLoad="promptLogin();initClient();">-->
<body onLoad="initCanvas();connectToServer();performAuthentication('<?php echo $userid; ?>', '<?php echo $returnPass; ?>');">
	<body>
	
    		<!--<a href="#" onClick="changePaddlePosition('W');">Up</a>
    		<a href="#" onClick="changePaddlePosition('S');">Down</a>-->
	</p>
	 <div id="view"></div>
</body>


<?php
	include_once('footer.php');
?>