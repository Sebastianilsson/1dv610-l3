<?php

class SessionModel
{

    private static $isLoggedIn = 'SessionModel::IsLoggedIn';
    private static $username = 'SessionModel::Username';
    private static $userAgent = 'SessionModel::UserAgent';
    private static $clientIp = 'SessionModel::ClientIp';
    private static $httpUserAgent = 'HTTP_USER_AGENT';
    private static $httpXForwardedFor = 'HTTP_X_FORWARDED_FOR';

    private static $doRegenerate = true;
    private static $userIsLoggedIn = true;

    public function regenerateSessionId()
    {
        session_regenerate_id(self::$doRegenerate);
    }

    public function setSessionVariables(string $username)
    {
        $_SESSION[self::$isLoggedIn] = self::$userIsLoggedIn;
        $_SESSION[self::$username] = $username;
        $_SESSION[self::$userAgent] = getenv(self::$httpUserAgent);
        $_SESSION[self::$clientIp] = getenv(self::$httpXForwardedFor);
    }

    public function userHasSession(): bool
    {
        return isset($_SESSION[self::$isLoggedIn]);
    }


    public function destroySession()
    {
        session_unset();
        session_destroy();
    }

    public function isSessionSet(): bool
    {
        return isset($_SESSION[self::$isLoggedIn]);
    }

    public function sessionIsNotHijacked(): bool
    {
        return ($_SESSION[self::$userAgent] == getenv(self::$httpUserAgent) &&
            $_SESSION[self::$clientIp] == getenv(self::$httpXForwardedFor));
    }

    public function getSessionUsername(): string
    {
        return $_SESSION[self::$username];
    }
}
