<?php

class PostComment {
    private $commentText;
    private $timeStamp;
    private $username;
    private $postId;

    public function __construct($commentText, $username, $postId) {
        // $this->validateText($commentText);
        $this->commentText = $commentText;
        $this->postId = $postId;
        $this->username = $username;
        $this->timeStamp = date('Y-m-d H:i');
    }

    private function validateText($text) {
        $this->isFieldFilled($text);
        $this->isNoHTMLTags($text);
    }

    // private function isFieldFilled($text) {
    //     if (strlen($text) == 0) {
    //         throw new EmptyField('All empty field in submit');
    //     }
    // }

    // private function isNoHTMLTags($text) {
    //     $textWithoutTags = strip_tags($text);
    //     if ($textWithoutTags != $text) {
    //         throw new HTMLTagsInText('Text: "'.$text.'" contains script tags');
    //     }
    // }

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