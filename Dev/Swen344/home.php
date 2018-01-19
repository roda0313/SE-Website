<?php 
	session_start(); 
?>
<!doctype html>

<html lang="en">
<head>	
	<meta charset="utf-8">
	
	<title>Co-op Evaluation Home</title>
	<meta name="description" content="Daniel Roberts Website">
	<meta name="author" content="Daniel Roberts">
	<meta name="viewport" content="width=device-width"/>
	
	<!-- External CSS -->
	<link rel="stylesheet" href="home.css">
	
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/84/three.min.js" crossorigin="anonymous"</script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
</head>

<body>
	<nav class="navbar navbar-default">
		
	</nav>	
	
	<?php if($_SESSION['loggedin'] == true) : ?>
	<!-- Main page content -->
	<div class="container" align="Center">
		<div class="container loggedInHeader">
			<h1>Co-op Evaluation System</h1>
			<h3>Welcome <?php echo ($_SESSION['userInfo']['USERNAME']) ?></h3>
			<a href="logout.php"><button class="btn btn-primary">Sign Out</button></a>
		</div>
		<div class="container allCompanies" align="center">
			<?php
			
				$url = 'http://vm344f.se.rit.edu/API/API.php?team=coop_eval&function=getCompanies&StudentID=' . $_SESSION['userInfo']['ID'];
				
				$ch = curl_init( $url );
				
				$timeout = 5;
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

				$response = curl_exec( $ch );
				$data = json_decode($response, true);
				
				curl_close($ch);
				
				if ($data)
				{
					echo '<h1>Companies</h1>';
					foreach ($data as $arr)
					{
						echo '
							<div class="company">
								<h3>Name: ' . $arr['NAME'] . '</h3>
								<h3>Address: ' . $arr['ADDRESS'] . '</h3>
							</div>			
						';
					}
				}
			
			?>
		</div>
		
	</div>
	
	
	<?php else : ?>
	<div class="container" align="Center">
		<form method="POST" id="login" action="login.php">
			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" class="form-control" id="username" placeholder="Username" name="username">
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" placeholder="Password" name="password">
			</div>
			<button class="btn btn-primary" type="submit">Sign In</button>			
		</form>
	</div>
	
	
	<?php endif; ?>
		
	<div align="center">
	  <footer>Email: <a href="mailto:djr9478@rit.edu" target="_top">djr9478@rit.edu </a> &copy TeamCoopEval</footer>
	</div>	
	
</body>
</html>

