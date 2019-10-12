<?php

class PostComment {
    private $commentText;
    private $timeStamp;
    private $username;
    private $postId;
    private $isCommentValid = true;

    public function __construct($commentText, $postId) {
        $this->commentText = $this->validateText($commentText);
        $this->postId = $postId;
        $this->username = $_SESSION['username'];
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
            $this->isCommentValid = false;
        }
    }

    private function isNoHTMLTags($text) {
        $textWithoutTags = strip_tags($text);
        if ($textWithoutTags == $text) {
            return true;
        } else {
            $this->isCommentValid = false;
        }
    }

    public function isValid() {
        return $this->isCommentValid;
    }

    public function getCommentText() {
        return $this->commentText;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getTimeStamp() {
        return $this->timeStamp;
    }

    public function getPostId() {
        return $this->postId;
    }

}