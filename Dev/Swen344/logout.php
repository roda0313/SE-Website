<?php
	session_start();
	$_SESSION['loggedin'] = false;
	unset($_SESSION['userInfo']);
	
	header( 'Location: http://vm344f.se.rit.edu/' ) ;
?>