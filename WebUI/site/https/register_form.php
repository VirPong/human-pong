<?php
	session_start();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	
	<head>


		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
		
		<title>virPONG: register</title>
		
		<script src="register.js" type="text/javascript"></script>

	</head>


	<body>

		<form name="newuser" id="newuser" method="post" action="register_process.php">
			Username <input type="text" size="20" name="username" /><br />
			Password <input type="password" size="20" name="password" /><br />
			First name <input type="text" size="30" name="firstname" /><br />
			Last name <input type="text" size="50" name="lastname" /><br />
			E-mail address <input type="text" size="50" name="email" /><br />
<!--also: birthday-->
			Gender <input type="radio" name="gender" value="female">Female <input type="radio" name="gender" value="male">Male
			<br />
			<input type="submit" name="submitbutton" value="Submit" onclick="return validate();" /> <input type="reset" />
		</form>

	</body>

</html>
