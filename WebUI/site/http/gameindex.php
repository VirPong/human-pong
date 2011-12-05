<?php
	session_start();
	include_once('header.php');
?>


<script type="text/javascript" src="pong.js"></script>
<script src="http://cs340:3000/socket.io/socket.io.js"></script>


<h1> &#9612; VirPong gameplay &#9612; </h1>

<body onLoad="promptLogin();">
	<p>
		<center>
			<!-- Pong dimensions = 137 by 76. *4 for the Website -->
			<canvas id="gameCanvas" width="548" height="304">
			</canvas>
		</center>

		<a href="#" onClick="movePaddle2('W');">Up</a>
		<a href="#" onClick="movePaddle2('S');">Down</a>
	</p>
</body>


<?php
	include_once('footer.php');
?>
