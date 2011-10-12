		<div id="logo">
			<img src="../skins/1/images/logo.png" alt="virPONG" />
		</div>

		<div id="nav">
			&bull;&nbsp; <a id="gameplay">gameplay</a> &nbsp;&bull;&nbsp; <a id="watch">watch</a> &nbsp;&bull;&nbsp; <a id="events">events</a> &nbsp;&bull;&nbsp; <a id="records">records</a> &nbsp;&bull;&nbsp; <a id="chat">chat</a> &nbsp;&bull;&nbsp; <a id="account">account</a> &nbsp;&bull;
		</div>

		<div id="gameplay_menu">
			&#9612; <a>rules</a> &nbsp;<br />
			&#9612; <a>system requirements</a> &nbsp;<br />
			&#9612; <a>downloads</a> &nbsp;<br />
			&#9612; <a>play online</a> &nbsp;
		</div>

		<div id="watch_menu">
			&#9612; <a>live streaming</a> &nbsp;<br />
			&#9612; <a>past matches</a> &nbsp;
		</div>

		<div id="events_menu">
			&#9612; <a>tournaments</a> &nbsp;<br />
			&#9612; <a>news</a> &nbsp;
		</div>

		<div id="records_menu">
			&#9612; <a>high scores</a> &nbsp;<br />
			&#9612; <a>top players</a> &nbsp;<br />
			&#9612; <a>your history</a> &nbsp;
		</div>

		<div id="chat_menu">
			&#9612; <a>your inbox</a> &nbsp;<br />
			&#9612; <a>forum</a> &nbsp;
		</div>


		<?php
			if (isset($_SESSION['username']))
			{
				echo '<div id="account_menu">';
					echo '&#9612; <a>settings</a> &nbsp;<br />';
					echo '&#9612; <a>log out</a> &nbsp;';
				echo '</div>';
			}
			else
			{
				echo '<div id="account_menu">';
					echo '&#9612; <a>register</a> &nbsp;<br />';
					echo '&#9612; <a>log in</a> &nbsp;';
				echo '</div>';
			}
		?>

		<script type ="text/javascript">
			at_attach("gameplay", "gameplay_menu", "hover", "y");
			at_attach("watch", "watch_menu", "hover", "y");
			at_attach("events", "events_menu", "hover", "y");
			at_attach("records", "records_menu", "hover", "y");
			at_attach("chat", "chat_menu", "hover", "y");
			at_attach("account", "account_menu", "hover", "y");
		</script>

		<div id="module">
			
		</div>

		<div id="content-outer">
			<div id="content-inner">