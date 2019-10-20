<?php

class PostComment {

    private static $currentDateAndTime = 'Y-m-d H:i';

    private $commentText;
    private $timeStamp;
    private $username;
    private $postId;

    public function __construct($commentText, $username, $postId) {
        $this->commentText = $commentText;
        $this->postId = $postId;
        $this->username = $username;
        $this->timeStamp = date(self::$currentDateAndTime);
    }

    private function validateText($text) {
        $this->isFieldFilled($text);
        $this->isNoHTMLTags($text);
    }

    public function getText() {
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