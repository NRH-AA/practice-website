<?php
    session_start();

	$locationArray = array('home');
	if (!isset($_SESSION['location']) or !in_array($_SESSION['location'], $locationArray)) {
		die("Cannot access page.");
	}

    include('functions/db.php');
    $db = connectDB();

	$_SESSION['location'] = 'login';

    $error;
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (isset($_POST['createAccountButton'])) {
			$_SESSION['createAccount'] = true;
			header('Location: home.php');
		}

		if (isset($_POST['loginSubmit'])) {
			$login = $_POST['login'];
			$password = $_POST['password'];
			if (!isset($login) or $login == "") {
				$error = "You must enter a login.<br>";
			}
			
			if (!isset($password) or $password == "") {
				$error = $error. "You must enter a password.";
			}
			
			if (!isset($error)) {
				$login = sanitize($login);
				$password = sanitize($password);
				$password = sha1($password);
				
				$account = login($db, $login, $password);
				
				if (!isset($account['id'])) {
					$error = "Invalid account.";
				} else {
					$_SESSION['id'] = $account['id'];
					$_SESSION['username'] = $account['username'];
				}
			}
		}

        if (isset($error)) {
            $_SESSION['error'] = $error;
        }
        
        header('Location: home.php');
	}

    $db->close();
?>
