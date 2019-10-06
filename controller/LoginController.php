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
        $this->loginModel = new LoginModel($this->layoutView, $this->loginView, $this->databaseModel);
    }
    // Method called if login was requested.
    public function newLogin() {
        $this->loginModel->getUserLoginInput();
        if ($this->loginModel->validateLoginInput()) {
            if ($this->loginModel->checkIfCredentialsMatchInDatabase()) {
                $this->sessionModel->regenerateSessionId();
                $this->sessionModel->setSessionVariables();
                $this->loginView->setIsLoggedIn(true);
                if ($this->loginView->isKeepLoggedInRequested()) {
                    $cookieValues = $this->loginView->handleNewCookies();
                    $this->databaseModel->saveCookieCredentials($cookieValues);
                } else {
                    $this->loginView->setLoginMessage("Welcome");
                }
                $this->layoutView->render(true, $this->loginView);
                return;
            } else {
                $this->loginView->setLoginMessage("Wrong name or password");
            }
        } 
        $this->loginView->setUsernameValue($this->loginView->getUsername());
        $this->layoutView->render(false, $this->loginView);
    }

    // Method called if the user already has a cookie from the site
    public function loginWithCookies() {
        if ($this->cookieIsValid()) {
            $this->loginView->setIsLoggedIn(true);
            $this->sessionModel->regenerateSessionId();
            if (!$this->sessionModel->isSessionSet()) {
                $this->sessionModel->setSessionVariables();
                $this->loginView->setLoginMessage("Welcome back with cookie");
            }
            $this->layoutView->render(true, $this->loginView);
        } else {
            $this->loginView->destroyCookies();
            $this->loginView->setLoginMessage("Wrong information in cookies");
            $this->layoutView->render(false, $this->loginView);
        }
    }

    private function cookieIsValid() {
        return $this->databaseModel->cookiePasswordMatch($this->loginView->getCookiePassword());
    }

    // Method called if the user already has an active session from the site
    public function loginWithSession() {
        if ($this->sessionModel->sessionIsHijacked()) {
            $this->layoutView->render(false, $this->loginView);
        } else {
            $this->sessionModel->regenerateSessionId();
            $this->loginView->setIsLoggedIn(true);
            $this->layoutView->render(true, $this->loginView);
        }
    }

    // Method called if logout is requested
    public function logout() {
        if ($this->sessionModel->isSessionSet()) {
            $this->sessionModel->destroySession();
            $this->loginView->destroyCookies();
            $this->loginView->setLoginMessage("Bye bye!");
        }
        $this->layoutView->render(false, $this->loginView);
    }
}