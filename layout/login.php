                    <?php if (!isset($_SESSION['username'])) { ?>
                    <?php if (!isset($_SESSION['createAccount'])) { ?>
                    <form id="loginForm" action="login.php" method="post">
						<div>
							<label for="login">Login</label>
							<input id="login" class="loginForm loginInput" type="text" name="login">
						</div>
						
						<div>
							<label for="password">Password</label> 
							<input id="password" class="loginForm loginInput" type="password" name="password">
						</div>
						
						<div>
							<input id="loginButton" class="loginForm" type="submit" name="loginSubmit" value="login">
							<input id="createAccountButton" class="loginForm createAccountButton" type="submit" name="createAccountButton" value="Create Account">
						</div>
                    </form>
                    <?php } else { ?>
                        <form id="loginForm" action="createaccount.php" method="post">
                            <label for="login">Login</label> 
                            <br><input id="login" class="loginForm loginInput" type="text" name="login" maxlength="20"><br>

                            <label for="password">Password</label> 
                            <br><input id="password" class="loginForm loginInput" type="password" name="password" maxlength="20"><br>

                            <label for="username">Username</label> 
                            <br><input id="username" class="loginForm loginInput" type="text" name="username" maxlength="20"><br>

                            <label for="email">Email</label> 
                            <br><input id="email" class="loginForm loginInput" type="email" name="email" maxlength="35"><br>

                            <input id="createAccountButton" class="loginForm createAccountButton createAccountButtonTwo" type="submit" name="createAccountButton" value="Create">
                            <input id="backButton" class="loginForm backButton" type="submit" name="backButton" value="Back">
                        </form>
                    <?php }} else { ?>
                        <form id="loginForm" action="home.php" method="post">
                            <p id="loginP"> <?php echo 'Welcome, ' . $_SESSION['username']; ?> </p>
                            <a href="posts.php"><input id="myPostsButton" class="loginForm postsButton" type="submit" name="myPostsButton" value="My Posts"></a>
                            <a href="posts.php"><input id="createPostButton" class="loginForm postsButton" type="submit" name="createPostButton" value="Create Post"></a>
                        </form>
                    <?php } ?>
