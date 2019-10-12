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
        if ($this->billboardView->isEditPostSubmitted()) {
            $this->saveEditedPost();
        } elseif ($this->billboardView->isNewPostSubmitted()) {
            $this->createAndSaveNewPost();
        } elseif ($this->billboardView->isNewCommentSubmitted()) {
            $this->createAndSaveNewComment();
        }
        if ($this->billboardView->isEditPostRequested()) {
            $this->getPostToEdit();
        } elseif ($this->billboardView->isDeletePostRequested()) {
            $this->deletePostAndComments();
        }
        $this->setBillboardState();
    }

    private function saveEditedPost() {
        $editedPost = $this->billboardView->getPost();
        $this->databaseModel->updateEditedPost($editedPost);
    }

    private function createAndSaveNewPost() {
        $newPost = $this->billboardView->getPost();
        $this->databaseModel->savePost($newPost);
        // $newPost = new Post($postTitle, $postText);
    }

    private function createAndSaveNewComment() {
        $newComment = $this->billboardView->getComment();
        $this->databaseModel->savePostComment($newComment);
    }

    private function getPostToEdit() {
        $postId = $this->billboardView->getPostId();
        $postToBeEdit = $this->databaseModel->getPost($postId);
        $this->billboardView->setPostTitleAndTextEdit($postToBeEdit);
    }

    private function deletePost() {
        $postId = $this->billboardView->getPostId();
        $this->databaseModel->deletePost($postId);
    }

    private function setBillboardState() {
        $this->isLoggedIn();
        $posts = $this->databaseModel->getPosts();
        $comments = $this->databaseModel->getComments();
        $this->billboardView->setPosts($posts);
        $this->billboardView->setComments($comments);
    }

    private function isLoggedIn() {
        if ($this->loginView->getIsLoggedIn()) {
            $this->billboardView->isLoggedIn();
        } else {
            $this->billboardView->isNotLoggedIn();
        }
    }
}