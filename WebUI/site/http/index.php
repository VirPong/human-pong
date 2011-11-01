<?php
	session_start();
	include_once('header.php');
?>



<h1>&#9612; welcome to Vir-Pong! &#9616;</h1>

<p>This is an unencrypted connection to the Vir-Pong site. Check out the <a href="https://cs340-serv/">secure site</a>.</p>

<p>Other links of interest:
	<ul>
		<li><a href=simppong.html>simple demo</a></li>
		<li><a href=osmus/client>Osmus</a></li>
		<li><a href=NodePong>another demo</a></li>
		<li><a href=communication>Socket.io demo</a></li>
		<li><a href=menutest.html>Menu test</a>.</li>
	</ul>
</p>

<?php
	include_once($footer);
?>