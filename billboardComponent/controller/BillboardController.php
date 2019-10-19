<?php

class BillboardController {

    private $databaseModel;
    private $registerModel;
    private $billboardView;

    public function __construct($user) {

        $this->databaseModel = new \Billboard\DatabaseModel();
        $this->billboardView = new BillboardView($user);
    }

    // $this->billboardController = new BillboardController($this->loginView, $this->databaseModel, $this->billboardView);
    // if ($this->billboardView->isBillboardRequested()) {
    //     $this->billboardController->handleBillboardInteraction();
    // }
    // if ($this->billboardView->isBillboardRequested()) {
    //     $this->layoutView->render($this->billboardView);
    // } 
    // $this->billboardView = new BillboardView($this->sessionModel);
    // Method called if registration of a new user is requested
    public function handleBillboardInteraction() {
        if ($this->billboardView->isEditPostSubmitted()) {
            $this->saveEditedPost();
        } elseif ($this->billboardView->isNewPostSubmitted()) {
            $this->createAndSaveNewPost();
        } elseif ($this->billboardView->isNewCommentSubmitted()) {
            $this->createAndSaveNewComment();
        } elseif ($this->billboardView->isEditPostRequested()) {
            $this->getPostToEdit();
        } elseif ($this->billboardView->isDeletePostRequested()) {
            $this->deletePostAndComments();
        }
        $this->setBillboardState();
    }

    public function renderState() {
        $this->billboardView->response();
    }

    private function saveEditedPost() {
        $editedPost = $this->billboardView->getPost();
        $this->databaseModel->updateEditedPost($editedPost);
    }

    private function createAndSaveNewPost() {
        $newPost = $this->billboardView->getPost();
        if ($newPost->isValid()) {
            $this->databaseModel->savePost($newPost);
        } else {
            $errorMessage = $newPost->getErrorMessage();
            $this->billboardView->setPostMessage($errorMessage);
        }
    }

    private function createAndSaveNewComment() {
        $newComment = $this->billboardView->getComment();
        if ($newComment->isValid()) {
            $this->databaseModel->savePostComment($newComment);
        } else {
            $errorMessage = $newComment->getErrorMessage();
            $this->billboardView->setPostMessage($errorMessage);
        }
        
    }

    private function getPostToEdit() {
        $postId = $this->billboardView->getPostId();
        $postToBeEdit = $this->databaseModel->getPost($postId);
        $this->billboardView->setPostTitleAndTextEdit($postToBeEdit);
    }

    private function deletePostAndComments() {
        $postId = $this->billboardView->getPostId();
        $this->databaseModel->deletePostAndComments($postId);
    }

    private function setBillboardState() {
        // $this->isLoggedIn();
        $posts = $this->databaseModel->getPosts();
        $comments = $this->databaseModel->getComments();
        $this->billboardView->setPosts($posts);
        $this->billboardView->setComments($comments);
    }

    // private function isLoggedIn() {
    //     if ($this->isLoggedIn) {
    //         $this->billboardView->isLoggedIn();
    //     } else {
    //         $this->billboardView->isNotLoggedIn();
    //     }
    // }
}