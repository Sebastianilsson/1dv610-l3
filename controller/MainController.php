<?php

class MainController {

    private $layoutView;
    private $loginView;
    private $databaseModel;
    private $sessionModel;
    private $loginModel;
    private $dateTimeView;
    private $registerView;
    private $registerController;
    private $loginController;


    public function __construct() {
        $this->databaseModel = new DatabaseModel();
        $this->loginView = new LoginView();
        $this->dateTimeView = new DateTimeView();
        $this->layoutView = new LayoutView($this->dateTimeView);
        $this->registerView = new RegisterView();
        $this->registerController = new RegisterController($this->layoutView, $this->registerView, $this->loginView, $this->databaseModel);
        $this->loginController = new LoginController($this->layoutView, $this->loginView, $this->databaseModel);
    }
    // Routes the user through the application depending on user action
    public function router() {
        if ($this->loginView->isLoggedOutRequested()) {
            $this->loginController->logout();
        } elseif ($this->registerView->isRegisterFormRequested()) {
            $this->registerController->newRegistration();
        } elseif(isset($_COOKIE['LoginView::CookieName'])) {
            $this->loginController->loginWithCookies();
        } elseif (isset($_SESSION['isLoggedIn'])) {
            $this->loginController->loginWithSession();
        } elseif ($this->loginView->isLoginFormSubmitted()) {
            $this->loginController->newLogin();
        } else {
            $this->layoutView->render(false, $this->loginView);
        }
    }

}