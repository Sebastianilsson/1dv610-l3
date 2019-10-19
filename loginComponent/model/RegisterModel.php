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

    public function validateRegisterInputIfSubmitted() {
        if ($this->registerView->isRegisterFormSubmitted()) {
            if ($this->checkForInputInAllFields()) {
                if ($this->validateUsername()) {
                    if ($this->validatePassword()) {
                        $this->validationOk = true;
                    }
                }
            }
        }
    }

    private function checkForInputInAllFields() {
        $message = '';
        if ($this->username == "") {
            $message .= 'Username has too few characters, at least 3 characters.';
        } 
        if ($this->password == "") {
            $message .= $message == "" ? 'Password has too few characters, at least 6 characters.' : '<br> Password has too few characters, at least 6 characters.';
        } 
        if ($message == '') {
            return true;
        }
        $this->registrationErrorMessage = $message;
    }

    private function validateUsername() {
        if ($this->isUsernameCorrectFormat()) {
            if (strlen($this->username) >= 3) {
                if ($this->isUsernameUnique()) {
                    return true;
                } else {
                    $this->registrationErrorMessage = 'User exists, pick another username.';
                }
            } else {
                $this->registrationErrorMessage = 'Username has too few characters, at least 3 characters.';
            }
        } else {
            $this->registrationErrorMessage = 'Username contains invalid characters.';
        }
    }

    private function isUsernameUnique() {
        return $this->databaseModel->checkIfUsernameIsFree($this->username);
    }

    private function isUsernameCorrectFormat() {
        if (preg_match_all("/[^a-zA-Z0-9]/", $this->username) > 0) {
            return false;
        } else {
            return true;
        }
    }

    private function validatePassword() {
        if (strlen($this->password) >= 6) {
            if ($this->checkIfPasswordsMatch()) {
                return true;
            } else {
                $this->registrationErrorMessage = 'Passwords do not match.';
            }
        } else {
            $this->registrationErrorMessage = 'Password has too few characters, at least 6 characters.';
        }
    }

    private function checkIfPasswordsMatch() {
        if ($this->password == $this->passwordRepeat) {
            return true;
        } else {
            return false;
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