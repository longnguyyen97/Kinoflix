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
            $this->validateFirstName($fn);
            $this->validateLastName($ln);
            $this->validateUsername($un);
            $this->validateEmails($em, $em2);
            $this->validatePassword($pw, $pw2);
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
    }
?>