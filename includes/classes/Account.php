<?php
class Account
{
    private $conn;
    private $errorArray = array();

    public function __construct($conn)
    {
         $this->conn = $conn;
    }

    public function register($fn, $ln, $un, $em, $em2, $pw, $pw2)
    {
        // runs every input variable into it equal validating process
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateUsername($un);
        $this->validateEmails($em, $em2);
        $this->validatePassword($pw, $pw2);
        //if there are no error when register, run every variables into insertUserDetails()
        if(empty($this->errorArray))
        {
            return $this->insertUserDetails($fn, $ln, $un, $em, $pw);  
        }
        // if there were errors, return to validating
        return false;
        }
    public function login($un, $pw)
    {
        $pw = hash("sha512", $pw);
        $query = $this->conn->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");
        $query->bindValue(":un", $un);
        $query->bindValue(":pw", $pw);
        $query->execute();
        if($query->rowCount() == 1)
        {
            return true;
        }
        array_push($this->errorArray, Constants::$loginFailed);
        return false;
        }
    private function insertUserDetails($fn, $ln, $un, $em, $pw)
    {
        $pw = hash("sha512", $pw); //hash the password and store it into $pw
        $query = $this->conn->prepare("INSERT INTO users (firstName, lastName, username, email, password) 
                                            VALUES (:fn, :ln, :un, :em, :pw)");
        $query->bindValue(":fn", $fn);
        $query->bindValue(":ln", $ln);
        $query->bindValue(":un", $un);
        $query->bindValue(":em", $em);
        $query->bindValue(":pw", $pw);
        return $query->execute();
    }

    private function validateFirstName($fn)
    {
        if(strlen($fn) < 2 || strlen($fn) > 25) //check the length of the first name
        {
            //push this string into the $errorArray
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }
    }

    private function validateLastName($ln)
    {
        if(strlen($ln) < 2 || strlen($ln) > 25) //check the length of the last name
        {
            //push this string into the $errorArray
            array_push($this->errorArray, Constants::$lastNameCharacters);
        }
    }

    private function validateUsername($un)
    {
        if(strlen($un) < 2 || strlen($un) > 15) //check the length of the username
        {
            //push this string into the $errorArray
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }
        $query = $this->conn->prepare("SELECT * FROM users WHERE username=:un");
        $query->bindValue(":un", $un);
        $query->execute();
        if($query->rowCount() !=0)
        {
            array_push($this->errorArray, Constants::$usernameTaken);
        }
    }
    private function validateEmails($em, $em2)
    {
        if($em != $em2)
        {
            array_push($this->errorArray, Constants::$emailsDontMatch);
            return;
        }
        if(!filter_var($em, FILTER_VALIDATE_EMAIL))// filter_var will perfom a filter on a value that parsed in 
        {
            array_push($this->errorArray, Constants::$emailInvalid);
        }
        $query = $this->conn->prepare("SELECT * FROM users WHERE email=:em");
        $query->bindValue(":em", $em);
        $query->execute();

        if($query->rowCount() !=0)
        {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }
    private function validatePassword($pw, $pw2)
    {
        if($pw != $pw2)
        {
            array_push($this->errorArray, Constants::$passwordsDontMatch);
            return;
        }
        if(strlen($pw) < 6) //check the length of the password
        {
            //push this constant into the $errorArray
            array_push($this->errorArray, Constants::$passwordLength);
            return;
        }
    }

    public function getError($error)
    {
        if(in_array($error, $this->errorArray)) //check if $error is in the $errorArray
        {
            return "<span class='errorMessage'>$error</span>";
        }
    }

    private function validateNewEmail($em, $un)
    {
        if(!filter_var($em, FILTER_VALIDATE_EMAIL))// filter_var will perfom a filter on a value that parsed in 
        {
            array_push($this->errorArray, Constants::$emailInvalid);
        }
        $query = $this->conn->prepare("SELECT * FROM users WHERE email=:em AND username != :un");
        $query->bindValue(":em", $em);
        $query->bindValue(":un", $un);

        $query->execute();

        if($query->rowCount() !=0)
        {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    public function updateDetails($fn, $ln, $em, $un)
    {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateNewEmail($em,$un);

        if(empty($this->errorArray))
        {
            $query = $this->conn->prepare("UPDATE users SET firstName=:fn, lastName=:ln,
            email=:em WHERE username=:un");

            $query->bindValue(":fn", $fn);
            $query->bindValue(":ln", $ln);
            $query->bindValue(":em", $em);
            $query->bindValue(":un", $un);

            return $query->execute();
        }
        return false;
    }

    public function getFirstError()
    {
        if(!empty($this->errorArray))
        {
            return $this->errorArray[0];
        }
    }

    public function updatePassword($oldPw, $pw, $pw2, $un)
    {
        $this->validateOldPassword($oldPw, $un);
        $this->validatePassword($pw, $pw2);

        if(empty($this->errorArray))
        {
            $query = $this->conn->prepare("UPDATE users SET password=:pw WHERE username=:un");

            $pw = hash("sha512", $pw);
            $query->bindValue(":pw", $pw);
            $query->bindValue(":un", $un);

            return $query->execute();
        }
        return false;
    }

    public function validateOldPassword($oldPw, $un)
    {
        $pw = hash("sha512", $oldPw);

        $query = $this->conn->prepare("SELECT * FROM users WHERE username=:un AND password=:pw");
        $query->bindValue(":un", $un);
        $query->bindValue(":pw", $pw);
        $query->execute();

        if($query->rowCount() == 0)
        {
            array_push($this->errorArray, Constants::$passwordIncorrect);
        }
    }

}
?>