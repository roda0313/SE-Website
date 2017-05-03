<?php

session_start();

//GLOBALS
$data_file = "data.json";
$feeds_file = "feeds.json";

$initial_load = 5;
//

class user 
{
    public $username = "";
    public $articles = array();
}


if (isset($_GET['function']))
{
	switch ($_GET['function'])
	{
		case "login":
			return login();
		case "signup":
			return signup();
		case "getFeed":
			return getFeed($_GET['feed_name']);
		case "likeArticle":
			return likeArticle();
		case "DisplayFeedOptions":
			return DisplayFeedOptions();
		case "getNextToLoad":
			return getNextToLoad();
		default:
			return "An error occurred";
	}
}

function login()
{
	//check if user already exists
	$inp = file_get_contents($GLOBALS["data_file"]);
	$tempArray = json_decode($inp);
	
	foreach ($tempArray as $user)
	{
		if ($user->username == $_POST['username'])
		{
			$_SESSION['Newsusername'] = $_POST['username'];
			$_SESSION['Newsloggedin'] = true;
			$_SESSION['articles'] = $user->articles;
			
			header("Location: NewsProject.php");
		}
	}
	
	echo "Invalid login";
	return false;
}

function signup()
{
	//check if user already exists
	$inp = file_get_contents($GLOBALS["data_file"]);
	$tempArray = json_decode($inp);
	
	foreach ($tempArray as $user)
	{
		if ($user->username == $_POST['username'])
		{
			echo "Invalid Username, please try again";
			return false;
		}
	}
	
	$user = new user();
	$user->username = $_POST['username'];
	
	if ($tempArray != NULL)
	{
		array_push($tempArray, $user);
	}
	else 
	{
		$tempArray = array($user);
	}
	
	$jsonData = json_encode($tempArray);
	
	file_put_contents($GLOBALS["data_file"], $jsonData);
	
	echo "Success, please go back and login";
}

function DisplayFeeds()
{
	
}

function DisplayFeedOptions()
{
	$string = file_get_contents($GLOBALS["feeds_file"]);
	$json = json_decode($string);
	
	$htmlString = "<div id='FeedOptions' class='Container' align='center'>";
		
	foreach($json as $feed) 
	{
		$name =  $feed->name;
		$nameAsString = "\"" . $name . "\"";

		$htmlString = $htmlString . "<label class='radio-inline'><input name='feedoptions' type='radio' onchange='checkboxChange(".$nameAsString.")' id='".$name."' value='".$name."'>".$name."</label>";
	}
	
	$htmlString = $htmlString . "</div>";
	
	echo $htmlString;
}

function getFeed($feed_name) 
{
	$count = 0; 
	
	$string = file_get_contents($GLOBALS["feeds_file"]);
	$json = json_decode($string);
	
	foreach($json as $feed) 
	{
		if ($feed->name == $feed_name)
		{
			$feed_url = $feed->link;
		}
	}
	
    $content = file_get_contents($feed_url);
    $x = new SimpleXmlElement($content);
	$title = $x->channel->title;
	
    foreach($x->channel->item as $entry) 
	{
		//initiall only show 10
		$id = $title . "_" . $count;
		
		if ($count > $GLOBALS["initial_load"])
		{
			echo "<div hidden id=$count>";
		}
		else 
		{
			echo "<div id=$count>";
		}
		
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
	
	//hidden inputs hold valuable info
	echo '<input hidden id="max_div" value="'.($count - 1).'">';
	echo '<input hidden id="last_hidden_div_id" value="'.($GLOBALS["initial_load"] + 1).'">';
}

//return JSON
//header('Content-type:application/json;charset=utf-8');
//echo json_encode($result);

?>