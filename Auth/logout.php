<?php
	session_start();
	
	unset($_SESSION["username"]);
	unset($_SESSION["password"]);
	$_SESSION['loggedin'] = false;
	
	header('Refresh: 0; URL = ../home.php');
?>