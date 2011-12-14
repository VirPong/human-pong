<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller, Kyle Monnett
 *  DATE:	12/12/2011
 *
 *  header.php is included on every page of the VirPong website. It checks the user's
 *  cookies for a set skin and displays the layout accordingly. If the user has
 *  JavaScript disabled, it displays a warning message. It displays the navigation
 *  div (including the VirPong logo and main menu) and opens the main content div.
 *
 *  Note that the use of relative URLs requires that header.php be present in every
 *  directory that contains files that implement the VirPong layout. We have set up
 *  symlinks in order to make this maintainable.
 *
 *  USES:	main.css
 *		/skins/*
 *		favicon.ico
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
?>


<?php

	$pathToSkins = '/skins/';
	$defaultSkin = 1;

	if (isset($_COOKIE['myskin']))
	{
		$pathToSkins .= $_COOKIE['myskin'];
	}
	else
	{
		$pathToSkins .= $defaultSkin;
	}

	$colors = $pathToSkins . '/colors.css';
	$logo = $pathToSkins . '/logo.png';
	$valxhtml = $pathToSkins . '/val-xhtml.png';
	$valcss = $pathToSkins . '/val-css.png';

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


	<head>

		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

		<title>VirPong: Pong. With humans.</title>

		<link href="/main.css" rel="stylesheet" type="text/css" />
		<link href=<?php echo $colors; ?> rel="stylesheet" type="text/css" />
		<link rel="icon" href="favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

	</head>


	<body>

		<noscript>
			<div id="jsoff-outer"><div id="jsoff-inner" class="errormsg">
				<strong>Your browser currently has JavaScript disabled. Some features of our website will be unavailable. Please enable JavaScript for the full VirPong experience.</strong>
			</div></div>
		</noscript>
	
		<div id="nav">

			<div id="logo">
				<a href="http://cs340.pugetsound.edu/index.php"><img src=<?php echo $logo; ?> width="213" height="161" alt="VirPong: Pong. With humans." /></a>
			</div>

			<div class="menu">

				<ul>
					<li>&bull;&nbsp;&nbsp;&nbsp; </li>
				</ul>
				
				<ul>
					<li><a>game</a> &nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;
						<ul>
							<li><nobr><a href="http://cs340.pugetsound.edu/rules.php">rules</a></nobr></li>
							<li><nobr><a href="http://cs340.pugetsound.edu/systemrequirements.php">system requirements</a></nobr></li>
						</ul>
					</li>
				</ul>
				
				<ul>
					<li><a>play</a> &nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;
						<ul>
							<li><nobr><a href="http://cs340.pugetsound.edu/downloads.php">downloads</a></nobr></li>
							<li><nobr><a href="http://cs340.pugetsound.edu/gameplay.php">play online</a></nobr></li>
						</ul>
					</li>
				</ul>
				
				<ul>
					<li><a>watch</a> &nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;
						<ul>
							<li><nobr><a href="http://cs340.pugetsound.edu/watchpong.php">live streaming</a></nobr></li>
						</ul>
					</li>
				</ul>
				
				<ul>
					<li><a>records</a> &nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;
						<ul>
							<li><nobr><a href="http://cs340.pugetsound.edu/topplayers.php">top players</a></nobr></li>
							<li><nobr><a href="http://cs340.pugetsound.edu/playerhistory.php">player history</a></nobr></li>
						</ul>
					</li>
				</ul>
				
				<ul>
					<li><a>themes</a> &nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;
						<ul>
							<li><nobr><a href="http://cs340.pugetsound.edu/setskin.php">select theme</a></nobr></li>
						</ul>
					</li>
				</ul>

<?php

	if(isset($_SESSION['username']))
	{
		echo '<ul>';
			echo '<li><a>account</a> &nbsp;&nbsp;&nbsp;&bull;';
				echo '<ul>';
					echo '<li><nobr><a href="https://cs340.pugetsound.edu/accountsettings_form.php">account settings</a></nobr></li>';
					echo '<li><nobr><a href="http://cs340.pugetsound.edu/playerhistory.php?user=' . $_SESSION['username'] . '">your history</a></nobr></li>';
					echo '<li><nobr><a href="https://cs340.pugetsound.edu/logout_post.php">log out</a></nobr></li>';
				echo '</ul>';
			echo '</li>';
		echo '</ul>';
	}
	else
	{
		echo '<ul>';
			echo '<li><a>account</a> &nbsp;&nbsp;&nbsp;&bull;';
				echo '<ul>';
					echo '<li><nobr><a href="https://cs340.pugetsound.edu/register_form.php">register</a></nobr></li>';
					echo '<li><nobr><a href="https://cs340.pugetsound.edu/login_form.php">log in</a></nobr></li>';
				echo '</ul>';
			echo '</li>';
		echo '</ul>';
	}

?>
				
			</div>

		</div>
		
		
		<!-- the content divs hold our site content; there are two of them for reasons of positioning & margins -->
		<div id="content-outer">
			<div id="content-inner">
