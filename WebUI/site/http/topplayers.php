<?php
	session_start();
	include_once('header.php');
?>


<h1>&#9612; top players &#9616;</h1>

<?php

	// connect to the server and open db2
	$conn = mysql_connect('localhost', 'root', 'sawinrocks')
		or die (header('Location:skins/error.php'));
	mysql_select_db('db2', $conn)
		or die (header('Location:skins/error.php'));

	// pull out the relevant information
	$myQuery = "SELECT win, COUNT(win) FROM GamesPlayed GROUP BY win limit 10;";
	$winners = mysql_query($myQuery, $conn)
		or die (header('Location:skins/error.php'));

	echo '<p><center><table>';
	echo '<tr><th>Username</th><th>Wins</th></tr>';
	while ($winner = mysql_fetch_row($winners))
	{
		echo '<tr>';
		echo '<td><a href="playerhistory?user=' . $winner[0] . '">' . $winner[0] . '</a></td>';
		echo '<td align="right">' . $winner[1] . '</td>';
		echo '</tr>';
	}
	echo '</table></center></p>';

	mysql_close($conn);

?>


<?php
	include_once('footer.php');
?>