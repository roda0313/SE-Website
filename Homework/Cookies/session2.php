<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<?php 
	switch($_SESSION['color'])
	{
		case "Red":
			echo '<body style="background-color:Red">';
			break;
		case 'Green':
			echo '<body style="background-color:Green">';
			break;
		case 'Blue':
			echo '<body style="background-color:Blue">';
			break;
		default :
			echo "<body>";
			break;
	}
	
// Read the sessions
if ($_SESSION["username"] != "") {
	echo "<h1>Hello ";
    echo $_SESSION["username"];
    echo "<h2> ";
}else{
?>

	You are not a valid user


	<?php
}
?>




</body>
</html>