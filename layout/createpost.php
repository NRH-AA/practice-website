<?php if (isset($_SESSION['createPost'])) { ?>
    <div id="createPost">
        <form action="createpost.php">

        <label for="title">Title</label> 
        <br><input id="title" class="loginForm loginInput createPostInput" type="text" name="title"><br>

        <label for="text">Text</label> 
        <br><textarea id="text" class="loginForm createPostTextArea" type="text" name="text" maxlength="500"></textarea><br><br>

        <input id="createPostButton" class="loginForm postsButton" type="submit" name="createPostButton" value="Create">
        <input id="backButton" class="loginForm postsButton" type="submit" name="backButton" value="Back">
        </form>
    </div>
<?php } ?>
