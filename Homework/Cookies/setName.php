<?php
// Start the session
session_start();

$_SESSION['name'] = $_GET['firstname'];

header("Location: session1.php");
?>