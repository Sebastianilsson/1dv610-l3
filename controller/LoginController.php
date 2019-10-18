<?php

class LoginController {

    private $loginView;
    private $databaseModel;
    private $sessionModel;
    private $loginModel;

    public function __construct($loginView, $databaseModel, $sessionModel) {
        $this->loginView = $loginView;
        $this->databaseModel = $databaseModel;
        $this->sessionModel = $sessionModel;
        $this->loginModel = new LoginModel($this->loginView, $this->databaseModel);
    }
    // Method called if login was requested.
    public function newLogin() {
        $this->loginModel->getUserLoginInput();
        if ($this->loginModel->validateLoginInput()) {
            if ($this->loginModel->checkIfCredentialsMatchInDatabase()) {
                $this->successfulNewLogin();
            }
        }
        $this->loginView->setUsernameValue($this->loginView->getUsername());
    }

    // Method called if the user already has a cookie from the site
    public function loginWithCookies() {
        if ($this->cookieIsValid()) {
            $this->successfulCookieLogin();
        } else {
            $this->loginView->destroyCookies();
            $this->loginView->setLoginMessage(Messages::$tamperedCookie);
        }
    }

    private function cookieIsValid() {
        return $this->databaseModel->cookiePasswordMatch($this->loginView->getCookieUsernameAndPassword());
    }

    // Method called if the user already has an active session from the site
    public function loginWithSession() {
        if ($this->sessionModel->sessionIsNotHijacked()) {
            $this->sessionModel->regenerateSessionId();
            $this->loginView->isLoggedIn();
        }
    }

    // Method called if logout is requested
    public function logout() {
        if ($this->sessionModel->isSessionSet()) {
            $this->sessionModel->destroySession();
            $this->loginView->destroyCookies();
            $this->loginView->setLoginMessage(Messages::$logoutBye);
        }
    }

    private function successfulNewLogin() {
        $this->sessionModel->regenerateSessionId();
        $this->sessionModel->setSessionVariables($this->loginView->getUsername());
        $this->loginView->isLoggedIn();
        $this->loginView->setLoginMessage(Messages::$welcome);
        if ($this->loginView->isKeepLoggedInRequested()) {
            $cookieValues = $this->loginView->handleNewCookies();
            $this->databaseModel->saveCookieCredentials($cookieValues);
            $this->loginView->setLoginMessage(Messages::$welcomeWithRememberRequested);
        }
    }

    private function successfulCookieLogin() {
        $this->loginView->isLoggedIn();
        $this->sessionModel->regenerateSessionId();
        if (!$this->sessionModel->isSessionSet()) {
            $this->sessionModel->setSessionVariables($this->loginView->getCookieUsername());
            $this->loginView->setLoginMessage(Messages::$welcomeWithCookie);
        }
    }
}