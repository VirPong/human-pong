<?php
	session_start();
	include_once('header.php');
?>


<noscript>
	<meta HTTP-EQUIV="REFRESH" content="0; url=index_nojs.php">
</noscript>



<h1>&#9612; welcome to VirPong! &#9616;</h1>

<p>
This is an unencrypted connection to the VirPong site. Check out the <a href="https://cs340/">secure site</a>. Or use the menus above and below to navigate smoothly between secure and non-secure pages.
</p>

<p>
<?php
	include_once('news/index.php');
?>
</p>

<?php
	include_once('footer.php');
?>
