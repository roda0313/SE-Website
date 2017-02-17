<!doctype html>
<html lang="en">

<head>	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width"/>
	
	<title>Daniel Roberts Sign Up</title>
	<meta name="description" content="Daniel Roberts Website">
	<meta name="author" content="Daniel Roberts">
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
</head>

<body>
	<?php
		// define variables and set to empty values
		$usernameErr = $passwordErr = $confirmPasswordErr = $emailErr = "";
		$username = $password = $confirmPassword = $email = "";
		$usernameValid = $passwordValid = $emailValid = false;
         
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST["username"])) {
				$usernameErr = "Username cannot be blank";
			} 
			else {
				$username = test_input($_POST["username"]);
				$usernameValid = true;
			}
			
			if (strlen($_POST["password"]) < 6) {
				$passwordErr = "Password must be at least 6 characters long";
			}
			else {
				$passwordValid = true;
			}
			
			if ($_POST["confirmpassword"] != $_POST["password"]) {
				$confirmPasswordErr = "Passwords must match";
			}
			elseif ($passwordValid) {
				$password = test_input($_POST["password"]);
			}
			
			if (empty($_POST["email"])) {
				$emailErr = "Email cannot be blank";
			} 
			else {
				$email = test_input($_POST["email"]);
				$emailValid = true;
			}
			
			//check username is valid
			if ($passwordValid & $emailValid){
				if (file_exists ( "/home/spring2015/djr9478/public_html/Data/users.db" )){
					$dir = '/home/spring2015/djr9478/public_html/Data/users.db';
					$query = "SELECT * FROM USERS WHERE USERNAME='$username'";
					//$query_string = "SELECT * FROM USERS";
					
					// define a variable to switch on/off error messages
					$sqliteDebug = true;
					try {
						// connect to your database
						$sqlite = new SQLite3($dir);
					}
					catch (Exception $exception) {
						// sqlite3 throws an exception when it is unable to connect
						echo '<p>There was an error connecting to the database!</p>';
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
							$usernameErr = "Username already taken";
							$usernameValid = false;
						}
						else {
							$usernameValid = true;
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
			}
			
			if ($passwordValid & $usernameValid & $emailValid){
				//all valid create database objects
				
				if (file_exists ( "/home/spring2015/djr9478/public_html/Data/users.db" )){
					$dir = '/home/spring2015/djr9478/public_html/Data/users.db';
					$query = 'INSERT INTO USERS (USERNAME, PASSWORD, EMAIL) VALUES ("' . $username . '","' . $password . '","' . $email . '")';
					// define a variable to switch on/off error messages
					$sqliteDebug = true;
					try {
						// connect to your database
						$sqlite = new SQLite3($dir);
					}
					catch (Exception $exception) {
						// sqlite3 throws an exception when it is unable to connect
						echo '<p>There was an error connecting to the database!</p>';
						if ($sqliteDebug) {
							echo $exception->getMessage();
						}
					}
					
					try {
						$success = $sqlite->exec($query);
						
						//tell user account was created
						if ($success){
							echo '<p>Account Created!</p>';
							sleep(2);
							header("Location: ../home.php");
							exit;
						}
						else {
							echo '<p>Could not create account!</p>';
							if ($sqliteDebug){
								echo $sqlite->lastErrorMsg();
							}
						}
					}
					catch (Exception $exception){
						echo '<p>Could not create account!</p>';
						if ($sqliteDebug) {
							echo $exception->getMessage();
						}
					}
					
					// clean up any objects
					$sqlite->close();
				}
				else {
					header("Location: error.php"); /* Redirect browser */
					exit;
				}
			}
		}
         
		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
	?>

	<div class="container">
		<div align="center">
			<h1>Sign Up</h1><br>	
		</div>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		
			<?php if($usernameValid) : ?>
			<div class="form-group has-success has-feedback" >
				<label class="form-control-label" for="username">Username</label>
				<input id="username" class="form-control form-control-success" type="text" placeholder="Username" name="username" value="<?php echo $username; ?>">
				<span class='glyphicon glyphicon-ok form-control-feedback'></span>
			</div>
			
			<?php elseif($usernameErr != "") : ?>
			<div class="form-group has-warning has-feedback">
				<label class="form-control-label" for="username">Username</label>
				<input id="username" class="form-control form-control-danger" type="text" placeholder="Username" name="username" value="<?php echo $username; ?>">
				<big class="form-text text-danger"><?php echo $usernameErr; ?></big>
				<span class='glyphicon glyphicon-remove form-control-feedback'></span>
			</div>
			
			<?php else : ?>
			<div class="form-group">
				<label class="form-control-label">Username</label>
				<input class="form-control" type="text" placeholder="Username" name="username" value="<?php echo $username; ?>">
			</div>
			<?php endif; ?>
				
				
			<?php if($passwordErr != "") : ?>
				<div class="form-group has-warning has-feedback">
					<label class="form-control-label">Password</label>
					<input class="form-control" type="password" placeholder="Password" name="password">
					<big class="form-text text-danger"><?php echo $passwordErr; ?></big>
					<span class='glyphicon glyphicon-remove form-control-feedback'></span>
				</div>
				
			<?php elseif($confirmPasswordErr != "") : ?>
				<div class="form-group has-warning has-feedback">
					<label class="form-control-label">Password</label>
					<input class="form-control" type="password" placeholder="Password" name="password">
					<big class="form-text text-danger"><?php echo $confirmPasswordErr; ?></big>
					<span class='glyphicon glyphicon-remove form-control-feedback'></span>
				</div>
			
			<?php else : ?>
			<div class="form-group">
				<label class="form-control-label">Password</label>
				<input class="form-control" type="password" placeholder="Password" name="password">
			</div>
			<?php endif; ?>
			
			<?php if($confirmPasswordErr != "") : ?>
				<div class="form-group has-warning has-feedback">
					<label class="form-control-label">Confirm Password</label>
					<input class="form-control" type="password" placeholder="Confirm Password" name="confirmpassword">
					<big class="form-text text-danger"><?php echo $confirmPasswordErr; ?></big>
					<span class='glyphicon glyphicon-remove form-control-feedback'></span>
				</div>
			
			<?php else : ?>
			<div class="form-group">
				<label class="form-control-label">Confirm Password</label>
				<input class="form-control" type="password" placeholder="Confirm Password" name="confirmpassword">
			</div>
			<?php endif ?>
			
			
			<?php if($emailValid) : ?>
			<div class="form-group has-success has-feedback" >
				<label class="form-control-label" for="email">Email</label>
				<input id="email" class="form-control form-control-success" type="text" placeholder="Email" name="email" value="<?php echo $email; ?>">
				<span class='glyphicon glyphicon-ok form-control-feedback'></span>
			</div>
			
			<?php elseif($emailErr != "") : ?>
			<div class="form-group has-warning has-feedback">
				<label class="form-control-label" for="email">Email</label>
				<input id="email" class="form-control form-control-danger" type="text" placeholder="Email" name="email" value="<?php echo $email; ?>">
				<big class="form-text text-danger"><?php echo $emailErr; ?></big>
				<span class='glyphicon glyphicon-remove form-control-feedback'></span>
			</div>
			
			<?php else : ?>
			<div class="form-group">
				<label class="form-control-label">Email</label>
				<input class="form-control" type="email" placeholder="example@example.com" name="email" value="<?php echo $email; ?>">
			</div>
			<?php endif; ?>
			
			<div class="form-group">
				<button class="btn btn-primary" type="submit">Create Account</button>
				<a href="../home.php"><button class="btn btn-default" type="button">Cancel</button></a>
			</div>
			
		</form>
	</div>
	
	<div align="center">
	  <footer>&copy Daniel Roberts</footer>
	</div>	
	
</body>
</html>