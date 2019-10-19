<?php

class User {
    private $username = "";
    private $isLoggedIn = false;

    public function __construct($username, $isLoggedIn) {
        $this->username = $username;
        $this->isLoggedIn = $isLoggedIn;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getIsLoggedIn() {
        return $this->isLoggedIn;
    }
}