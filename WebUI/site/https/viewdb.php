<?php
	session_start();
	include_once('header.php');
?>


<h1>&#9612; database information &#9616;</h1>


<!--
	The viewdb page traverses both our databases and prints all their content.
	Obviously, this is not information that we ultimately want to make public.
	For now, it is extremely useful for purposes of testing our forms / MYSQL.
	Because these accounts are so readily displayed, they all use fake info...
-->


<?php
	// connect to the server and open db2
	$conn = mysql_connect('localhost', 'root', 'sawinrocks')
		or die ("Could not connect to server." . mysql_error());
	mysql_select_db('db2', $conn)
		or die ("Could not open database 2." . mysql_error());

	// pull out all information from the Customer table
	$records = mysql_query("SELECT * FROM Customer", $conn)
		or die ('Could not retrieve customer information.' . mysql_error());
	$numCols = mysql_num_fields($records);

	// print a heading for the Customer table
	echo '<h2>db2: Customer table</h2>';
	echo '<table border=1><tr>';

	// print column headings for the Customer table
	for($i=0; $i<$numCols; $i++)
	{
		echo '<th>' . mysql_field_name($records,$i) . '</th>';
	}
	echo '</tr>';

	// print the contents of the Customer table
	while ($theRecord = mysql_fetch_row($records))
	{
		echo '<tr>';
		for ($i=0; $i<count($theRecord); $i++)
		{
			echo '<td>' . $theRecord[$i] . '</td>';
		}
		echo '</tr>';
	}
	echo '</table>';

	// pull out all information from the gamesPlayed table
	$records = mysql_query("SELECT * FROM gamesPlayed", $conn)
		or die ('Could not retrieve customer information.' . mysql_error());
	$numCols = mysql_num_fields($records);

	// print a heading for the gamesPlayed table
	echo '<h2>db2: gamesPlayed table</h2>';
	echo '<table border=1><tr>';

	// print column headings for the gamesPlayed table
	for($i=0; $i<$numCols; $i++)
	{
		echo '<th>' . mysql_field_name($records,$i) . '</th>';
	}
	echo '</tr>';

	// print the contents of the gamesPlayed table
	while ($theRecord = mysql_fetch_row($records))
	{
		echo '<tr>';
		for ($i=0; $i<count($theRecord); $i++)
		{
			echo '<td>' . $theRecord[$i] . '</td>';
		}
		echo '</tr>';
	}
	echo '</table>';

	// close the connection
	mysql_close($conn);

?>


<?php
	include_once($footer);
?>