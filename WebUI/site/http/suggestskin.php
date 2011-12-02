<?php
	session_start();
	include_once('header.php');
?>


<h1>&#9612; suggest a theme &#9616;</h1>

<p>Rules to come!</p>

		<?php
			$strEmail = "indecisivekatie@gmail.com";
			$strSubject = "Suggested theme for VirPong";
			$strMessage = "On behalf of all of us at CReDFrees, we would like to thank you for using our service. Your continued support allows us to keep offering quality resell products. We hope you come back soon!\n\nCReDFreeS\ncredfrees.com\n1500 N Warner\nThompson 399\nTacoma, WA 98416 ";

			$strHeaders = "From: VirPong\r\n";
			$strHeaders .= "Reply-To: kmueller@pugetsound.edu";

			mail($strEmail, $strSubject, $strMessage, $strHeaders);
		?>


<?php
	include_once($footer);
?>