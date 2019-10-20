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

    public function getText()
    {
        return $this->postText;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getTitle()
    {
        return $this->postTitle;
    }

    public function getTimeStamp()
    {
        return $this->timeStamp;
    }

    public function getId()
    {
        return $this->id;
    }
}
