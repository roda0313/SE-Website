<?php 
session_start();
include "Functions.php" ;

//ini_set('display_startup_errors', 1);
//ini_set('display_errors', 1);
//error_reporting(-1);

function setLastVisit()
{
	$year = 31536000 + time(); //this adds one year to the current time, for the cookie expiration 
	$time = time();
	setcookie('LastVisit', $time, $year);
	$_COOKIE['LastVisit'] = $time;
}

if (!isset($_COOKIE['LastVisit']))
{
	setLastVisit();
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
				$("#" + nextDiv).removeAttr("hidden");
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
		document.getElementById("body").innerHTML += "<?php setLastVisit();	?>"
	}
	
	function onLikeClick(id)
	{
		var titleString = document.getElementById("fav_title_" + id).innerHTML;
		var linkString = document.getElementById("fav_link_" + id).innerHTML;
		var descString = document.getElementById("fav_desc_" + id).innerHTML;
		
		var http = new XMLHttpRequest();
		var url = "RSSFeeds.php?";
		var params = "entry_title=" + titleString + "&entry_link=" + linkString + "&entry_description=" + descString;
		
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
		echo "<h1>Welcome back " . $_SESSION['username'] . " your last visit was " . $dateAsString . "</h1>";
	}
	
	DisplayFeedOptions();
	
	echo '<div class="panel-group">';
	
	echo '<div class="panel panel-default">';
	echo '<div class="panel-heading">';
	echo '<h4 class="panel-title">';
	echo '<a align="left" data-toggle="collapse" href="#FavouritesDiv">Favorites</a>';
	echo '</h4>';
	echo '</div>';
	echo "<div class='container' align='left' id='FavouritesDiv'>";
	echo '</div>';
	echo '</div>';
	
	echo '<div class="panel panel-default">';
	echo '<div class="panel-heading">';
	echo '<h4 class="panel-title">';
	echo '<a align="left" data-toggle="collapse" href="#FeedDiv">News Feeds</a>';
	echo '</h4>';
	echo '</div>';
	echo "<div class='container' align='left' id='FeedDiv'>";
	echo '</div>';
	echo '</div>';
	
	echo '</div>';
	
	?>
	
</div>

<?php else : ?>

<div class="container">
	<div align="left">
		<h1>Log In</h1><br>	
	</div>
	<form method="post" action="Functions.php?function=login">
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
	<form method="post" action="Functions.php?function=signup">
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
