<?php

class PostComment
{

    private static $currentDateAndTime = 'Y-m-d H:i';

    private $commentText;
    private $timeStamp;
    private $username;
    private $postId;

    public function __construct(string $commentText, string $username, string $postId)
    {
        $this->commentText = $commentText;
        $this->postId = $postId;
        $this->username = $username;
        $this->timeStamp = date(self::$currentDateAndTime);
    }

    public function getText(): string
    {
        return $this->commentText;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getTimeStamp(): string
    {
        return $this->timeStamp;
    }

    public function getPostId(): string
    {
        return $this->postId;
    }
}
