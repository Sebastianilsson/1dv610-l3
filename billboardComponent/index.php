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

    /**
     * Is called when a new BillboardComponent is created
     * 
     * @param $user - is a user-object that should contain a username and 
     * whether the user is logged in or not. The username should be acceced 
     * by a getter called "getUsername" and whether the user is logged in 
     * or not should be acceced from a getter called "getIsLoggedIn".
     */
    public function __construct($user)
    {
        $this->billboardController = new BillboardController($user);
    }

    /**
     * Create a new BillboardComponent and call this method to view the billboard.
     * 
     * Renders a billboard component that allows a user to create/edit/delete 
     * billboard posts as well as comment on his own and other users posts. 
     * A user that is not logged in is allowed to view the posts and comments 
     * made by other users but is not allowed to create/edit/delete posts 
     * or create comments.
     */
    public function render()
    {
        $this->billboardController->handleBillboardInteraction();
        $this->billboardController->renderState();
    }
}
