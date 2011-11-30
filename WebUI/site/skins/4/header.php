<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


	<head>

		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

		<title>virPONG - Pong played by humans</title>

		<link href="skins/4/stylesheet.css" rel="stylesheet" type="text/css" />
		<link rel="icon" href="favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

		<script type="text/javascript" src="dropdown.js"></script>

	</head>


	<body>

		<!-- the logo div holds the logo image -->
		<div id="logo">
			<a href=http://cs340><img src="skins/4/logo.png" alt="virPONG" /></a>
		</div>

		<!-- the nav div holds the top navigation bar -->
		<div id="nav">
			&bull;&nbsp; <a id="gameplay">gameplay</a> &nbsp;&bull;&nbsp; <a id="watch">watch</a> &nbsp;&bull;&nbsp; <a id="events">events</a> &nbsp;&bull;&nbsp; <a id="records">records</a> &nbsp;&bull;&nbsp; <a id="chat">chat</a> &nbsp;&bull;&nbsp; <a id="account">account</a> &nbsp;&bull;
		</div>

		<!-- the *_menu divs are hidden and hold the dropdown menu contents -->

		<div id="gameplay_menu">
			&#9612; <a href="http://cs340/rules.php">rules</a> &nbsp;<br />
			&#9612; <a href="http://cs340/systemrequirements.php">system requirements</a> &nbsp;<br />
			&#9612; <a>downloads</a> &nbsp;<br />
			&#9612; <a href="http://cs340/gamePlay.html"> play online</a> &nbsp;
		</div>

		<div id="watch_menu">
			&#9612; <a href="http://cs340/watchPong.html">Watch Live</a> &nbsp;<br />
			&#9612; <a>past matches</a> &nbsp;
		</div>

		<div id="events_menu">
			&#9612; <a>tournaments</a> &nbsp;<br />
			&#9612; <a>news</a> &nbsp;
		</div>

		<div id="records_menu">
			&#9612; <a>high scores</a> &nbsp;<br />
			&#9612; <a>top players</a> &nbsp;<br />
			&#9612; <a>your history</a> &nbsp;
		</div>

		<div id="chat_menu">
			&#9612; <a>your inbox</a> &nbsp;<br />
			&#9612; <a>forum</a> &nbsp;
		</div>

		<div id="account_menu">
			<?php
				// the account menu changes its contents based on whether or not the user is logged in
				if (isset($_SESSION['username']))
				{
					echo '&#9612; <a href="https://cs340/accountsettings.php">settings</a> &nbsp;<br />';
					echo '&#9612; <a href="https://cs340/logout_post.php">log out</a> &nbsp;';
				}
				else
				{
					echo '&#9612; <a href="https://cs340/register_form.php">register</a> &nbsp;<br />';
					echo '&#9612; <a href="https://cs340/login_form.php">log in</a> &nbsp;';
				}
			?>
		</div>

		<!-- this script matches each dropdown menu with its parent -->
		<script type ="text/javascript">
			at_attach("gameplay", "gameplay_menu", "hover", "y");
			at_attach("watch", "watch_menu", "hover", "y");
			at_attach("events", "events_menu", "hover", "y");
			at_attach("records", "records_menu", "hover", "y");
			at_attach("chat", "chat_menu", "hover", "y");
			at_attach("account", "account_menu", "hover", "y");
		</script>

		<!-- the content divs hold our site content; there are two of them for reasons of positioning & margins -->
		<div id="content-outer">
			<div id="content-inner">
