<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller, Aryn Grause
 *  DATE:	12/10/2011
 *
 *  rules.php explains the rules of VirPong gameplay. It is currently a fairly
 *  useless page, but that shoold change in the near future.
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


<h1>&#9612; rules &#9616;</h1>

<p>
<h2>General:</h2>
<ol>
	<li>These rules are designed to ensure fairness when playing and minimize disputes.</li>
	<li>These rules will be applied to every VirPong sanctioned game.</li>
</ol>
<h2>Playing the Game:</h2>
<ol>
	<li>Slide your paddle up and down to redirect the ball towards your opponents side. There are two methods to moving a paddle: up and down buttons or with a Wii Remote (mobile devices only).</li>
</ol>
<h2>Scoring:</h2>
<ol>
	<li>Games are played to 5 points.</li>
	<li>A goal occurs when a player gets the ball past their opponents paddle.</li>
</ol>
</p>


<?php
	include_once('footer.php');
?>