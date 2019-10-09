<?php

class SessionModel {

    private $databaseModel;
    private $cookieUsername;
    private $cookiePassword;
    private static $isLoggedIn = 'SessionModel::IsLoggedIn';
    private static $userAgent = 'SessionModel::UserAgent';
    private static $clientIp = 'SessionModel::ClientIp';
    private static $httpUserAgent = 'HTTP_USER_AGENT';
    private static $httpXForwardedFor = 'HTTP_X_FORWARDED_FOR';

    public function __construct($databaseModel) {
        $this->databaseModel = $databaseModel;
    }

    public function regenerateSessionId() {
        session_regenerate_id(true);
    }

    public function setSessionVariables($username) {
        $_SESSION[self::$isLoggedIn] = true;
        $_SESSION['username'] = $username;
        $_SESSION[self::$userAgent] = getenv(self::$httpUserAgent);
        $_SESSION[self::$clientIp] = getenv(self::$httpXForwardedFor);
    }

    public function userHasSession() {
        return isset($_SESSION[self::$isLoggedIn]);
    }
    
    public function checkIfCookieIsValid() {
        if ($this->databaseModel->cookiePasswordMatch()) {
            return true;
        }
    }

    public function destroySession() {
        session_unset();
        session_destroy();
    }

    public function isSessionSet() {
        if (isset($_SESSION[self::$isLoggedIn])) {
            return true;
        } else {return false;}
    }

    public function sessionIsHijacked() {
        if ($_SESSION[self::$userAgent] == getenv(self::$httpUserAgent) && $_SESSION[self::$clientIp] == getenv(self::$httpXForwardedFor)) {
            return false;
        } else { return true;}
    }
}