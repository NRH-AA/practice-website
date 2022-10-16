<?php
    session_start();

	$locationArray = array('home');
	if (!isset($_SESSION['location']) or !in_array($_SESSION['location'], $locationArray)) {
		die("Cannot access page.");
	}

    include('functions/db.php');
    $db = connectDB();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['createPostButton'])) {
            $username = $_SESSION['username'];
            // $date = date("m.d.y");
            $title = $_POST['title'];
            $text = $_POST['text'];
            
            if (!isset($title) or !isset($text)) {
                $_SESSION['error'] = "You must enter a title and add text to the text area.";
                $_SESSION['location'] = "home";
                header('Location: home.php');
            } else {
                $createPost = createPost($db, $username, $title, $text);
                if ($createPost) {
                    $_SESSION['createPost'] = null;
                    $_SESSION['error'] = "Your post has been created!";
                    $_SESSION['location'] = "home";
                    header('Location: home.php');
                } else {
                    $_SESSION['error'] = "Failed to create post.";
                    $_SESSION['location'] = "home";
                    header('Location: home.php');
                }
            }
        }
    }
    
    $db = null;
?>
