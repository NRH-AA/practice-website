<?php
	// Clear any sessions start a new one
	session_start();
	session_destroy();
	session_start();

	// Include our database functions
	include('functions/db.php');
	
	//Connect to database: /functions/db.php
	$db = connectDB();

	// Get blacklisted IP's from the database
	$blacklist = getBlackList($db);
	
	// If client has a blacklisted IP
	$clientIP = $_SERVER['REMOTE_ADDR'];
	foreach ($blacklist as $ip) {
		if ($clientIP == $ip) {
			die("You are blacklisted.");
		}
	}

	// Check if IP was set. If not do not allow access to the website
	if (!isset($clientIP)) {
		die("Could not connect your IP.");
	}

	// Close database connection
	$db = null;
	
	// Set client location. Used to allow access to the rest of the website.
	$_SESSION['location'] = 'index';

	// Start a timer to disconnect client from session.
	$_SESSION['timeout'] = time();

	// Send client to home.php
	header('Location: home.php');
?>
