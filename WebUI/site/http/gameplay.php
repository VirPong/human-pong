<?php
	session_start();
	include_once('header.php');
?>


<script type="text/javascript" src="pong.js"></script>
<script src="http://cs340:3000/socket.io/socket.io.js"></script>


<h1>&#9612; VirPong gameplay &#9616;</h1>

<body onLoad="promptLogin();initClient();">
	<p>
		<center>
    			<canvas id="gameCanvas" height="100" width="100">
    			</canvas>
		</center>

    		<a href="#" onClick="changePaddlePosition('W');">Up</a>
    		<a href="#" onClick="changePaddlePosition('S');">Down</a>
	</p>
</body>


<?php
	include_once('footer.php');
?>