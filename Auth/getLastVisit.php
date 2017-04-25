<?php

function getLastVisit(){
	if (file_exists ( "/home/spring2015/djr9478/public_html/Data/users.db" )){
		$dir = '/home/spring2015/djr9478/public_html/Data/users.db';
		$query = "SELECT * FROM USERS WHERE USERNAME='" . $_SESSION['username'] . "'";
		
		// define a variable to switch on/off error messages
		$sqliteDebug = true;
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
		
		$sqliteResult = $sqlite->query($query);
		
		if (!$sqliteResult and $sqliteDebug) {
			// the query failed and debugging is enabled
			echo "<p>There was an error in query: $query</p>";
			echo $sqlite->lastErrorMsg();
		}
		
		if ($sqliteResult) {
			if ($record = $sqliteResult->fetchArray()) {
				//record was found
				
				return $record['LASTVISIT'];
			}
			else {
				echo "<p>Login Invalid!</p>";
			}
		}
		
		// clean up any objects
		$sqliteResult->finalize();
		$sqlite->close();
	}
	else {
		header("Location: error.php"); /* Redirect browser */
		exit;
	}
}

?>