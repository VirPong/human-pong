<?php

	$pathToSkins = getcwd() . '/skins/';
	$defaultSkin = 1;

	if (	isset($_COOKIE['myskin'])
		&& file_exists($pathToSkins . $_COOKIE['myskin'] . '/header.php')
		&& file_exists($pathToSkins . $_COOKIE['myskin'] . '/footer.php')
	)
	{
		$header = $pathToSkins . $_COOKIE['myskin'] . '/header.php';
		$footer = $pathToSkins . $_COOKIE['myskin'] . '/footer.php';
	}

	else
	{
		$header = $pathToSkins . $defaultSkin . '/header.php';
		$footer = $pathToSkins . $defaultSkin . '/footer.php';
	}

	include_once($header);

?>