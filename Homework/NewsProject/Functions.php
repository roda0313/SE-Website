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

class article
{
	public $id = -1;
	public $title = "";
	public $link = "";
	public $description = "";
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
			return likeArticle($_POST['entry_title'], $_POST['entry_link'], $_POST['entry_description']);
		case "DisplayFeedOptions":
			return DisplayFeedOptions();
		case "getNextToLoad":
			return getNextToLoad();
		case "logout":
			return logout();
		default:
			return "An error occurred";
	}
}

if (isset($_POST['function']))
{
	switch ($_POST['function'])
	{
		case "likeArticle":
			return likeArticle($_POST['entry_title'], $_POST['entry_link'], $_POST['entry_description']);
		case "unlikeArticle":
			return unlikeArticle($_POST['id']);
		default:
			return "An error occurred";
	}
}

function login($username)
{
	if ($username == null)
	{
		$username = $_POST['username'];
	}
	
	//check if user already exists
	$inp = file_get_contents($GLOBALS["data_file"]);
	$tempArray = json_decode($inp);
	
	foreach ($tempArray as $user)
	{
		if ($user->username == $username)
		{
			$_SESSION['Newsusername'] = $username;
			$_SESSION['Newsloggedin'] = true;
			$_SESSION['articles'] = $user->articles;
			
			header("Location: NewsProject.php");
		}
	}
	
	$message = "Login invalid, please try again";
	echo "<script type='text/javascript'>alert('$message');</script>";
	return false;
}

function logout()
{
	session_destroy();
	header("Location: NewsProject.php");
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
			$message = "Invalid username, please try again";
			echo "<script type='text/javascript'>alert('$message');</script>";
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
	login($_POST['username']);
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
			echo "<div style='display: none;' id=$count>";
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

function likeArticle($entry_title, $entry_link, $entry_description)
{
	$inp = file_get_contents($GLOBALS["data_file"]);
	$tempArray = json_decode($inp);
	
	foreach ($tempArray as $user)
	{
		if ($user->username == $_SESSION['Newsusername'])
		{
			$article = new article();
			
			if (count($user->articles) == 0)
			{
				$article->id = 0;
			}
			else
			{
				$article->id = (end($user->articles)->id + 1);
			}
			
			$article->title = $entry_link;
			$article->link = $entry_link;
			$article->description = $entry_description;
			
			array_push($user->articles, $article);
		}
	}
	
	$jsonData = json_encode($tempArray);	
	file_put_contents($GLOBALS["data_file"], $jsonData);
	
	//echo stuff to actual window
	echo "<div id='fav_$article->id'>";
	
	//like button. Hidden form for the values needed
	echo "&#9<button class='btn btn-sm btn-default' onclick='onUnlikeClick(\"" . $article->id . "\")'><span class='glyphicon glyphicon-minus'></span>Remove</button><br>";
	
	echo "<a href='$entry_link' title='$entry_title'>" . $entry_title . "</a><br>";		
	echo "$entry_description <br><br>";
	echo "<br></div>";
}

function loadFavs()
{
	$inp = file_get_contents($GLOBALS["data_file"]);
	$tempArray = json_decode($inp);
	
	foreach ($tempArray as $user)
	{
		if ($user->username == $_SESSION['Newsusername'])
		{
			foreach ($user->articles as $article)
			{
				//echo stuff to actual window
				echo "<div id='fav_$article->id'>";
				
				//like button. Hidden form for the values needed
				echo "&#9<button class='btn btn-sm btn-default' onclick='onUnlikeClick(\"" . $article->id . "\")'><span class='glyphicon glyphicon-minus'></span>Remove</button><br>";
				
				echo "<a href='$article->link' title='$article->title'>" . $article->title . "</a><br>";		
				echo "$article->description <br><br>";
				echo "<br></div>";
			}
			break;
		}
	}
}

function unlikeArticle($id)
{
	//removal of html is handeled inside the AJAX call
	$inp = file_get_contents($GLOBALS["data_file"]);
	$tempArray = json_decode($inp);
	
	$count = 0;
	
	foreach ($tempArray as $user)
	{
		if ($user->username == $_SESSION['Newsusername'])
		{
			foreach ($user->articles as $article)
			{
				if ($article->id == $id)
				{
					array_splice($user->articles, $count, 1);
					break;
				}
				
				$count++;
				
			}
			
			break;
		}
	}
	
	$jsonData = json_encode($tempArray);	
	file_put_contents($GLOBALS["data_file"], $jsonData);
}

//return JSON
//header('Content-type:application/json;charset=utf-8');
//echo json_encode($result);

?>