<?php

class MainController {

    private $databaseModel;
    private $sessionModel;
    private $loginModel;

    private $registerView;
    private $albumView;
    private $layoutView;
    private $loginView;

    private $registerController;
    private $loginController;
    private $albumController;


    public function __construct() {
        $this->databaseModel = new DatabaseModel();
        $this->sessionModel = new SessionModel($this->databaseModel);
        $this->loginView = new LoginView();
        $this->albumView = new AlbumView();
        $this->layoutView = new LayoutView();
        $this->registerView = new RegisterView();
        $this->albumController = new AlbumController($this->layoutView, $this->loginView, $this->databaseModel, $this->albumView);
        $this->registerController = new RegisterController($this->layoutView, $this->registerView, $this->loginView, $this->databaseModel);
        $this->loginController = new LoginController($this->layoutView, $this->loginView, $this->databaseModel, $this->sessionModel);
    }
    // Routes the user through the application depending on user action
    public function setState() {
        if ($this->loginView->isLoggedOutRequested()) {
            $this->loginController->logout();
        } elseif ($this->registerView->isRegisterFormRequested()) {
            $this->registerController->newRegistration();
        }  elseif($this->loginView->userHasCookie()) {
            $this->loginController->loginWithCookies();
        } elseif ($this->sessionModel->userHasSession()) {
            $this->loginController->loginWithSession();
        } elseif ($this->loginView->isLoginFormSubmitted()) {
            $this->loginController->newLogin();
        } 
        if ($this->albumView->isAlbumRequested()) {
            $this->albumController->handleAlbumInteraction();
        }
    }

    public function renderState() {
        if ($this->albumView->isAlbumRequested()) {
            $this->layoutView->render($this->albumView);
        } elseif ($this->registerView->isRegisterFormRequested()) {
            $this->layoutView->render($this->registerView);
        } else {
            $this->layoutView->render($this->loginView);
        }
    }

}