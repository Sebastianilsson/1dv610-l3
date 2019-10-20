<?php

require_once('view/BillboardView.php');
require_once('view/Messages.php');

require_once('controller/BillboardController.php');

require_once('model/Post.php');
require_once('model/PostComment.php');
require_once('model/Validation.php');
require_once('model/DatabaseModel.php');
require_once('model/Exceptions.php');

require_once('' . __DIR__ . '/../Settings.php');

class BillboardComponent
{

    private $billboardController;

    public function __construct($user)
    {
        $this->billboardController = new BillboardController($user);
    }

    public function render()
    {
        $this->billboardController->handleBillboardInteraction();
        $this->billboardController->renderState();
    }
}
