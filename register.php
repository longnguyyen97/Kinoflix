<?php
require_once("includes/processForm/registerProcess.php");
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
                <h3>Sign Up</h3>
                <span>to continue to Kinoflix</span>
            </div>
            <form method="POST">
                <?php echo $account->getError(Constants::$firstNameCharacters);?>
                <input type="text" name="firstName" placeholder="First name" value= "<?php getInputValue("firstName"); ?>"required>
                <?php echo $account->getError(Constants::$lastNameCharacters);?>
                <input type="text" name="lastName" placeholder="Last name" value= "<?php getInputValue("lastName"); ?>"required>
                <?php echo $account->getError(Constants::$usernameCharacters);?>
                <?php echo $account->getError(Constants::$usernameTaken);?>
                <input type="text" name="username" placeholder="Username" value= "<?php getInputValue("username"); ?>"required>
                <?php echo $account->getError(Constants::$emailsDontMatch);?>
                <?php echo $account->getError(Constants::$emailInvalid);?>
                <?php echo $account->getError(Constants::$emailTaken);?>
                <input type="email" name="email" placeholder="Email" value= "<?php getInputValue("email"); ?>"required>

                <input type="email" name="email2" placeholder="Confirm Email" value= "<?php getInputValue("email2"); ?>"required>
                <?php echo $account->getError(Constants::$passwordsDontMatch);?>
                <?php echo $account->getError(Constants::$passwordLength);?>
                <input type="password" name="password" placeholder="Password" required>

                <input type="password" name="password2" placeholder="Confirm Password" required>
                
                <input type="submit" name="submitButton" value="Submit">
            </form>

            <a href="login.php" class="signInMessage">Already have an account? Sign in here!</a>

        </div>
    </div>
</body>

</html>