<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller
 *  DATE:	12/10/2011
 *
 *  footer.php is included on every page of the VirPong website. It closes the divs
 *  that hold the main content and displays the footer div, which contains the
 *  validation images and bottom navigation links.
 *
 *  Note that the use of relative URLs requires that footer.php be present in every
 *  directory that contains files that implement the VirPong layout. We have set up
 *  symlinks in order to make this maintainable.
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
?>


			</div>
		</div>


		<!-- the footer div contains the validation images and bottom navigation links -->

		<div id="footer">
			<img src=<?php echo $valxhtml; ?> alt="Valid XHTML 1.1" border="0" /> 
			<img src=<?php echo $valcss; ?> alt="Valid CSS" border="0" /><br />
			&bull;&nbsp; <a href="http://cs340/aboutus.php">about us</a> &nbsp;
			&bull;&nbsp; <a href="http://cs340/contactus.php">contact us</a> &nbsp;
			&bull;&nbsp; <a href="http://cs340/privacypolicy.php">privacy policy</a> &nbsp;
			&bull;&nbsp; <a href="http://cs340/termsofuse.php">terms of use</a> &nbsp;
			&bull;&nbsp; <a href="http://cs340/codeofconduct.php">code of conduct</a> &nbsp;
			&bull;
		</div>

	</body>

</html>