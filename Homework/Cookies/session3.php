<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php
// Read the sessions
if ($_SESSION["username"] != "") {
	echo "<h1>Hello ";
    echo $_SESSION["username"];
	
	if (isset($_SESSION["name"]))
	{
		echo "<h1>You input  ";
		echo $_SESSION["name"];
		echo " as your name<h1> ";
		echo "<br />";
	}
}else{
?>

	You are not a valid user


	<?php
}
?>

</body>


</html>