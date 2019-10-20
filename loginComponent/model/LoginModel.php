<?php

class LoginModel {
    private $username;
    private $password;
    private $loginView;
    private $databaseModel;
    // private $loginMessage;

    public function __construct($loginView, $databaseModel) {
        $this->loginView = $loginView;
        $this->databaseModel = $databaseModel;
    }

    // public function getUserLoginInput() {
    //     $this->username = $this->loginView->getUsername();
    //     $this->password = $this->loginView->getPassword();
    // }

    public function validateLoginInput() {
        $this->usernameInputExists();
        $this->passwordInputExists();
        $this->isUsernameCorrectFormat();
    }

    public function checkIfCredentialsMatchInDatabase() {
        if (!$this->databaseModel->usernameExistsInDatabase($this->username) || !$this->databaseModel->userPasswordMatch($this->username, $this->password)) {
            throw new UsernameOrPasswordIsInvalid('Wrong username or password entered');
        }
    }

    private function usernameInputExists() {
        if (!$this->username) {
            throw new MissingUsernameException('User did not provide a username');
        }
    }

    private function passwordInputExists() {
        if (!$this->password) {
            throw new MissingPasswordException('User did not provide a password');
        }
    }

    private function isUsernameCorrectFormat() {
        if (preg_match_all("/[^a-zA-Z0-9]/", $this->username) > 0) {
            throw new InvalidCharactersInUsername('Username "'.$this->username.'" is not valid');
        }
    }
}