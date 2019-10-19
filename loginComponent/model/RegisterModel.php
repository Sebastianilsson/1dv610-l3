<?php

class RegisterModel {
    private $username;
    private $password;
    private $passwordRepeat;
    private $registerView;
    private $databaseModel;
    private $validationOk = false;
    private $registrationErrorMessage;

    public function __construct($registerView, $databaseModel) {
        $this->registerView = $registerView;
        $this->databaseModel = $databaseModel;
    }

    public function getUserRegistrationInput() {
        $this->username = $this->registerView->getUsername();
        $this->password = $this->registerView->getPassword();
        $this->passwordRepeat = $this->registerView->getRepeatedPassword();
    }

    public function validateRegisterInput() {
        $this->checkForInputInAllFields();
        $this->validateUsername();
        $this->validatePassword();
    }

    private function checkForInputInAllFields() {
        if (!$this->username && !$this->password) {
            throw new ShortUsernameAndPassword('"'.$this->username.'" and "'.$this->password.'" are to short');
        } elseif (!$this->password) {
            throw new ShortPassword('The password "'.$this->password.'" is to short');
        } elseif (!$this->username) {
            throw new ShortUsername('The password "'.$this->username.'" is to short');
        }
    }

    private function validateUsername() {
        $this->isUsernameCorrectFormat();
        $this->isUsernameLongEnough();
        $this->databaseModel->checkIfUsernameIsFree($this->username);
    }

    private function isUsernameLongEnough() {
        if (strlen($this->username) < 3) {
            throw new ShortUsername('The password "'.$this->username.'" is to short');
        }
    }

    private function isUsernameCorrectFormat() {
        if (preg_match_all("/[^a-zA-Z0-9]/", $this->username) > 0) {
            throw new InvalidCharactersInUsername('Username "'.$this->username.'" is not valid');
        }
    }

    private function validatePassword() {
        $this->isPasswordLongEnough();
        $this->checkIfPasswordsMatch();
    }

    private function isPasswordLongEnough() {
        if (strlen($this->password) < 6) {
            throw new ShortPassword('The password "'.$this->password.'" is to short');
        }
    }

    private function checkIfPasswordsMatch() {
        if ($this->password != $this->passwordRepeat) {
            throw new PasswordsDoNotMatch('Password: "'.$this->password.'" do not match repeated password: "'.$this->passwordRepeat.'"');
        }
    }

    public function isValidationOk() {
        return $this->validationOk;
    }

    public function getRegistrationErrorMessage() {
        return $this->registrationErrorMessage;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function saveUserToDatabase() {
        $this->databaseModel->saveUserToDatabase($this->username, $this->password);
    }
}