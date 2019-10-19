<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('view/Messages.php');

require_once('controller/MainController.php');
require_once('controller/RegisterController.php');
require_once('controller/LoginController.php');

require_once('model/DatabaseModel.php');
require_once('model/RegisterModel.php');
require_once('model/LoginModel.php');
require_once('model/SessionModel.php');
require_once('model/CookieValues.php');
require_once('model/Exceptions.php');

require_once(''.__DIR__.'/../Settings.php');


class LoginComponent {
    public function getLogin() {
        $componentController = new MainController();
        $componentController->setState();
        $componentController->renderState();
    }
    
}
// Create main controller




