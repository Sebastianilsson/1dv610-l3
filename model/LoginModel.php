<?php

class LoginModel {
    private $username;
    private $password;
    private $loginView;
    private $databaseModel;
    private $validationErrorMessage;

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
                } else {
                    // $this->loginView->setUsernameValue(strip_tags($this->username));
                    $this->validationErrorMessage = 'Username contains invalid characters.';
                }
            }
        }
    }

    public function checkIfCredentialsMatchInDatabase() {
        if ($this->databaseModel->usernameExistsInDatabase($this->username)) {
            if ($this->databaseModel->userPasswordMatch($this->username, $this->password)) {
                return true;
            }
        }
    }

    private function usernameInputExists() {
        if ($this->username != "") {
            return true;
        } else {
            $this->validationErrorMessage = 'Username is missing';
        }
    }

    private function passwordInputExists() {
        if ($this->password != "") {
            return true;
        } else {
            $this->validationErrorMessage = 'Password is missing';
        }
    }

    private function isUsernameCorrectFormat() {
        if (preg_match_all("/[^a-zA-Z0-9]/", $this->username) > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getValidationErrorMessage() {
        return $this->validationErrorMessage;
    }
}