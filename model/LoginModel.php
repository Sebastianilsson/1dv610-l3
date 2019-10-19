<?php

class LoginModel {
    private $username;
    private $password;
    private $loginView;
    private $databaseModel;
    private $loginMessage;

    public function __construct($loginView, $databaseModel) {
        $this->loginView = $loginView;
        $this->databaseModel = $databaseModel;
    }

    public function getUserLoginInput() {
        $this->username = $this->loginView->getUsername();
        $this->password = $this->loginView->getPassword();
    }

    public function validateLoginInput() {
        if ($this->usernameInputExists()) {
            if ($this->passwordInputExists()) {
                if ($this->isUsernameCorrectFormat()) {
                    return true;
                }
            }
        }
    }

    public function checkIfCredentialsMatchInDatabase() {
        if ($this->databaseModel->usernameExistsInDatabase($this->username) && $this->databaseModel->userPasswordMatch($this->username, $this->password)) {
            return true;
        } else {
            $this->loginMessage = "Wrong name or password";
        }
    }

    // public function setWelcomeMessage($keepLoginRequested) {
    //     if ($keepLoginRequested) {
    //         $this->loginMessage = "Welcome and you will be remembered";
    //     } else {
    //         $this->loginMessage = "Welcome";
    //     }
    // }

    private function usernameInputExists() {
        if ($this->username) {
            return true;
        } else {
            throw new MissingUsernameException('User did not provide a username');
        }
    }

    private function passwordInputExists() {
        if ($this->password != "") {
            return true;
        } else {
            throw new MissingPasswordException('User did not provide a password');
        }
    }

    private function isUsernameCorrectFormat() {
        if (preg_match_all("/[^a-zA-Z0-9]/", $this->username) > 0) {
            throw new InvalidCharactersInUsername('Username "'.$this->username.'" is not valid');
            $this->loginMessage = 'Username contains invalid characters.';
            return false;
        } else {
            return true;
        }
    }

    public function getLoginMessage() {
        return $this->loginMessage;
    }
}