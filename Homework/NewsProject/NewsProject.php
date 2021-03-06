<?php 
session_start();
include "Functions.php" ;

//ini_set('display_startup_errors', 1);
//ini_set('display_errors', 1);
//error_reporting(-1);

function setFirstVisit()
{
	$year = 31536000 + time(); //this adds one year to the current time, for the cookie expiration 
	$time = time();
	setcookie('LastVisit', $time, $year);
	$_COOKIE['LastVisit'] = $time;
}

function writeLastVisit()
{
	//write to file
	//ONLY call if username is set in session
	
	$file = "LastVisit.json";
	$userfound = false;
	
	$string = file_get_contents($file);
	$json = json_decode($string);
	
	foreach ($json as $val)
	{
		if ($val->username == $_SESSION['Newsusername'])
		{
			$val->time = time();
			$userfound = true;
		}
	}
	
	if ($userfound == false)
	{
		$value = json_encode(array("username" => $_SESSION['Newsusername'], "time" => time()));
		
		if ($json == NULL)
		{
			$json = $value;
		}
		else
		{
			array_push($json, $value);
		}
	}
	
	file_put_contents($file, $json);
}

function readLastVisit()
{
	$file = "LastVisit.json";
	$userfound = false;
	
	$string = file_get_contents($file);
	$json = json_decode($string);
	
	foreach ($json as $val)
	{
		if ($val->username == $_SESSION['Newsusername'])
		{
			$time = $val->time;
			$userfound = true;
		}
	}
	
	//set cookie
	$year = 31536000 + time(); //this adds one year to the current time, for the cookie expiration 
	
	if ($userfound)
	{
		setcookie('LastVisit', $time, $year);
		$_COOKIE['LastVisit'] = $time;
	}
	else
	{
		setFirstVisit();
	}
}

if (!isset($_COOKIE['LastVisit']))
{
	setFirstVisit();
	
	//if (isset($_SESSION['Newsusername']))
	//{
	//	writeLastVist();
	//}
}
else
{
	//read from storage
	//if (isset($_SESSION['Newsusername']))
	//{
	//	readLastVisit();
	//}	
}

?>

<html>
<head>
	<meta charset="utf-8">

	<title>Daniel Roberts Website</title>
	<meta name="description" content="Daniel Roberts Website">
	<meta name="author" content="Daniel Roberts">
	<meta name="viewport" content="width=device-width"/>
	
	<!-- JQuery -->
	<script
		src="https://code.jquery.com/jquery-3.1.1.min.js"
		integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
		crossorigin="anonymous">
	</script>
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<script type="text/javascript">
	
	nextDiv = 0;
	maxDiv = 0;
	
	$(document).ready(function(){
		$(window).scroll(function(){	
			
			if (nextDiv < maxDiv)
			{
				$("#" + nextDiv).removeAttr("style");
				nextDiv++;
			}
		});
	});
	
	//actually radio change, but code is old and never changed the function name
	function checkboxChange(CheckboxName)
	{
		//first delete current content
		
		var divId = CheckboxName + " Feed";
		
		document.getElementById("FeedDiv").innerHTML = "";
		
		$url = "Functions.php?function=getFeed&feed_name=" + CheckboxName;
		
		var xmlHttp = new XMLHttpRequest();
		xmlHttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var iDiv = document.createElement('div');
				iDiv.id = divId;
				iDiv.innerHTML += ("<h3>" + CheckboxName + "</h3>");
				iDiv.innerHTML += xmlHttp.responseText;

				document.getElementById("FeedDiv").appendChild(iDiv);
				
				nextDiv = parseInt(document.getElementById("last_hidden_div_id").value);
				maxDiv = parseInt(document.getElementById("max_div").value);
			}
		};
		
		xmlHttp.open( "GET", $url, true ); // false for synchronous request
		xmlHttp.send();
	}
	
	function pageUnload() 
	{
		//for cookies storing, determine when a user leaves the page
		<?php setFirstVisit(); ?>
	}
	
	function onLikeClick(id)
	{
		var titleString = document.getElementById("fav_title_" + id).innerHTML;
		var linkString = document.getElementById("fav_link_" + id).innerHTML;
		var descString = document.getElementById("fav_desc_" + id).innerHTML;
		
		var http = new XMLHttpRequest();
		var url = "Functions.php?";
		var params = "function=likeArticle&entry_title=" + titleString + "&entry_link=" + linkString + "&entry_description=" + descString;
		
		http.open("POST", url, true);
		
		//Send the proper header information along with the request
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		http.onreadystatechange = function() {//Call a function when the state changes.
			if(http.readyState == 4 && http.status == 200) {
				var iDiv = document.createElement('div');
				iDiv.id = id;
				iDiv.innerHTML += http.responseText;

				document.getElementById("FavouritesDiv").appendChild(iDiv);
			}
		}
		
		http.send(params);
	}
	
	function onUnlikeClick(id)
	{		
		var http = new XMLHttpRequest();
		var url = "Functions.php?";
		var params = "function=unlikeArticle&id=" + id
		
		http.open("POST", url, true);
		
		//Send the proper header information along with the request
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		http.onreadystatechange = function() {//Call a function when the state changes.
			if(http.readyState == 4 && http.status == 200) {
				// remove the div
				console.log(http.responseText);
				document.getElementById("fav_" + id).remove();
			}
		}
		
		http.send(params);
	}
	
	function login()
	{
		console.log("login");
	}
	
	function signup()
	{
		
	}
		
	</script>
	
</head>
<body id="body" onunload="pageUnload()">
<div id="mainDiv">
	
<?php if($_SESSION['Newsloggedin'] == true) : ?>

<!-- Main page content -->	
<div class="container" align="center">
	<?php 
	if (isset($_COOKIE['LastVisit']))
	{
		$dateAsString = date("D F Y g:i:s A", $_COOKIE['LastVisit']);				
		echo "<h1>Welcome back " . $_SESSION['Newsusername'] . " your last visit was " . $dateAsString . "</h1>";
	}
	
	echo '<a href="Functions.php?function=logout" class="btn btn-primary btn-primary">Logout</a>';
	
	DisplayFeedOptions();
	
	echo '<ul class="nav nav-pills">';
	echo '<li class="active"><a data-toggle="pill" href="#FeedDiv">All</a></li>';
	echo '<li><a data-toggle="pill" href="#FavouritesDiv">Favorites</a></li>';
	echo '</ul>';

	echo '<div class="tab-content">';
	
	echo "<div class='tab-pane fade' align='left' id='FavouritesDiv'>";
	loadFavs();
	echo '</div>';
	
	echo "<div class='tab-pane fade in active' align='left' id='FeedDiv'>";
	echo '</div>';
	
	echo '</div>';
	
	?>
	
</div>

<?php else : ?>

<div class="container">
	<div align="left">
		<h1>Log In</h1><br>	
	</div>
	<form method="post" action="NewsProject.php?function=login">
		<div class="form-group">
			<label class="form-control-label">Username</label>
			<input class="form-control" type="text" placeholder="Username" name="username" required >
		</div>
							
		<div class="form-group">
			<label class="form-control-label">Password</label>
			<input class="form-control" type="password" placeholder="Password" name="password" required >
		</div>			
		
		<div class="form-group">
			<button class="btn btn-primary" type="submit">Login</button>
		</div>
		
	</form>
</div>

<div class="container">
	<div align="left">
		<h1>Sign Up</h1><br>	
	</div>
	<form method="post" action="NewsProject.php?function=signup">
		<div class="form-group">
			<label class="form-control-label">Username</label>
			<input class="form-control" type="text" placeholder="Username" name="username" required >
		</div>
							
		<div class="form-group">
			<label class="form-control-label">Password</label>
			<input class="form-control" type="password" placeholder="Password" name="password" required >
		</div>			
		
		<div class="form-group">
			<button class="btn btn-primary" type="submit">Create Account</button>
		</div>
		
	</form>
</div>

<?php endif; ?>

</div>
</body>
</html>

