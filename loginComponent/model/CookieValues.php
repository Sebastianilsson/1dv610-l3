<?php

class CookieValues {
    private $cookieUsername;
    private $cookiePassword;

    public function __construct($cookieUsername, $cookiePassword) {
        $this->cookieUsername = $cookieUsername;
        $this->cookiePassword = $cookiePassword;
    }

    public function getCookieUsername() {
        return $this->cookieUsername;
    }

    public function getCookiePassword() {
        return $this->cookiePassword;
    }

}