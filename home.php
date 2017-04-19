<?php 
session_start(); 
include 'RSSFeeds.php';

//ini_set('display_startup_errors', 1);
//ini_set('display_errors', 1);
//error_reporting(-1);

if (isset($_SESSION['username']))
{
	$last = time();
	
	//get LastVisit from database and set cookie
	$dir = '/home/spring2015/djr9478/public_html/Data/users.db';
	$query = "SELECT LASTVISIT FROM Users WHERE USERNAME='" . $_SESSION['username'] . "'";
	
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
		if($record = $sqliteResult->fetchArray()) 
		{
			$last = $record['LASTVISIT'];
		}
		
	}
	
	$year = 31536000 + time(); //this adds one year to the current time, for the cookie expiration 
	setcookie("LastVisit", $last, $year);
	
	// clean up any objects
	$sqliteResult->finalize();
	$sqlite->close();
}

?>

<html lang="en">
<head>	
	<meta charset="utf-8">
	
	<title>Daniel Roberts Website</title>
	<meta name="description" content="Daniel Roberts Website">
	<meta name="author" content="Daniel Roberts">
	<meta name="viewport" content="width=device-width"/>
	
	<!-- JQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
	<script>
	
	function checkboxChange(CheckboxName)
	{
		var divId = CheckboxName + " Feed";
		
		if(document.getElementById(CheckboxName).checked)
		{			
			$url = "RSSFeeds.php?feed_name=" + CheckboxName;
		
			var xmlHttp = new XMLHttpRequest();
			xmlHttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var iDiv = document.createElement('div');
					iDiv.id = divId;
					iDiv.innerHTML += ("<h3>" + CheckboxName + "</h3>");
					iDiv.innerHTML += xmlHttp.responseText;
					
					console.log(iDiv);

					document.getElementById("FeedDiv").appendChild(iDiv);
					//document.getElementById(CheckboxName).innerHTML = xmlHttp.responseText;
				}
			};
			
			xmlHttp.open( "GET", $url, true ); // false for synchronous request
			xmlHttp.send();
		}
		else 
		{
			document.getElementById(divId).remove();
		}
	}
		
	</script>
	
</head>

<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span> 
				</button>
			</div>
			
			<div class="collapse navbar-collapse" id="navbar" name="navbar">
				<ul class="nav navbar-nav navbar-left">
					<li class="active"><a href="index.html">Home <span class="sr-only">(current)</span></a></li>
					<li><a href="Homework.html">Homework</a></li>
					<li><a href="about.php">About</a></li>					
				</ul>
				
				<?php if($_SESSION['loggedin'] == true) : ?>
					<ul class="nav navbar-nav navbar-right">
					
						<li><a href="#link"><span class="glyphicon glyphicon-user"></span>
							<label><?php echo $_SESSION['username']; ?></label>
							</a>
						</li>
						
						<li>
							<form class="navbar-form" method="post" action="Auth/logout.php">
								<button class="btn btn-primary" type="submit">Logout</button>
							</form>
						</li>
					</ul>
				<?php else : ?>
				<form class="navbar-form navbar-right" method="post" action="Auth/login.php">
					<input class="form-control" type="text" placeholder="Username" name="username">
					<input class="form-control" type="password" placeholder="Password" name="password">
					<button class="btn btn-default" type="submit">Sign In</button>
					<a href="Auth/signup.php"><button class="btn btn-primary" type="button">Sign Up</button></a>
				</form>
				<?php endif; ?>
			</div>				
		</div>
	</nav>	
	
	<!-- Main page content -->	
	<div class="container" align="center">
		<?php 
		
		if($_SESSION['loggedin'] == true) 
		{
			if (isset($_COOKIE['LastVisit']))
			{
				$dateAsString = date("D F Y g:i:s A", $_COOKIE['LastVisit']);
				echo "<h1>Welcome back " . $_SESSION['username'] . " your last visit was " . $dateAsString . "</h1>";
			}
			
			DisplayFeedOptions($_SESSION['username']);
			
			echo "<div class='container' align='left' id='FeedDiv'>";
			echo '</div>';
		}
		else 
		{
			echo '<br><br><br><img src="Images/pic.jpg"><br><br><br>';
		}
		
		?>
		
	</div>
		
	<div align="center">
	  <footer>Email: <a href="mailto:djr9478@rit.edu" target="_top">djr9478@rit.edu </a> &copy Daniel Roberts</footer>
	</div>	
	
</body>
</html>