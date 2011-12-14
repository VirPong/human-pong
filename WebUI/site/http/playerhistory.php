<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 *  AUTHORS:	Katie Mueller, Garrett Dieckmann
 *  DATE:	12/10/2011
 *
 *  playerhistory.php allows users to look up specific players and view information
 *  about their past matches. If it receives no "user" variable in the query string,
 *  it displays a form prompting the user for a username. Upon submission this form
 *  returns to playerhistory.php, passing the username input in as the "user"
 *  variable.
 *
 *  When playerhistory.php receives a "user" variable in the query string, it
 *  connects to the database and escapes the string representing the "user" variable
 *  as a precaution against SQL injection. It then traverses the database for matches
 *  involving this user, displaying the results in a table. If it finds no results,
 *  it displays a message saying that the user either does not exist or has not
 *  played any matches. In any case, it prompts the user to look up another username.
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


<script type="text/javascript" src="playerhistory.js"></script>
<noscript>
	<meta HTTP-EQUIV="REFRESH" content="0; url=skins/javascript.php">
</noscript>


<h1>&#9612; player history &#9616;</h1>

<?php

	$user = @$_GET['user'];

	if ($user==null)
	{
		echo 'Enter a username to view player history.';

		echo '<p><form name="viewhist" class="inputarea" id="viewhist" 
			method="get" action="playerhistory.php">';
		echo '<label for="user">Username</label>';
		echo '<input type="text" name="user" /><br />';
		echo '<label for="submit">&nbsp;</label>';
		echo '<input type="submit" value="View history" />';
		echo '</form></p>';
	}
	else
	{

		// connect to the server and open db2
		$conn = mysql_connect('localhost', 'root', 'sawinrocks')
			or die (header('Location:skins/error.php'));
		mysql_select_db('db2', $conn)
			or die (header('Location:skins/error.php'));

		$user = mysql_real_escape_string($user);

		// pull out the relevant information
		$myQuery = "SELECT * FROM GamesPlayed WHERE username1 = '" . $user . "' or username2 = '" . $user . "';";
		$winners = mysql_query($myQuery, $conn)
			//or die (header('Location:skins/error.php'));
			or die($myQuery);

		$validUser = false;
		echo '<p><center><h3>' . $user . '</h3><table>';
		//echo '<tr><th>Player 1</th><th>Player 2</th><th>Score 1</th><th>Score 2</th></tr>';
		echo '<tr><th>Outcome</th><th>Score</th><th>Opponent</th></tr>';
		while ($winner = mysql_fetch_row($winners))
		{
			$validUser = true;
			echo '<tr>';

			if ($winner[1]==$user)
			{
				if ($winner[5]==$user)
				{
					echo '<td align=center>win</td>';
					echo '<td align=center>' . $winner[3] . '&ndash;' . $winner[4] . '</td>';
					echo '<td>' . $winner[2] . '</td>';
				}
				else
				{
					echo '<td align=center>loss</td>';
					echo '<td align=center>' . $winner[3] . '&ndash;' . $winner[4] . '</td>';
					echo '<td>' . $winner[2] . '</td>';
				}
			}
			else if ($winner[2]==$user)
			{
				if ($winner[5]==$user)
				{
					echo '<td align=center>win</td>';
					echo '<td align=center>' . $winner[4] . '&ndash;' . $winner[3] . '</td>';
					echo '<td>' . $winner[1] . '</td>';
				}
				else
				{
					echo '<td align=center>loss</td>';
					echo '<td align=center>' . $winner[4] . '&ndash;' . $winner[3] . '</td>';
					echo '<td>' . $winner[1] . '</td>';
				}
			}

			echo '</tr>';
		}

		if ($validUser==false)
		{
			echo '<tr><td colspan=3>The user you have requested does not exist or has not played any matches.</td></tr>';
		}

		echo '</table></center></p>';

		echo '<p>Would you like to <a href=playerhistory.php>look up</a> another user?<p>';

		mysql_close($conn);

	}

?>


<?php
	include_once('footer.php');
?>