<?php
	session_start();
	include_once('header.php');
?>


<script type="text/javascript" src="pong.js"></script>
<script src="http://10.150.1.204:3000/socket.io/socket.io.js"></script>

<style type = "text/css">
	canvas{
		border: 4px solid #AOAOAO;
		background: black;
		display: block;
	}
</style>

<center>
<h1> &#9612; VirPong GamePlay &#9612; </h1>
<body onLoad="promptLogin();">
    <!-- Pong dimensions = 137 by 76. *4 for the Website -->
    <canvas id="gameCanvas" width="548" height="304">
    </canvas>
    </center>

    <a href="#" onClick="movePaddle2('W');">Up</a>
    <a href="#" onClick="movePaddle2('S');">Down</a>
</body>
<?php
	include_once($footer);
?>
