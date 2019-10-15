<?php

class LoginController {

    private $layoutView;
    private $loginView;
    private $databaseModel;
    private $sessionModel;
    private $loginModel;

    public function __construct($layoutView, $loginView, $databaseModel, $sessionModel) {
        $this->layoutView = $layoutView;
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
                $this->sessionModel->regenerateSessionId();
                $this->sessionModel->setSessionVariables($this->loginView->getUsername());
                $this->loginView->isLoggedIn();
                $this->loginModel->setWelcomeMessage($this->loginView->isKeepLoggedInRequested());
                if ($this->loginView->isKeepLoggedInRequested()) {
                    $cookieValues = $this->loginView->handleNewCookies();
                    $this->databaseModel->saveCookieCredentials($cookieValues);
                }
            }
        }
        $loginMessage = $this->loginModel->getLoginMessage();
        $this->loginView->setLoginMessage($loginMessage);
        $this->loginView->setUsernameValue($this->loginView->getUsername());
    }

    // Method called if the user already has a cookie from the site
    public function loginWithCookies() {
        if ($this->cookieIsValid()) {
            $this->loginView->isLoggedIn();
            $this->sessionModel->regenerateSessionId();
            if (!$this->sessionModel->isSessionSet()) {
                $this->sessionModel->setSessionVariables($this->loginView->getUsername());
                $this->loginView->setLoginMessage("Welcome back with cookie");
            }
            // $this->layoutView->render($this->loginView);
        } else {
            $this->loginView->destroyCookies();
            $this->loginView->setLoginMessage("Wrong information in cookies");
            // $this->layoutView->render($this->loginView);
        }
    }

    private function cookieIsValid() {
        return $this->databaseModel->cookiePasswordMatch($this->loginView->getCookieUsernameAndPassword());
    }

    // Method called if the user already has an active session from the site
    public function loginWithSession() {
        if ($this->sessionModel->sessionIsHijacked()) {
            // $this->layoutView->render($this->loginView);
        } else {
            $this->sessionModel->regenerateSessionId();
            $this->loginView->isLoggedIn();
            // $this->layoutView->render($this->loginView);
        }
    }

    // Method called if logout is requested
    public function logout() {
        if ($this->sessionModel->isSessionSet()) {
            $this->sessionModel->destroySession();
            $this->loginView->destroyCookies();
            $this->loginView->setLoginMessage("Bye bye!");
        }
        // $this->layoutView->render($this->loginView);
    }
}