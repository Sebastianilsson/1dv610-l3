<?php

class SessionModel {

    private $databaseModel;
    private $cookieUsername;
    private $cookiePassword;

    public function __construct($databaseModel) {
        $this->databaseModel = $databaseModel;
    }

    public function regenerateSessionId() {
        session_regenerate_id(true);
    }

    public function setSessionVariables() {
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['ip'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
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
        if (isset($_SESSION['isLoggedIn'])) {
            return true;
        } else {return false;}
    }

    public function isSessionHijacked() {
        if ($_SESSION['userAgent'] == $_SERVER['HTTP_USER_AGENT'] && $_SESSION['ip'] == $_SERVER['HTTP_X_FORWARDED_FOR']) {
            return false;
        } else { return true;}
    }
}