<?php

class RegisterController {

    private $loginView;
    private $databaseModel;
    private $registerView;
    private $validation;

    public function __construct($registerView, $loginView, $databaseModel) {
        $this->registerView = $registerView;
        $this->databaseModel = $databaseModel;
        $this->loginView = $loginView;
        $this->validation = new Validation();
    }

    // Method called if registration of a new user is requested
    public function newRegistration() {
        try {
            $registerUser = $this->registerView->getUserRegistration();
            $this->validation->validateRegisterInput($registerUser);
            $this->databaseModel->checkIfUsernameIsFree($registerUser->getUsername());
            $registerUser->hashPassword();
            $this->databaseModel->saveUserToDatabase($registerUser);
            header("Location: ?");
        } catch (ShortUsernameAndPassword $error) {
            $this->registerView->setRegisterMessage(Messages::$toShortUsernameAndPassword);
        } catch (ShortPassword $error) {
            $this->registerView->setRegisterMessage(Messages::$toShortPassword);
        } catch (ShortUsername $error) {
            $this->registerView->setRegisterMessage(Messages::$toShortUsername);
        } catch (UsernameAlreadyExists $error) {
            $this->registerView->setRegisterMessage(Messages::$userAlreadyExists);
        } catch (InvalidCharactersInUsername $error) {
            $this->registerView->setRegisterMessage(Messages::$invalidCharactersInUsername);
        } catch (PasswordsDoNotMatch $error) {
            $this->registerView->setRegisterMessage(Messages::$passwordsDoNotMatch);
        } finally {
            $this->registerView->setUsernameValue(strip_tags($this->registerView->getUsername()));
        }
        
    }
}