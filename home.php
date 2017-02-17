<!doctype html>
<?php session_start(); ?>

<html lang="en">
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
			
			<div class="collapse navbar-collapse" id="navbar">
				<ul class="nav navbar-nav navbar-left">
					<li class="active"><a href="index.html">Home <span class="sr-only">(current)</span></a></li>
					<li><a href="Activities.html">Activities</a></li>
					<li><a href="Homework.html">Homework</a></li>
					
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
	<div class="container" align="Center">
		<br><br><br><img src="Images/pic.jpg"/><br><br><br>
	</div>
		
	<div align="center">
	  <footer>Email: <a href="mailto:djr9478@rit.edu" target="_top">djr9478@rit.edu </a> &copy Daniel Roberts</footer>
	</div>	
	
</body>
</html>