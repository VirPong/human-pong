<?php
	session_start();
	include_once('header.php');
?>

<script src="pong.js" type="text/javascript" charset="utf-8"></script>
<script src="http://cs340:3000/socket.io/socket.io.js"></script>

<style type="text/css">
	canvas {
		border: 4px solid #A0A0A0;
		background: black;
		display: block;
	}
</style>

<h1>&#9612; live Vir-Pong streaming &#9612;</h1>

<!--<body onLoad="promptLogin();initClient();"> -->
<body onLoad="initClient();">
	<center>
    <canvas id="gameCanvas" height="100" width="100">
    </canvas>
	</center>
    <!--<a href="#" onClick="changePaddlePosition('W');">Up</a>
    <a href="#" onClick="changePaddlePosition('S');">Down</a> -->
</body>

<?php
	include_once($footer);
?>