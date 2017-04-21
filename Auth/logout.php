<?php
	session_start();
	//ini_set('display_startup_errors', 1);
	//ini_set('display_errors', 1);
	//error_reporting(-1);
	
	unset($_SESSION["username"]);
	unset($_SESSION["password"]);
	$_SESSION['loggedin'] = false;
	
	header('Refresh: 0; URL = ../home.php');
?>