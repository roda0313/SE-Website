<?php
//ini_set('display_startup_errors', 1);
//ini_set('display_errors', 1);
//error_reporting(-1);


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

			//if ($_COOKIE[(preg_replace('/\s+/', '_', $name))] == 1)
			//{
			//	$htmlString = $htmlString . "<label class='checkbox-inline'><input type='checkbox' checked onchange='checkboxChange(".$nameAsString.")' id='".$name."'>".$name."</label>";
			//}
			//else 
			//{
			//	$htmlString = $htmlString . "<label class='checkbox-inline'><input type='checkbox' onchange='checkboxChange(".$nameAsString.")' id='".$name."'>".$name."</label>";
			//}
			
			$htmlString = $htmlString . "<label class='checkbox-inline'><input type='checkbox' onchange='checkboxChange(".$nameAsString.")' id='".$name."'>".$name."</label>";
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
    $count = 0; 
	$title = $x->channel->title;
	
    foreach($x->channel->item as $entry) 
	{
		$id = $title . "_" . $count;
		echo "<div>";
		
		//like button. Hidden form for the values needed
		echo "<div id='fav_title_$id' hidden name='entry_title'>$entry->title</div>";
		echo "<div id='fav_link_$id' hidden name='entry_link'>$entry->link</div>";
		echo "<div id='fav_desc_$id' hidden name='entry_description'>$entry->description</div>";
		echo "&#9<button class='btn btn-sm btn-default' onclick='onLikeClick(\"" . $id . "\")'><span class='glyphicon glyphicon-thumbs-up'></span>Favorite</button><br>";
		
        echo "<a href='$entry->link' title='$entry->title'>" . $entry->title . "</a><br>";		
		echo "$entry->description <br><br>";
		echo "</div><br>";
		
		$count++;
    }
}

function likeArticle($entry_title, $entry_link, $entry_description)
{
	session_start();
	
	$dir = '/home/spring2015/djr9478/public_html/Data/users.db';
	$query = 'INSERT INTO FavouriteArticles (USERNAME, TITLE, LINK, DESCRIPTION) VALUES ("'.$_SESSION['username'].'","'.$entry_title.'","'.$entry_link.'","'.$entry_description.'")';

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
	
	$sqlite->exec($query);	
	$sqlite->close();
	
	//echo stuff to actual window
	$id = $title . "_" . $count;
	echo "<div>";
	
	//like button. Hidden form for the values needed
	echo "<div hidden name='entry_title'>$entry_title</div>";
	echo "<div hidden name='entry_link'>$entry-_link</div>";
	echo "<div hidden name='entry_description'>$entry_description</div>";
	echo "&#9<button class='btn btn-sm btn-default'><span class='glyphicon glyphicon-minus'></span>Remove</button><br>";
	
	echo "<a href='$entry_link' title='$entry_title'>" . $entry_title . "</a><br>";		
	echo "$entry_description <br><br>";
	echo "</div><br>";
}

function unlikeArticle($entry_title, $entry_link, $entry_description)
{
	
	$id = $title . "_" . $count;
	echo "<div>";
	
	//like button. Hidden form for the values needed
	echo "<div hidden name='entry_title'>$entry_title</div>";
	echo "<div hidden name='entry_link'>$entry-_link</div>";
	echo "<div hidden name='entry_description'>$entry_description</div>";
	echo "&#9<button class='btn btn-sm btn-default'><span class='glyphicon glyphicon-minus'></span>Remove</button><br>";
	
	echo "<a href='$entry_link' title='$entry_title'>" . $entry_title . "</a><br>";		
	echo "$entry_description <br><br>";
	echo "</div><br>";
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
	DisplayFeed($_GET['feed_name']);
}

if(isset($_POST['entry_title']))
{
	likeArticle($_POST['entry_title'], $_POST['entry_link'], $_POST['entry_description']);
}


?>