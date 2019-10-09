<?php

class BillboardController {

    private $layoutView;
    private $loginView;
    private $databaseModel;
    private $registerModel;
    private $billboardView;


    public function __construct($layoutView, $loginView, $databaseModel, $billboardView) {
        $this->databaseModel = $databaseModel;
        $this->billboardView = $billboardView;
        $this->loginView = $loginView;
        $this->layoutView = $layoutView;
    }

    // Method called if registration of a new user is requested
    public function handleBillboardInteraction() {
        if ($this->billboardView->isNewPostSubmitted()) {
            $this->createAndSaveNewPost();
        }
        // elseif ($this->billboardView->isNewComment()) {

        // }
        $this->isLoggedIn();
        // $this->layoutView->render($this->albumView);
    }

    private function createAndSaveNewPost() {
        $newPost = $this->billboardView->getPost();
        print_r($newPost);
        // $newPost = new Post($postTitle, $postText);
    }

    private function isLoggedIn() {
        if ($this->loginView->getIsLoggedIn()) {
            $this->billboardView->isLoggedIn();
        } else {
            $this->billboardView->isNotLoggedIn();
        }
    }
}