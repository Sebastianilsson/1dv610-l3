<?php

require_once('view/BillboardView.php');

require_once('controller/BillboardController.php');

require_once('model/Post.php');
require_once('model/PostComment.php');
require_once('model/DatabaseModel.php');

require_once(''.__DIR__.'/../Settings.php');

class BillboardComponent {
    // private $username;
    // private $isLoggedIn;
    private $billboardController;

    public function __construct($user) {
        // $this->username = $user->getUsername();
        // $this->isLoggedIn = $user->getIsLoggedIn();
        $this->billboardController = new BillboardController($user);
    }

    public function render() {
        $this->billboardController->handleBillboardInteraction();
        $this->billboardController->renderState();
    }
}