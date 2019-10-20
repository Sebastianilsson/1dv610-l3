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
require_once('model/SessionModel.php');
require_once('model/CookieValues.php');
require_once('model/LoginUser.php');
require_once('model/RegisterUser.php');
require_once('model/User.php');
require_once('model/Exceptions.php');

require_once('' . __DIR__ . '/../Settings.php');


class LoginComponent
{

    private $componentController;

    /**
     * Is called when a new LoginComponent is created
     */
    public function __construct()
    {
        $this->componentController = new MainController();
    }

    /**
     * Create a new LoginComponent and call this method to view the login module.
     * 
     * Renders a login module that makes it possible for a user to register a 
     * new user that is being saved to a database. The component then allows 
     * the user to log in if provided the right credentials. A user could be 
     * logged in by the login form, session or cookies. The module can withstand 
     * malicious login attempts by cookie tampering or session hijacking. 
     * The module sends out a user-object that then kan be used by other components 
     * to display or behave differently depending on if the user is logged in or not.
     */
    public function render()
    {
        $this->componentController->setState();
        $this->componentController->renderState();
    }

    /**
     * Call this method when you want an user-object that shows if the user currently 
     * is logged in or not and the username if the user is logged in.
     * 
     * @return User - is a user-object that should contain a username and 
     * whether the user is logged in or not. The username could be acceced 
     * by a getter called "getUsername" and whether the user is logged in 
     * or not could be acceced from a getter called "getIsLoggedIn".
     */
    public function getCurrentUser(): User
    {
        return $this->componentController->getUser();
    }
}
// Create main controller
