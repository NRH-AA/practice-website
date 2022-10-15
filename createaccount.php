<?php
    session_start();

	$locationArray = array('home');
	if (!isset($_SESSION['location']) or !in_array($_SESSION['location'], $locationArray)) {
		die("Cannot access page.");
	}

    include('functions/db.php');
    $db = connectDB();

    $_SESSION['location'] = 'createAccount';

    $error;
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['backButton'])) {
            $_SESSION['createAccount'] = null;
            header('Location: home.php');
        }

		if (isset($_POST['createAccountButton'])) {
			$login = $_POST['login'];
			$password = $_POST['password'];
            $username = $_POST['username'];
            $email = $_POST['email'];

            if (!isset($login) or $login == "") {
				$error = "You must enter a login.<br>";
			}
			
			if (!isset($password) or $password == "") {
				$error = $error. "You must enter a password.<br>";
			}

            if (!isset($username) or $username == "") {
				$error = $error. "You must enter a username.<br>";
			}

            if (!isset($email) or $email == "") {
				$error = $error. "You must enter an email.<br>";
			}

            if (!isset($error)) {
				$login = sanitize($login);
				$password = sanitize($password, true);
                $password = sha1($password);
                $username = sanitize($username);
                $email = sanitize($email, true);

                if (isUsernameTaken($db, $username)) {
                    $error = "Username is taken. Try a different username.";
                } else {
                    if (isEmailTaken($db, $email)) {
                        $error = "Email is taken. Try a different email.";
                    } else {
                        $account = login($db, $login, $password);

                        if (isset($account['id'])) {
                            $error = "Invalid login. Try a different login.";
                        } else {
                            $createAccount = createAccount($db, $login, $password, $username, $email);
                            if (!$createAccount) {
                                $error = "Failed to create the account. Message support.";
                            } else {
                                $error = "Account created. You may now log in.";
                            }
                        }
                    }
                }
			}
		}

        if (isset($error)) {
            $_SESSION['error'] = $error;
        }
        
        header('Location: home.php');
	}

    $db = null;
?>
