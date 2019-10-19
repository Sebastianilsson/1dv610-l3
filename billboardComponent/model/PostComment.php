<?php

class PostComment {
    private $commentText;
    private $timeStamp;
    private $username;
    private $postId;
    private $isCommentValid = true;
    private $errorMessage = "";

    public function __construct($commentText, $username, $postId) {
        $this->commentText = $this->validateText($commentText);
        $this->postId = $postId;
        $this->username = $username;
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
            $this->errorMessage = "You can't submit an empty Comment.";
        }
    }

    private function isNoHTMLTags($text) {
        $textWithoutTags = strip_tags($text);
        if ($textWithoutTags == $text) {
            return true;
        } else {
            $this->isCommentValid = false;
            $this->errorMessage = "Comment can't contain script-tags.";
        }
    }

    public function isValid() {
        return $this->isCommentValid;
    }

    public function getErrorMessage() {
        return $this->errorMessage;
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