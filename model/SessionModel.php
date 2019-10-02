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

    public function setSessionVariables() {
        $_SESSION[self::$isLoggedIn] = true;
        $_SESSION[self::$userAgent] = getenv(self::$httpUserAgent);
        $_SESSION[self::$clientIp] = getenv(self::$httpXForwardedFor);
    }

    public function userHasSession() {
        return isset($_SESSION[self::$isLoggedIn]);
    }

    public function handleNewCookies($username) {
        $this->cookieUsername = $username;
        $this->cookiePassword = $this->generateRandomString();
        $this->setCookies();
        $this->databaseModel->removeOldSessionIfExisting($this->cookieUsername);
        $this->saveCookiesToDatabase();
    }

    private function setCookies() {
        setcookie('LoginView::CookieName', $this->cookieUsername, time()+3600);
		setcookie('LoginView::CookiePassword', $this->cookiePassword, time()+3600);
    }

    private function saveCookiesToDatabase() {
        $this->databaseModel->saveCookieToDatabase($this->cookieUsername, $this->cookiePassword);
    }

    private function generateRandomString() {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$lengthOfPassword = 20;
    	$cookiePassword = '';
    	for ($index = 0; $index < $lengthOfPassword; $index++) {
        	$cookiePassword .= $characters[rand(0, $charactersLength - 1)];
		}
		return $cookiePassword;
    }
    
    public function checkIfCookieIsValid() {
        if ($this->databaseModel->cookiePasswordMatch()) {
            return true;
        }
    }

    public function destroySessionAndCookies() {
        session_unset();
        session_destroy();
        $this->destroyCookies();
    }

    public function destroyCookies() {
        setcookie ("LoginView::CookieName", "", time() - 3600);
        setcookie ("LoginView::CookiePassword", "", time() - 3600);
    }

    public function isSessionSet() {
        if (isset($_SESSION[self::$isLoggedIn])) {
            return true;
        } else {return false;}
    }

    public function isSessionHijacked() {
        if ($_SESSION[self::$userAgent] == getenv(self::$httpUserAgent) && $_SESSION[self::$clientIp] == getenv(self::$httpXForwardedFor)) {
            return false;
        } else { return true;}
    }
}