<?php

class Validation {

    public function validateLoginCredentials(LoginUser $user) {
        $this->usernameInputExists($user->getUsername());
        $this->passwordInputExists($user->getPassword());
        $this->isUsernameCorrectFormat($user->getUsername());
    }

    public function validateRegisterInput(RegisterUser $user) {
        $this->checkLengthOfUsernamePassword($user->getUsername(), $user->getPassword());
        $this->isUsernameCorrectFormat($user->getUsername());
        $this->checkIfPasswordsMatch($user->getPassword(), $user->getPasswordRepeat());
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

    private function checkLengthOfUsernamePassword($username, $password) {
        if ((!$username || (strlen($username) < 3)) && (!$password || (strlen($password) < 6))) {
            throw new ShortUsernameAndPassword('"'.$username.'" and "'.$password.'" are to short');
        } elseif (!$password || (strlen($password) < 6)) {
            throw new ShortPassword('The password "'.$password.'" is to short');
        } elseif (!$username || (strlen($username) < 3)) {
            throw new ShortUsername('The password "'.$username.'" is to short');
        }
    }

    private function checkIfPasswordsMatch($password, $passwordRepeat) {
        if ($password != $passwordRepeat) {
            throw new PasswordsDoNotMatch('Password: "'.$password.'" do not match repeated password: "'.$passwordRepeat.'"');
        }
    }

}