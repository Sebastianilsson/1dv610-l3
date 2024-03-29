<?php

class LoginController
{

    private $loginView;
    private $databaseModel;
    private $sessionModel;
    private $validation;

    public function __construct(LoginView $loginView, DatabaseModel $databaseModel, SessionModel $sessionModel)
    {
        $this->loginView = $loginView;
        $this->databaseModel = $databaseModel;
        $this->sessionModel = $sessionModel;
        $this->validation = new Validation();
    }
    // Method called if login was requested.
    public function newLogin()
    {
        try {
            $loginUser = $this->loginView->getLoginUser();
            $this->validation->validateLoginCredentials($loginUser);
            $this->databaseModel->checkIfCredentialsMatch($loginUser);
            $this->successfulNewLogin();
        } catch (MissingUsernameException $error) {
            $this->loginView->setLoginMessage(Messages::$usernameMissing);
        } catch (MissingPasswordException $error) {
            $this->loginView->setLoginMessage(Messages::$passwordMissing);
        } catch (InvalidCharactersInUsername $error) {
            $this->loginView->setLoginMessage(Messages::$invalidCharactersInUsername);
        } catch (UsernameOrPasswordIsInvalid $error) {
            $this->loginView->setLoginMessage(Messages::$wrongUsernameOrPassword);
        } finally {
            $this->loginView->setUsernameValue($this->loginView->getUsername());
        }
    }

    // Method called if the user already has a cookie from the site
    public function loginWithCookies()
    {
        try {
            $this->databaseModel->cookiePasswordMatch($this->loginView->getCookieUsernameAndPassword());
            $this->successfulCookieLogin();
        } catch (TamperedCookie $error) {
            $this->loginView->destroyCookies();
            $this->loginView->setLoginMessage(Messages::$tamperedCookie);
        }
    }

    // Method called if the user already has an active session from the site
    public function loginWithSession()
    {
        if ($this->sessionModel->sessionIsNotHijacked()) {
            $this->sessionModel->regenerateSessionId();
            $this->loginView->isLoggedIn();
        }
    }

    // Method called if logout is requested
    public function logout()
    {
        if ($this->sessionModel->isSessionSet()) {
            $this->sessionModel->destroySession();
            $this->loginView->destroyCookies();
            $this->loginView->setLoginMessage(Messages::$logoutBye);
        }
    }

    private function successfulNewLogin()
    {
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

    private function successfulCookieLogin()
    {
        $this->loginView->isLoggedIn();
        $this->sessionModel->regenerateSessionId();
        if (!$this->sessionModel->isSessionSet()) {
            $this->sessionModel->setSessionVariables($this->loginView->getCookieUsername());
            $this->loginView->setLoginMessage(Messages::$welcomeWithCookie);
        }
    }
}
