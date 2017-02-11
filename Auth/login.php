<?php 
session_start();

if($_POST['username'] == "test" & $_POST['password'] == "test")
{
	$_SESSION['valid'] = true;
	$_SESSION['timeout'] = time();
	$_SESSION['username'] = 'test';
	$_SESSION['loggedin'] = true;
	
	header('Refresh: 0; URL = ../home.php');
}
else
{
	header('Refresh: 0; URL = ../home.php');
}
	
?>