<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");
    $account = new Account($conn);
    if(isset($_POST["submitButton"]))
    {
        $userName = FormSanitizer::sanitizeFormUsername($_POST["username"]);
        $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);

        $success = $account->login($userName, $password);
        // if the insertion is success, register will hit the if block below
        if($success)
        {
            $_SESSION["userLoggedIn"] = $username;
            header("Location: index.php");
        }
    }

    function getInputValue($name)
    {
        if(isset($_POST[$name]))
        {
            echo $_POST[$name];
        }
    }

?>