<?php

require_once('./loginComponent/index.php');
require_once('./billboardComponent/index.php');

//MAKE SURE ERRORS ARE SHOWN.. MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//SESSION
session_start();

$loginComponent = new LoginComponent();
$loginComponent->render();
$user = $loginComponent->getCurrentUser();

$billboardComponent = new BillboardComponent($user);
$billboardComponent->render();

