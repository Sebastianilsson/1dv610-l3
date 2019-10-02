<?php

class RegisterController {

    private $layoutView;
    private $loginView;
    private $databaseModel;
    private $registerView;
    private $registerModel;

    public function __construct($layoutView, $registerView, $loginView, $databaseModel) {
        $this->registerView = $registerView;
        $this->databaseModel = $databaseModel;
        $this->loginView = $loginView;
        $this->layoutView = $layoutView;
        $this->registerModel = new RegisterModel($this->registerView, $this->databaseModel);
    }

    // Method called if registration of a new user is requested
    public function newRegistration() {
        $this->registerModel->getUserRegistrationInput();
        $this->registerView->setUsernameValue($this->registerView->getUsername());
        $this->registerModel->validateRegisterInputIfSubmitted();
        if ($this->registerModel->isValidationOk()) {
            $this->registerModel->hashPassword();
            $this->registerModel->saveUserToDatabase();
            $this->loginView->setUsernameValue($this->registerView->getUsername());
            $this->loginView->setLoginMessage("Registered new user.");
            $this->layoutView->render(false, $this->loginView);
        } else {
            $this->layoutView->render(false, $this->registerView);
        }
        
    }
}