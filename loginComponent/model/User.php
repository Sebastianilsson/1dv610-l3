<?php

class User
{
    private $username = "";
    private $isLoggedIn = false;

    public function __construct(string $username, bool $isLoggedIn)
    {
        $this->username = $username;
        $this->isLoggedIn = $isLoggedIn;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getIsLoggedIn(): bool
    {
        return $this->isLoggedIn;
    }
}
