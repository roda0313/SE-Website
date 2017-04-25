<?php

function DisplayFeedOptions($username)
{
	$dir = '/home/spring2015/djr9478/public_html/Data/users.db';
	$query = "SELECT * FROM NewsFeed";
	
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
	
	$sqliteResult = $sqlite->query($query);
	
	if ($sqliteResult) 
	{
		$htmlString = "<div class = 'Container' align='center'>";
		
		while($record = $sqliteResult->fetchArray()) 
		{
			$name =  $record['NAME'] ;
			$nameAsString = "\"" . $name . "\"";

			if ($_COOKIE[(preg_replace('/\s+/', '_', $name))] == 1)
			{
				$htmlString = $htmlString . "<label class='checkbox-inline'><input type='checkbox' checked onchange='checkboxChange(".$nameAsString.")' id='".$name."'>".$name."</label>";
			}
			else 
			{
				$htmlString = $htmlString . "<label class='checkbox-inline'><input type='checkbox' onchange='checkboxChange(".$nameAsString.")' id='".$name."'>".$name."</label>";
			}
		}
		
		$htmlString = $htmlString . "</div>";
		
		echo $htmlString;
		
	}
	
	// clean up any objects
	$sqliteResult->finalize();
	$sqlite->close();
	
}

function DisplayFeeds($username)
{
	if (file_exists ( "/home/spring2015/djr9478/public_html/Data/users.db" ))
	{
		$dir = '/home/spring2015/djr9478/public_html/Data/users.db';
		$query = "SELECT * FROM NewsFeed";
		
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
		
		$sqliteResult = $sqlite->query($query);
		
		if ($sqliteResult) 
		{
			while($record = $sqliteResult->fetchArray()) 
			{
				echo "<h1>" . $record['NAME'] ."</h1>";
				getFeed($record['LINK']);
			}
			
		}
		
		// clean up any objects
		$sqliteResult->finalize();
		$sqlite->close();
	}
}

function DisplayFeed($feed_name)
{
	
	if (file_exists ( "/home/spring2015/djr9478/public_html/Data/users.db" ))
	{
		$dir = '/home/spring2015/djr9478/public_html/Data/users.db';
		$query = "SELECT LINK FROM NewsFeed WHERE NAME='" . $feed_name . "'";
		
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
		
		$sqliteResult = $sqlite->query($query);
		
		if ($sqliteResult) 
		{
			while($record = $sqliteResult->fetchArray()) 
			{
				echo "<h1>" . $record['NAME'] ."</h1>";
				getFeed($record['LINK']);
			}
			
		}
		
		// clean up any objects
		$sqliteResult->finalize();
		$sqlite->close();
	}
}

function getFeed($feed_url) 
{
     
    $content = file_get_contents($feed_url);
    $x = new SimpleXmlElement($content);
     
    foreach($x->channel->item as $entry) 
	{
        echo "<a href='$entry->link' title='$entry->title'>" . $entry->title . "</a>";
		echo "&#9<a href='#' class='btn btn-sm btn-default'><span class='glyphicon glyphicon-thumbs-up'></span> Like</a><br/>";
		echo "$entry->description <br><br>";
    }
}

//Feed string must be a comma seperated string with the names of the news feeds from the NewsFeed table
function updateFeed($username, $feed_string)
{
	//first get current news feeds
	$dir = '/home/spring2015/djr9478/public_html/Data/users.db';
	$query = "UPDATE Users SET NEWSFEEDS = '" . $feed_string ."' WHERE Username = '" . $username . "'";
	
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
	$sqliteResult->finalize();
	$sqlite->close();
}

if(isset($_GET['feed_name']))
{
	echo '<script>console.log("Called")</script>';
	DisplayFeed($_GET['feed_name']);
}


?>