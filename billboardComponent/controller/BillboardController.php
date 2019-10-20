<?php

class BillboardController
{

    private $databaseModel;
    private $validation;
    private $billboardView;

    public function __construct($user)
    {

        $this->databaseModel = new \Billboard\DatabaseModel();
        $this->validation = new \Billboard\Validation();
        $this->billboardView = new BillboardView($user);
    }

    // Method called if registration of a new user is requested
    public function handleBillboardInteraction()
    {
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

    public function renderState()
    {
        $this->billboardView->response();
    }

    private function saveEditedPost()
    {
        try {
            $editedPost = $this->billboardView->getPost();
            $this->validation->postValidation($editedPost);
            $this->databaseModel->updateEditedPost($editedPost);
            $this->billboardView->setPostMessage(\Billboard\Messages::$postEdited);
        } catch (EmptyField $error) {
            $this->billboardView->setPostMessage(\Billboard\Messages::$emptyFieldPost);
        } catch (HTMLTagsInText $error) {
            $this->billboardView->setPostMessage(\Billboard\Messages::$scriptTagsInPost);
        }
    }

    private function createAndSaveNewPost()
    {
        try {
            $newPost = $this->billboardView->getPost();
            $this->validation->postValidation($newPost);
            $this->databaseModel->savePost($newPost);
            $this->billboardView->setPostMessage(\Billboard\Messages::$postCreated);
        } catch (EmptyField $error) {
            $this->billboardView->setPostMessage(\Billboard\Messages::$emptyFieldPost);
        } catch (HTMLTagsInText $error) {
            $this->billboardView->setPostMessage(\Billboard\Messages::$scriptTagsInPost);
        }
    }

    private function createAndSaveNewComment()
    {
        try {
            $newComment = $this->billboardView->getComment();
            $this->validation->commentValidation($newComment);
            $this->databaseModel->savePostComment($newComment);
            $this->billboardView->setPostMessage(\Billboard\Messages::$commentCreated);
        } catch (EmptyField $error) {
            $this->billboardView->setPostMessage(\Billboard\Messages::$emptyFieldComment);
        } catch (HTMLTagsInText $error) {
            $this->billboardView->setPostMessage(\Billboard\Messages::$scriptTagsInComment);
        }
    }

    private function getPostToEdit()
    {
        $postId = $this->billboardView->getPostId();
        $postToBeEdit = $this->databaseModel->getPost($postId);
        $this->billboardView->setPostTitleAndTextEdit($postToBeEdit);
        $this->billboardView->setPostMessage(\Billboard\Messages::$editYourPost);
    }

    private function deletePostAndComments()
    {
        $postId = $this->billboardView->getPostId();
        $this->databaseModel->deletePostAndComments($postId);
        $this->billboardView->setPostMessage(\Billboard\Messages::$postDeleted);
    }

    private function setBillboardState()
    {
        $posts = $this->databaseModel->getPosts();
        $comments = $this->databaseModel->getComments();
        $this->billboardView->setPosts($posts);
        $this->billboardView->setComments($comments);
    }
}
