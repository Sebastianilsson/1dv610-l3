<?php

class Post
{

    private static $currentDateAndTime = 'Y-m-d H:i';

    private $postTitle;
    private $postText;
    private $timeStamp;
    private $username;
    private $id;

    public function __construct(string $postTitle, string $postText, string $username, string $id = null)
    {
        $this->postTitle = $postTitle;
        $this->postText = $postText;
        $this->username = $username;
        $this->id = $id;
        $this->timeStamp = date(self::$currentDateAndTime);
    }

    public function getText(): string
    {
        return $this->postText;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getTitle(): string
    {
        return $this->postTitle;
    }

    public function getTimeStamp(): string
    {
        return $this->timeStamp;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
