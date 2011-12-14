<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller, Aryn Grause
 *  DATE:	12/10/2011
 *
 *  systemrequirements.php lists what is required in order to successfully play a
 *  game of VirPong. It is currently a rather sparse page, but that should change in
 *  the near future.
 *
 *  INCLUDES:	header.php
 *		footer.php
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
?>


<?php
	session_start();
	include_once('header.php');
?>


<h1>&#9612; system requirements &#9616;</h1>

<p>
There are two ways to participate in a VirPong game. You can play online via the website or on your Android or IOS mobile device. Both mobile devices can be played with or without the assistance of a Wii Remote to move the paddles. Learn more about the restrictions for each method of play below:
</p>

<br /><p>
<h2>VirPong Website:</h2>
The browser must be able to run HTML5 Canvas (i.e. Google Chrome, Mozilla Firefox, or Apple Safari)
</p>

<br /><p>
<h2>Android Mobile Devices:</h2>
The mobile device must be BlueTooth Enabled so then BluezIME can work. Most Android devices should work, HTC Android devices will probably not work.
</p>

<br /><p>
<h2>IOS Mobile Devices:</h2>
The device must be jailbroken.
</p>

<br /><br /><p>
<i>If you would like to play without registering for an account then you can play under the username </i>guest<i> with the pin </i>1111<i>.</i>
</p>


<?php
	include_once('footer.php');
?>