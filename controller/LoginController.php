<?php

class LoginController {

    private $layoutView;
    private $loginView;
    private $databaseModel;
    private $sessionModel;
    private $loginModel;

    public function __construct($layoutView, $loginView, $databaseModel) {
        $this->layoutView = $layoutView;
        $this->loginView = $loginView;
        $this->databaseModel = $databaseModel;
        $this->sessionModel = new SessionModel($this->databaseModel);
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
                    $this->sessionModel->handleNewCookies($this->loginView->getUsername());
                    $this->loginView->setLoginMessage("Welcome and you will be remembered");
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
        if ($this->sessionModel->checkIfCookieIsValid()) {
            $this->loginView->setIsLoggedIn(true);
            $this->sessionModel->regenerateSessionId();
            if (!$this->sessionModel->isSessionSet()) {
                $this->sessionModel->setSessionVariables();
                $this->loginView->setLoginMessage("Welcome back with cookie");
            }
            $this->layoutView->render(true, $this->loginView);
        } else {
            $this->sessionModel->destroyCookies();
            $this->loginView->setLoginMessage("Wrong information in cookies");
            $this->layoutView->render(false, $this->loginView);
        }
    }

    // Method called if the user already has an active session from the site
    public function loginWithSession() {
        if (!$this->sessionModel->isSessionHijacked()) {
            $this->sessionModel->regenerateSessionId();
            $this->loginView->setIsLoggedIn(true);
            $this->layoutView->render(true, $this->loginView);
        } else {
            $this->layoutView->render(false, $this->loginView);
        }
    }

    // Method called if logout is requested
    public function logout() {
        if ($this->sessionModel->isSessionSet()) {
            $this->sessionModel->destroySessionAndCookies();
            $this->loginView->setLoginMessage("Bye bye!");
        }
        $this->layoutView->render(false, $this->loginView);
    }
}