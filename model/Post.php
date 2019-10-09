<?php

class Post {
    private $postTitle;
    private $postText;
    private $timeStamp;
    private $username;
    private $id;
    private $comments;

    public function __construct($postTitle, $postText, $username = null, $id = null, $comments = array()) {
        $this->postTitle = $postTitle;
        $this->postText = $postText;
        $this->username = $username == null ? $_SESSION['username'] : $username;
        $this->id = $id;
        $this->comments = $comments;
        $this->timeStamp = date('Y-m-d H:i');
    }

    public function addComment() {
        array_push($this->comments, $comment);
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

    public function getComments() {
        return $this->comments;
    }

}