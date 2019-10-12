<?php

class Post {
    private $postTitle;
    private $postText;
    private $timeStamp;
    private $username;
    private $id;
    private $comments;
    private $isPostValid = true;
    private $errorMessage = "";

    public function __construct($postTitle, $postText, $id = null) {
        $this->postTitle = $this->validateText($postTitle);
        $this->postText = $this->validateText($postText);
        $this->username = $_SESSION['username'];
        $this->id = $id;
        $this->timeStamp = date('Y-m-d H:i');
    }

    private function validateText($text) {
        if($this->isFieldFilled($text) && $this->isNoHTMLTags($text)) {
            return $text;
        }
    }

    private function isFieldFilled($text) {
        if (strlen($text) > 0) {
            return true;
        } else {
            $this->isPostValid = false;
            $this->errorMessage = "All fields in a Post needs to be filled.";
        }
    }

    private function isNoHTMLTags($text) {
        $textWithoutTags = strip_tags($text);
        if ($textWithoutTags == $text) {
            return true;
        } else {
            $this->isPostValid = false;
            $this->errorMessage = "Post can not contain script-tags";
        }
    }

    public function isValid() {
        return $this->isPostValid;
    }

    public function getPostText() {
        return $this->postText;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPostTitle() {
        return $this->postTitle;
    }

    public function getTimeStamp() {
        return $this->timeStamp;
    }

    public function getPostId() {
        return $this->id;
    }

    public function getErrorMessage() {
        return $this->errorMessage;
    }

}