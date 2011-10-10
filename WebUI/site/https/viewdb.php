<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


	<head>
		<link href="css/classic.css" rel="stylesheet" type="text/css" />
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />

		<title>virPONG</title>

	</head>


	<body>

		<?php

			$conn = mysql_connect('localhost', 'root', 'sawinrocks')
				or die ("Could not connect to server." . mysql_error());
			mysql_select_db('db1', $conn)
				or die ("Could not open database 1." . mysql_error());

			$records = mysql_query("SELECT * FROM Customer", $conn)
				or die ("Could not retriever customer information." . mysql_error());
			$numCols = mysql_num_fields($records);

			echo '<h1>db1: Customer table</h1>';
			echo '<table border=1><tr>';
			for($i=0; $i<$numCols; $i++)
			{
				echo '<th>' . mysql_field_name($records,$i) . '</th>';
			}
			echo '</tr>';
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

			mysql_select_db('db2', $conn)
				or die ("Could not open database 2." . mysql_error());

			$records = mysql_query("SELECT * FROM Customer", $conn)
				or die ("Could not retriever customer information." . mysql_error());
			$numCols = mysql_num_fields($records);

			echo '<h1>db2: Customer table</h1>';
			echo '<table border=1><tr>';
			for($i=0; $i<$numCols; $i++)
			{
				echo '<th>' . mysql_field_name($records,$i) . '</th>';
			}
			echo '</tr>';
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

			$records = mysql_query("SELECT * FROM gamesPlayed", $conn)
				or die ("Could not retriever customer information." . mysql_error());
			$numCols = mysql_num_fields($records);

			echo '<h1>db2: gamesPlayed table</h1>';
			echo '<table border=1><tr>';
			for($i=0; $i<$numCols; $i++)
			{
				echo '<th>' . mysql_field_name($records,$i) . '</th>';
			}
			echo '</tr>';
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

			mysql_close($conn);

		?>

	</body>


</html>