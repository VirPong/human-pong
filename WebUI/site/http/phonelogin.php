   <?php
	
	//Open a connection to the mysql server and database
	$db = new mysqli("localhost", "root", "sawinrocks", "db2");
		if(!$db) {
			print('Failed to establish connection to mysql server!');
			exit();
		}
		
	
	//Creates a prepared statement to avoid injection attacks.
	$statement = $db->stmt_init();
	$statement->prepare("SELECT password FROM Customer WHERE username = ?");
	$statement->bind_param("s", $_GET['username']);
	$statement->execute();
	$statement->store_result();

	if($statement->num_rows==0)
		echo("0");
	else{
		$statement->bind_result($password);
		if($statement->fetch()) {
			if($password === $_GET['password'])
				echo("2");
			else
				echo("1");
		}
	}
	$statement->close();
	$db->close();
 ?>

