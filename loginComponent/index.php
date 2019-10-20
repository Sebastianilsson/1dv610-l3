<?php

//DO NOT ALTER!
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('view/Messages.php');

require_once('controller/MainController.php');
require_once('controller/RegisterController.php');
require_once('controller/LoginController.php');

require_once('model/DatabaseModel.php');
require_once('model/Validation.php');
// require_once('model/RegisterModel.php');
// require_once('model/LoginModel.php');
require_once('model/SessionModel.php');
require_once('model/CookieValues.php');
require_once('model/LoginUser.php');
require_once('model/RegisterUser.php');
require_once('model/User.php');
require_once('model/Exceptions.php');

require_once(''.__DIR__.'/../Settings.php');


class LoginComponent {

    private $componentController;

    public function __construct() {
        $this->componentController = new MainController();
    }

    public function render() {
        $this->componentController->setState();
        $this->componentController->renderState();
    }

    public function getCurrentUser() {
        return $this->componentController->getUser();
    }
    
}
// Create main controller




