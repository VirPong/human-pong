<?php
	session_start();

	if (	isset($_GET['skin'])
		&& is_numeric($_GET['skin'])
		&& is_dir(getcwd() . '/skins/' . $_GET['skin'])
	)
	{
		setcookie('myskin', $_GET['skin'], time()+(31*86400));
		header('Location: setskin.php');
	}

	include_once('header.php');

?>

<h1>&#9612; choose your theme &#9616;</h1>

<p><a href="setskin.php?skin=1" style="text-decoration:none">
<img src="skins/1/logo.png" width=106px height=80px style="vertical-align:middle" />
<span style="color:#7788CC">VirPong Classic</span>
</a></p>

<p><a href="setskin.php?skin=2" style="text-decoration:none">
<img src="skins/2/logo.png" width=106px height=80px style="vertical-align:middle" />
<span style="color:#AAAAAA">Logger Pride</span>
</a></p>

<p><a href="setskin.php?skin=3" style="text-decoration:none">
<img src="skins/3/logo.png" width=106px height=80px style="vertical-align:middle" />
<span style="color:#BCBCBC">Panda</span>
</a></p>

<p><a href="setskin.php?skin=4" style="text-decoration:none">
<img src="skins/4/logo.png" width=106px height=80px style="vertical-align:middle" />
<span style="color:#88DD88">Watermelon</span>
</a></p>


<?php
	include_once('footer.php');
?>