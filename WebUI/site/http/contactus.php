<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller, Aryn Grause
 *  DATE:	12/10/2011
 *
 *  contactus.php provides the user with means for contacting VirPong, including the
 *  address of the UPS CS department and a "real" phone number.
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


<h1>&#9612; contact us &#9616;</h1>

<p>
<h3>You can contact us at:</h3>
Computer Science Department<br/>
University of Puget Sound<br/>
1500 N Warner<br/>
Tacoma, WA 98416<br/>

<h3>Or if you have any immediate issues you can call our service number 24/7:</h3>
555-555-5555 (Because this is a real number!)</p>


<?php
	include('footer.php');
?>