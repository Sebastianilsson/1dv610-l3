<?php

class Validation {
    public function validateLoginCredentials(LoginUser $user) {
        $this->usernameInputExists($user->getUsername());
        $this->passwordInputExists($user->getPassword());
        $this->isUsernameCorrectFormat($user->getUsername());
    }

    private function usernameInputExists($username) {
        if (!$username) {
            throw new MissingUsernameException('User did not provide a username');
        }
    }

    private function passwordInputExists($password) {
        if (!$password) {
            throw new MissingPasswordException('User did not provide a password');
        }
    }

    private function isUsernameCorrectFormat($username) {
        if (preg_match_all("/[^a-zA-Z0-9]/", $username) > 0) {
            throw new InvalidCharactersInUsername('Username "'.$username.'" is not valid');
        }
    }
}