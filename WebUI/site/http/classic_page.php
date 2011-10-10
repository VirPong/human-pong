<?php
	session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


	<head>

		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

		<title>virPONG</title>

		<link href="css/classic.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="dropdown.js"></script>

	</head>


	<body>

		<div id="nav">
			&bull;&nbsp; <a id="gameplay">gameplay</a> &nbsp;&bull;&nbsp; <a id="watch">watch</a> &nbsp;&bull;&nbsp; <a id="events">events</a> &nbsp;&bull;&nbsp; <a id="records">records</a> &nbsp;&bull;&nbsp; <a id="chat">chat</a> &nbsp;&bull;&nbsp; <a id="account">account</a> &nbsp;&bull;
		</div>

		<div id="gameplay_menu">
			<a>rules</a><br />
			<a>system requirements</a><br />
			<a>downloads</a><br />
			<a>play online</a>
		</div>

		<div id="watch_menu">
			<a>live streaming</a><br />
			<a>past matches</a>
		</div>

		<div id="events_menu">
			<a>tournaments</a><br />
			<a>news</a>
		</div>

		<div id="records_menu">
			<a>high scores</a><br />
			<a>top players</a><br />
			<a>your history</a>
		</div>

		<div id="chat_menu">
			<a>your inbox</a><br />
			<a>forum</a>
		</div>

		<div id="account_menu">
			<a>settings</a><br />
			<a>log out</a>
		</div>

		<script type ="text/javascript">
			at_attach("gameplay", "gameplay_menu", "hover", "y", "cursor");
			at_attach("watch", "watch_menu", "hover", "y", "cursor");
			at_attach("events", "events_menu", "hover", "y", "cursor");
			at_attach("records", "records_menu", "hover", "y", "cursor");
			at_attach("chat", "chat_menu", "hover", "y", "cursor");
			at_attach("account", "account_menu", "hover", "y", "cursor");
		</script>

		<div id="content">
			<h1>&#9612; page title &#9616;</h1>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut libero orci, sed mollis quam.
Pellentesque malesuada eros at massa gravida bibendum. Cras condimentum facilisis nunc sed
vehicula. Fusce non diam ut ante ornare sollicitudin et et purus. Proin sit amet nisi ac eros
feugiat ornare in vel libero. In molestie luctus est nec pharetra. Aenean rhoncus tellus vitae diam
laoreet ultrices suscipit enim suscipit. Cras vel faucibus lacus. Aliquam in odio tortor. Mauris sem
magna, aliquet vitae vestibulum quis, dignissim in ante. Aenean egestas fermentum dolor vel
iaculis.</p>

			<p>Fusce justo ligula, mollis quis consequat id, euismod et dui. Donec quam urna, porta vel fringilla
sed, porttitor eu dui. Duis nec erat nunc, ac porta libero. Proin sodales sagittis placerat.
Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
Vestibulum adipiscing faucibus blandit. Nam egestas magna eu nulla mollis malesuada. Proin id
nunc justo, id luctus orci. Nullam mattis, orci ac pellentesque rutrum, mauris libero lobortis sem,
nec iaculis ipsum lectus nec sem. Morbi quis nibh erat, vitae commodo nisl. Proin convallis
ultricies facilisis.</p>

			<p>Sed porta sapien ac felis volutpat feugiat. Morbi scelerisque ipsum a magna lobortis varius.
Etiam id ligula nisi. Proin at leo arcu. Cras ut felis mauris. Donec at nunc non arcu tempor cursus.
Aliquam erat volutpat. Sed dignissim tortor nec odio adipiscing ac volutpat nisi ornare. Nam
lorem neque, semper ac lobortis at, rhoncus id risus. Etiam sed odio et ligula pharetra imperdiet.
Praesent imperdiet quam vitae quam ornare luctus. Aliquam erat volutpat.</p>
		</div>

		<div id="footer">
			&bull; <a href=>about us</a> &bull; <a href=>contact us</a> &bull; <a href=>privacy policy</a> &bull;
		</div>

	</body>


</html>