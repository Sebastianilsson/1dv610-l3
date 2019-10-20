<?php

require_once('./loginComponent/index.php');
require_once('./billboardComponent/index.php');

//SESSION
session_start();

// TODO change catch if time....

try {
    $loginComponent = new LoginComponent();
    $loginComponent->render();
    $user = $loginComponent->getCurrentUser();

    $billboardComponent = new BillboardComponent($user);
    $billboardComponent->render();
} catch (FailedConnection $error) {
    echo $error;
} catch (FailedToPrepareStatement $error) {
    echo $error;
} catch (Exception $error) {
    echo $error;
}
