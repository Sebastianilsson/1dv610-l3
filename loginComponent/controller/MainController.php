<?php

class MainController {

    private $databaseModel;
    private $sessionModel;

    private $registerView;
    private $billboardView;
    private $layoutView;
    private $loginView;

    private $registerController;
    private $loginController;
    private $billboardController;


    public function __construct() {
        $this->databaseModel = new DatabaseModel();
        $this->sessionModel = new SessionModel($this->databaseModel);

        $this->loginView = new LoginView();
        $this->layoutView = new LayoutView();
        $this->registerView = new RegisterView();
        
        $this->registerController = new RegisterController($this->registerView, $this->loginView, $this->databaseModel);
        $this->loginController = new LoginController($this->loginView, $this->databaseModel, $this->sessionModel);
    }
    // Routes the user through the application depending on user action
    public function setState() {
            if ($this->loginView->isLoggedOutRequested()) {
                $this->loginController->logout();
            } elseif ($this->registerView->isRegisterFormSubmitted()) {
                $this->registerController->newRegistration();
            } elseif($this->loginView->userHasCookie()) {
                $this->loginController->loginWithCookies();
            } elseif ($this->sessionModel->userHasSession()) {
                $this->loginController->loginWithSession();
            } elseif ($this->loginView->isLoginFormSubmitted()) {
                $this->loginController->newLogin();
            } 
    }

    public function renderState() {
        if ($this->registerView->isRegisterFormRequested()) {
            $this->layoutView->render($this->registerView);
        } else {
            $this->layoutView->render($this->loginView);
        }
    }

    public function getUser() {
        if ($this->loginView->getIsLoggedIn()) {
            return new User($this->sessionModel->getSessionUsername(), $this->loginView->getIsLoggedIn());
        } else {
            return new User("", false);
        }
    }

}