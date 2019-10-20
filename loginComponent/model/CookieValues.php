<?php

class CookieValues
{
    private $cookieUsername;
    private $cookiePassword;

    public function __construct(string $cookieUsername, string $cookiePassword)
    {
        $this->cookieUsername = $cookieUsername;
        $this->cookiePassword = $cookiePassword;
    }

    public function getCookieUsername(): string
    {
        return $this->cookieUsername;
    }

    public function getCookiePassword(): string
    {
        return $this->cookiePassword;
    }
}
