<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller, Garrett Dieckmann
 *  DATE:	12/12/2011
 *
 *  downloads.php is a page that allows for downloading software associated with 
 *  VirPong. The page includes links to the Android, the iPhone and the website
 *  files. 
 *
 *  For the Android and iPhone devices, QR codes are provided that link to the
 *  files associated with each device. This was done to make it easier for
 *  mobile devices to download and install VirPong software.
 *
 *  INCLUDES:	header.php
 *				footer.php
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
?>


<?php
	session_start();
	include_once('header.php');
?>


<h1>&#9612; downloads &#9616;</h1>

<h2> For Android Devices: </h2>
<p> Using a Barcode scanner App, you can scan the image below, and it will automatically
	navigate your Android phone to the downloads package. For this installation, make sure
	that your Android device is connected on the PugetSound wireless network. For some Android
	phones, application settings may need to be changed. Make sure to allow your device to install
	applications that are not from the Android Market. This setting can be found under the 'Application
	Settings' menu, under the 'Settings' menu, and labeled as 'Unkown Sources.'
 </p>
<center><img src="/images/android.png"/></center>
<p>
	If your phone does not have a Barcode scanner App, or you want to download the Android package
	to your computer, you can do so by downloading the <a href="http://cs340.pugetsound.edu/downloads/virpong.apk">Android package</a>.
	To enable the Wii Remote functionality on your Android device, you will need to install this
	<a href="http://cs340.pugetsound.edu/downloads/BluezIME.apk">supplementary package</a>.
</p>
<br/><br/>
<p><i>For other packages, as well as more information about VirPong, including documentation,
	please go to the VirPong's <a href="https://github.com/VirPong/human-pong"> GitHub repository</a>.
</i></p>
<br/>


<?php
	include_once('footer.php');
?>