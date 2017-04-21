<?php

function setLastVisit() {
	//write last visit value
	$dir = '/home/spring2015/djr9478/public_html/Data/users.db';
	$query = "UPDATE Users SET LASTVISIT = '" . time() . "' WHERE USERNAME='" . $_SESSION['username'] . "'";

	// define a variable to switch on/off error messages
	$sqliteDebug = false;
	try {
		// connect to your database
		$sqlite = new SQLite3($dir);
	}
	catch (Exception $exception) {
		// sqlite3 throws an exception when it is unable to connect
		echo '<p>An error occurred</p>';
		if ($sqliteDebug) {
			echo $exception->getMessage();
		}
	}

	$sqlite->query($query);

	// clean up any objects
	$sqlite->close();
}
	
?>