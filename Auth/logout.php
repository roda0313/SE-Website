<?php
	session_start();
	//ini_set('display_startup_errors', 1);
	//ini_set('display_errors', 1);
	//error_reporting(-1);
	
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
	
	unset($_SESSION["username"]);
	unset($_SESSION["password"]);
	$_SESSION['loggedin'] = false;
	
	header('Refresh: 0; URL = ../home.php');
?>