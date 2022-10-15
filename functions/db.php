<?php
	// Database Connection
	function connectDB() {
		$servername = "127.0.0.1";
		$username = "root";
		$password = "";
		$con = new PDO("mysql:host=$servername;dbname=myweb", $username, $password);
		return $con;
	}
	
	// Fetch blacklist IP's from database
	function getBlackList($db) {
		$blacklist = array();
		$data = $db->query("SELECT ip FROM blacklist")->fetchAll();
		foreach ($data as $row) {
			array_push($blacklist, $row['ip']);
		}
		return $blacklist;
	}
	
	// Check if login is valid and assign username
	function login($db, $login, $password) {
		// PDO::PARAM_INT | PDO::PARAM_STR
		$statement = $db->prepare("SELECT username FROM accounts WHERE login = :loginBind AND password = :passwordBind");
		$statement->bindParam(':loginBind', $login, PDO::PARAM_STR);
		$statement->bindParam(':passwordBind', $password, PDO::PARAM_STR);
		$statement->execute();
		$user = $statement->fetch(PDO::FETCH_ASSOC);
		if ($user) {
			return $user['username'];
		}
		return false;
	}
	
	// Check if username input is taken (create account)
	function isUsernameTaken($db, $username) {
		$statement = $db->prepare("SELECT username FROM accounts WHERE username = :usernameBind");
		$statement->bindParam(':usernameBind', $username, PDO::PARAM_STR);
		$statement->execute();
		$user = $statement->fetch(PDO::FETCH_ASSOC);
		return $user;
	}
	
	// Check if email input is taken (create account)
	function isEmailTaken($db, $email) {
		$statement = $db->prepare("SELECT email FROM accounts WHERE email = :emailBind");
		$statement->bindParam(':emailBind', $email, PDO::PARAM_STR);
		$statement->execute();
		$user = $statement->fetch(PDO::FETCH_ASSOC);
		return $user;
	}
	
	// Create new user account
	function createAccount($db, $login, $password, $username, $email) {
		$statement = $db->prepare("INSERT INTO accounts (`login`, `password`, `username`, `email`, `serverid`) VALUES
													(:loginBind, :passwordBind, :usernameBind, :emailBind, 0)");
		$statement->bindParam(':loginBind', $login, PDO::PARAM_STR);
		$statement->bindParam(':passwordBind', $password, PDO::PARAM_STR);
		$statement->bindParam(':usernameBind', $username, PDO::PARAM_STR);
		$statement->bindParam(':emailBind', $email, PDO::PARAM_STR);
		if ($statement->execute()) {
			return true;
		}
		return false;
	}
	
	// Sanitize input data
	function sanitize($input, $ignoreSymbols = false) {
		$arrayIllegal = array('select', 'delete', 'insert', 'update', 'script', 'echo', 'alert', 'prompt');
		foreach ($arrayIllegal as $str) {
			if (str_contains($input, $str)) {
				$input = str_replace($str, "", $input);
			}
		}

		if (!$ignoreSymbols) {
			$input = preg_replace('/[^\p{L}\p{N}\s]/u', '', $input);
		}
		return $input;
	}
	
?>
