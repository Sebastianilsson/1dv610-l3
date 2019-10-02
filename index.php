<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');

require_once('controller/MainController.php');
require_once('controller/RegisterController.php');
require_once('controller/LoginController.php');

require_once('model/DatabaseModel.php');
require_once('model/RegisterModel.php');
require_once('model/LoginModel.php');
require_once('model/SessionModel.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//SESSION
session_start();

// Create main controller
$componentController = new MainController();

$componentController->router();
