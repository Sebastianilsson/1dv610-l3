<?php

class Post {

    private static $currentDateAndTime = 'Y-m-d H:i';

    private $postTitle;
    private $postText;
    private $timeStamp;
    private $username;
    private $id;

    public function __construct($postTitle, $postText, $username, $id = null) {
        $this->postTitle = $postTitle;
        $this->postText = $postText;
        $this->username = $username;
        $this->id = $id;
        $this->timeStamp = date(self::$currentDateAndTime);
    }

    private function validateText($title, $text) {
        $this->isFieldFilled($title);
        $this->isFieldFilled($text);
        $this->isNoHTMLTags($title);
        $this->isNoHTMLTags($text);
    }

    public function getText() {
        return $this->postText;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getTitle() {
        return $this->postTitle;
    }

    public function getTimeStamp() {
        return $this->timeStamp;
    }

    public function getId() {
        return $this->id;
    }

}