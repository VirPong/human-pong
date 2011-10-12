<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


	<head>
		<link href="css/classic.css" rel="stylesheet" type="text/css" />
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

		<title>virPONG</title>

	</head>


	<body>

		<!--
			The viewdb page traverses both our databases and prints all their content.
			Obviously, this is not information that we ultimately want to make public.
			For now, it is extremely useful for purposes of testing our forms / MYSQL.
			Because these accounts are so readily displayed, they all use fake info...
		-->

		<?php

			// connect to the server and open db1
			$conn = mysql_connect('localhost', 'root', 'sawinrocks')
				or die ("Could not connect to server." . mysql_error());
			mysql_select_db('db1', $conn)
				or die ("Could not open database 1." . mysql_error());

			// pull out all information from the Customer table
			$records = mysql_query("SELECT * FROM Customer", $conn)
				or die ("Could not retriever customer information." . mysql_error());
			$numCols = mysql_num_fields($records);

			// print a heading for the Customer table
			echo '<h1>db1: Customer table</h1>';
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

			// open db2
			mysql_select_db('db2', $conn)
				or die ("Could not open database 2." . mysql_error());

			// pull out all information from the Customer table
			$records = mysql_query("SELECT * FROM Customer", $conn)
				or die ("Could not retriever customer information." . mysql_error());
			$numCols = mysql_num_fields($records);

			// print a heading for the Customer table
			echo '<h1>db2: Customer table</h1>';
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
				or die ("Could not retriever customer information." . mysql_error());
			$numCols = mysql_num_fields($records);

			// print a heading for the gamesPlayed table
			echo '<h1>db2: gamesPlayed table</h1>';
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

	</body>


</html>