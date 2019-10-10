<?php

class PostComment {
    private $commentText;
    private $timeStamp;
    private $username;
    private $postId;

    public function __construct($commentText, $postId) {
        $this->commentText = $commentText;
        $this->postId = $postId;
        $this->username = $_SESSION['username'];
        $this->timeStamp = date('Y-m-d H:i');
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

}