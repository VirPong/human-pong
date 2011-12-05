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

	$stylesheet = $pathToSkins . '/stylesheet.css';
	$menu = $pathToSkins . '/menu.css';
	$logo = $pathToSkins . '/logo.png';
	$valxhtml = $pathToSkins . '/val-xhtml.png';
	$valcss = $pathToSkins . '/val-css.png';

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


	<head>

		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

		<title>virPONG - Pong played by humans</title>

		<link href=<?php echo $stylesheet; ?> rel="stylesheet" type="text/css" />
		<link href=<?php echo $menu; ?> rel="stylesheet" type="text/css" />
		<link rel="icon" href="favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

	</head>


	<body>

		<noscript>
			<div id="jsoff-outer"><div id="jsoff-inner" class="errormsg">
				<strong>this is a friendly yet stern message indicating that we need y'all to<br />TURN ON JAVASCRIPT if you want to use our website!<br />(in the future it will be more professional & polite...)</strong>
			</div></div>
			<style type="text/css">
				//i can use css in this noscript but... this is not exactly working
				#menuminwidth0 {
					display: none;
				}
			</style>
			<?php
				$js = false;
				//can use this var in the future to decide whether or not to display menus
				//OH OH OR... whether to display any content at all on certain pages, y/y?
			?>
		</noscript>
	
		<div>
		<!-- ########################## GRC Masthead Menu ########################## -->
			<div class="menuminwidth0"><div class="menuminwidth1"><div class="menuminwidth2">
			<div id="masthead">
				<a href="http://cs340/index.php"><img id="mastheadlogo" src=<?php echo $logo; ?> width="213" height="161" alt="Vir-Pong: Human Pong!" title="Vir-Pong!" /></a>
			</div>
			<div class="menu">

				<ul>
					<li>&bull;&nbsp;&nbsp;&nbsp; </li>
				</ul>
				
				<ul>
					<li><a>game</a> &nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;
						<ul>
							<li><nobr><a href="http://cs340/rules.php">rules</a></nobr></li>
							<li><nobr><a href="http://cs340/systemrequirements.php">system requirements</a></nobr></li>
						</ul>
					</li>
				</ul>
				
				<ul>
					<li><a>play</a> &nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;
						<ul>
							<li><nobr><a>downloads</a></nobr></li>
							<li><nobr><a href="http://cs340/gamePlay.html">play online</a></nobr></li>
						</ul>
					</li>
				</ul>
				
				<ul>
					<li><a>watch</a> &nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;
						<ul>
							<li><nobr><a href="http://cs340/watchPong.html">live streaming</a></nobr></li>
							<li><nobr><a>past matches</a></nobr></li>
						</ul>
					</li>
				</ul>
				
				<ul>
					<li><a>records</a> &nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;
						<ul>
							<li><nobr><a>high scores</a></nobr></li>
							<li><nobr><a>top players</a></nobr></li>
							<li><nobr><a>your history</a></nobr></li>
						</ul>
					</li>
				</ul>
				
				<ul>
					<li><a>themes</a> &nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;
						<ul>
							<li><nobr><a href="http://cs340/setskin.php">select theme</a></nobr></li>
						</ul>
					</li>
				</ul>

<?php

	if(isset($_SESSION['username']))
	{
		echo '<ul>';
			echo '<li><a>account</a> &nbsp;&nbsp;&nbsp;&bull;';
				echo '<ul>';
					echo '<li><nobr><a href="https://cs340/accountsettings_form.php">account settings</a></nobr></li>';
					echo '<li><nobr><a href="https://cs340/logout_post.php">log out</a></nobr></li>';
				echo '</ul>';
			echo '</li>';
		echo '</ul>';
	}
	else
	{
		echo '<ul>';
			echo '<li><a>account</a> &nbsp;&nbsp;&nbsp;&bull;';
				echo '<ul>';
					echo '<li><nobr><a href="https://cs340/register_form.php">register</a></nobr></li>';
					echo '<li><nobr><a href="https://cs340/login_form.php">log in</a></nobr></li>';
				echo '</ul>';
			echo '</li>';
		echo '</ul>';
	}

?>
				
			</div>
			<hr style="display:none" />
			</div></div></div>

		<!-- ###################### END OF GRC MASTHEAD MENU  ###################### -->
		</div>
		
		
		<!-- the content divs hold our site content; there are two of them for reasons of positioning & margins -->
		<div id="content-outer">
			<div id="content-inner">
