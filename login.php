<?php
require_once("includes/processForm/loginProcess.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Kinoflix</title>
    <link rel="stylesheet" type="text/css" href="assets/style/style.css">
</head>

<body>
    <div class="signInContainer">
        <div class="column">
            <div class="header">
                <img src="assets/img/kinoflix_logo.png" title="Kinoflix" alt="Site logo"/>
                <h3>Sign In</h3>
                <span>to continue to Kinoflix</span>
            </div>
            <form method="POST">
                <?php echo $account->getError(Constants::$loginFailed);?>
                <input type="text" name="username" placeholder="Username" value= "<?php getInputValue("username"); ?>" required>

                <input type="password" name="password" placeholder="Password" required>
                
                <input type="submit" name="submitButton" value="Submit">
            </form>

            <a href="register.php" class="signInMessage">Don't have an account? Sign up here!</a>

        </div>
    </div>
</body>

</html>