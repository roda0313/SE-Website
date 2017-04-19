<html>
<head>

</head>

   <body>
      
      <h2>Enter Username and Password</h2> 
      <div>
         
<?php
// Start the session
session_start();
            $msg = '';
            
            if (isset($_POST['login']) && !empty($_POST['username']) 
               && !empty($_POST['password'])) {
				
               if ( $_POST['password'] == '1234') { // only check for a password of 1234
                  $_SESSION['username'] = $_POST['username'];
				  $_SESSION['color'] = $_POST['color'];
               ?>
                  <h2>You have entered valid use name and password</h2>
                  <a href="session1.php">Click here to continue</a>

<?php
               }else {
                  $msg = 'Wrong username or password';
               }
            }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
      
         <form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
            <input type = "text" name = "username" required autofocus></br>
            <input type = "password"  name = "password" required>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Login</button>
			<br />
			<input type="radio" name="color" value="Red" checked> Red
			<input type="radio" name="color" value="Green"> Green
			<input type="radio" name="color" value="Blue"> Blue  
         </form>
			
         Click here to clean <a href = "clearsessions.php" tite = "Logout">Session.</a>
         
      </div> 
      

<p>
<b>Login:</b> <i>You can enter whatever you want</i> <br>
<b>Password:</b> 1234
   <p/>

   </body>
</html>