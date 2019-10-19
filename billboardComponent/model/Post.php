<?php

class Post {
    private $postTitle;
    private $postText;
    private $timeStamp;
    private $username;
    private $id;

    public function __construct($postTitle, $postText, $username, $id = null) {
        $this->validateText($postTitle, $postText);
        $this->postTitle = $postTitle;
        $this->postText = $postText;
        $this->username = $username;
        $this->id = $id;
        $this->timeStamp = date('Y-m-d H:i');
    }

    private function validateText($title, $text) {
        $this->isFieldFilled($title);
        $this->isFieldFilled($text);
        $this->isNoHTMLTags($title);
        $this->isNoHTMLTags($text);
    }

    private function isFieldFilled($text) {
        if (strlen($text) == 0) {
            throw new EmptyField('All empty field in submit');
        }
    }

    private function isNoHTMLTags($text) {
        $textWithoutTags = strip_tags($text);
        if ($textWithoutTags != $text) {
            throw new HTMLTagsInText('Text: "'.$text.'" contains script tags');
        }
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

}