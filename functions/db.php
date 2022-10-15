<?php
	function connectDB() {
		$servername = "127.0.0.1";
		$username = "root";
		$password = "";
		$dbname = "myweb";
		$db = new mysqli($servername, $username, $password, $dbname);
		return $db;
	}
	
	function getBlackList($db) {
		$result = $db->query("SELECT ip FROM blacklist");
		$blacklist = array();
		if ($result->num_rows <= 0) { return false; }
		while($row = $result->fetch_assoc()) { 
			array_push($blacklist, $row["ip"]);
		}
		return $blacklist;
	}
	
	function login($db, $login, $password) {
		$result = $db->query("SELECT * FROM accounts WHERE login = '$login' AND password = '$password'");
		$accountArray = array();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$accountArray['id'] = $row['id'];
				$accountArray['username'] = $row['username'];
			}
		}
		return $accountArray;
	}

	function isUsernameTaken($db, $username) {
		$result = $db->query("SELECT username FROM accounts WHERE username = '$username'");
		$row = $result->fetch_assoc();
		$res = $row['username'];
		if (isset($res)) {
			return true;
		}
		return false;
	}

	function isEmailTaken($db, $email) {
		$result = $db->query("SELECT email FROM accounts WHERE email = '$email'");
		$row = $result->fetch_assoc();
		$res = $row['email'];
		if (isset($res)) {
			return true;
		}
		return false;
	}

	function createAccount($db, $login, $password, $username, $email) {
		$result = $db->query("INSERT INTO accounts (`login`, `password`, `username`, `email`, `serverid`) VALUES ('$login', '$password', '$username', '$email', 0)");
		if ($result === true) {
			return true;
		}
		return false;
	}
	
	function sanitize($input, $isEmail = false) {
		$arrayIllegal = array('select', 'delete', 'insert', 'update', 'script', 'echo', 'alert', 'prompt');
		foreach ($arrayIllegal as $str) {
			if (str_contains($input, $str)) {
				$input = str_replace($str, "", $input);
			}
		}

		if (!isset($isEmail)) {
			$input = preg_replace('/[^\p{L}\p{N}\s]/u', '', $input);
		}
		return $input;
	}
?>
