<?php
	// Start session needed for any pages that use: $_SESSION
	session_start();
	
	// Only allow clients to navigate the website through the website
	$locationArray = array('index', 'login', 'createAccount', 'home');
	if (!isset($_SESSION['location']) or !in_array($_SESSION['location'], $locationArray)) {
		die("Cannot access page.");
	}

	// Set our location on the website
	$_SESSION['location'] = 'home';
	
	// Destroy client sessions that have been inactive for too long
	$timeout = $_SESSION['timeout'];
	$timeDiff = time() - $timeout;
	if (!isset($timeout) or $timeDiff > 1800) {
		session_destroy();
		echo "<a href='index.php'>Click here</a><br>";
		die("Your session has expired.");
	} else {
		$_SESSION['timeout'] = time();
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (isset($_POST['createPostButton'])) {
			$_SESSION['createPost'] = true;
		}
	}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="layout/style.css">
		<title>Home</title>
	</head>

	<body>
		<div id="container">
			<div id="error">
				<?php if (isset($_SESSION['error'])) { echo $_SESSION['error']; $_SESSION['error'] = null; } ?>
			</div>

			<div id="menu">

			</div>

			<div id="left">
				<?php include('layout/login.php'); ?>

			</div>

			<div id="center">
				<?php include('layout/createpost.php'); ?>
			</div>
		</div>
	</body>
</html>
