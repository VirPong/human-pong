<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller, Garrett Dieckmann
 *  DATE:	12/12/2011
 *
 *  watchpong.php 
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


<script src="pong.js" type="text/javascript" charset="utf-8"></script>
<script src="http://cs340:3000/socket.io/socket.io.js"></script>
<noscript>
	<meta HTTP-EQUIV="REFRESH" content="0; url=skins/javascript.php">
</noscript>


<h1>&#9612; live VirPong streaming &#9612;</h1>

<!--<body onLoad="promptLogin();initClient();"> -->
<body onLoad="initClient();">
	<p>
		<center>
    			<canvas id="gameCanvas" height="100" width="100">
    			</canvas>
		</center>
    		<!--<a href="#" onClick="changePaddlePosition('W');">Up</a>
    		<a href="#" onClick="changePaddlePosition('S');">Down</a> -->
	</p>
</body>

<?php
	include_once('footer.php');
?>