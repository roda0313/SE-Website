<?php 
session_start();

if (file_exists ( "/home/spring2015/djr9478/public_html/Data/users.db" )){
	$dir = '/home/spring2015/djr9478/public_html/Data/users.db';
	$query = "SELECT * FROM USERS WHERE USERNAME='" . $_POST['username'] . "'";
	
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
			if($_POST['password'] == $record['PASSWORD'])
			{
				$_SESSION['valid'] = true;
				$_SESSION['timeout'] = time();
				$_SESSION['username'] = $_POST['username'];
				$_SESSION['loggedin'] = true; 
				
				//set last visit cookie
				$year = 31536000 + time(); //this adds one year to the current time, for the cookie expiration 
				
				if ($reocrd['LASTVISIT']) {
					$_COOKIE["LastVisit"] = $record['LASTVISIT'];
				}
				else {
					$_COOKIE["LastVisit"] = "Never";
				}
				
				
				//redirect 
				header('Refresh: 0; URL = ../home.php');
			}
			else
			{
				echo "<p>Login Invalid!</p>";
			}
		}
		else {
			echo "<p>Login Invalid!</p>";
		}
		
		$sqliteResult->finalize();
	}
	
	// clean up any objects
	$sqlite->close();
}
else {
	header("Location: error.php"); /* Redirect browser */
	exit;
}
	
?>