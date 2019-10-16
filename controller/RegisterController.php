<?php

class RegisterController {

    private $loginView;
    private $databaseModel;
    private $registerView;
    private $registerModel;

    public function __construct($registerView, $loginView, $databaseModel) {
        $this->registerView = $registerView;
        $this->databaseModel = $databaseModel;
        $this->loginView = $loginView;
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
            header("Location: ?");
        } else {
            $registerErrorMessage = $this->registerModel->getRegistrationErrorMessage();
            $this->registerView->setUsernameValue(strip_tags($this->registerView->getUsername()));
            $this->registerView->setRegisterMessage($registerErrorMessage);
            // $this->layoutView->render($this->registerView);
        }
        
    }
}