<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller, Garrett Dieckmann
 *  DATE:	12/10/2011
 *
 *  topplayers.php displays a table containing the usernames and win counts of the
 *  ten players who have won the most matches of VirPong. The usernames are
 *  hyperlinks pointing to that user's personal history (that is,
 *  personalhistory.php?user=USERNAME, where USERNAME is the username).
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


<h1>&#9612; top players &#9616;</h1>

<h3><center>
	Currently displaying the top 10 players.
</center></h3>

<?php

	// connect to the server and open db2
	$conn = mysql_connect('localhost', 'root', 'sawinrocks')
		or die (header('Location:skins/error.php'));
	mysql_select_db('db2', $conn)
		or die (header('Location:skins/error.php'));

	// pull out the relevant information
	$myQuery = "SELECT win, COUNT(win) FROM GamesPlayed GROUP BY win order by count(win) desc limit 10;";
	$winners = mysql_query($myQuery, $conn)
		or die (header('Location:skins/error.php'));

	echo '<p><center><table>';
	echo '<tr><th>Rank</th><th>Username</th><th>Wins</th></tr>';
	$rank = 1;
	while ($winner = mysql_fetch_row($winners))
	{
		echo '<tr>';
		echo '<td>' . $rank . '</td>';
		echo '<td><a href="playerhistory?user=' . $winner[0] . '">' . $winner[0] . '</a></td>';
		echo '<td align="right">' . $winner[1] . '</td>';
		echo '</tr>';
		$rank++;
	}
	echo '</table></center></p>';

	mysql_close($conn);

?>

<?php
	include_once('footer.php');
?>