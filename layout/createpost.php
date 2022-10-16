<?php
    include('functions/db.php');
    $db = connectDB();
?>

<?php if (isset($_SESSION['createPost'])) { ?>
    <div id="createPost">
        <form action="createpost.php" method="post">

        <label for="title">Title</label> 
        <br><input id="title" class="loginForm loginInput createPostInput" type="text" name="title"><br>

        <label for="text">Text</label> 
        <br><textarea id="text" class="loginForm createPostTextArea" type="text" name="text" maxlength="500"></textarea><br><br>

        <input id="createPostButton" class="loginForm postsButton" type="submit" name="createPostButton" value="Create">
        <input id="backButton" class="loginForm postsButton" type="submit" name="backButton" value="Back">
        </form>
    </div>
<?php } else { ?>
    <div id="showPosts">
		<?php
			$posts = getRecentPosts($db);
            foreach ($posts as $post) {
                ?>
                <div id="postDiv">
                    <tr>
                        <th><a href='home.php'><h4><?php echo $post['title']; ?></h4></a></th>
                    </tr>
                    <tr>
                        <td><?php echo $post['text']; ?></td>
                    </tr>
                </div>
        <?php } ?>
	</div>

<?php } ?>

<?php
    $db = null; 
?>
