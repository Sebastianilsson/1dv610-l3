<?php

namespace Billboard;

class DatabaseModel {

    private $databaseServerName;
    private $databaseUserName;
    private $databasePassword;
    private $databaseName;

    private $connection;
    private $statement;

    public function __construct() {
        $settings = new \Settings();
        $this->databaseServerName = $settings->getDatabaseServerName();
        $this->databaseUserName = $settings->getDatabaseUserName();
        $this->databasePassword = $settings->getDatabasePassword();
        $this->databaseName = $settings->getDatabaseName();
    }

    private function connectToDatabase() {
        $this->connection = mysqli_connect($this->databaseServerName, $this->databaseUserName, $this->databasePassword, $this->databaseName);
        if (!$this->connection) {
            throw new Exception("Failed to connect to database...");
            die("Connection failed...".mysqli_connect_error());
        }
    }

    private function prepareStatement($sqlQuery) {
        $this->connectToDatabase();
        $this->statement = mysqli_stmt_init($this->connection);
        if (mysqli_stmt_prepare($this->statement, $sqlQuery)) {
            return true;
        } else {
            throw new Exception("Couldn't prepare statement for database...");
        }
    }

    private function closeStatementAndConnection() {
        mysqli_stmt_close($this->statement);
        mysqli_close($this->connection);
    }

    public function savePost($post) {
        $username = $post->getUsername();
        $postTitle = $post->getPostTitle();
        $postText = $post->getPostText();
        $timeStamp = $post->getTimeStamp();
        $sql = "INSERT INTO posts (username, postTitle, postText, timeStamp) VALUES (?, ?, ?, ?)";
        if ($this->prepareStatement($sql)) {
            mysqli_stmt_bind_param($this->statement, "ssss", $username, $postTitle, $postText, $timeStamp);
            mysqli_stmt_execute($this->statement);
            $this->closeStatementAndConnection();
        }
    }

    public function savePostComment($postComment) {
        $username = $postComment->getUsername();
        $commentText = $postComment->getCommentText();
        $timeStamp = $postComment->getTimeStamp();
        $postId = $postComment->getPostId();
        $sql = "INSERT INTO comments (username, commentText, timeStamp, postId) VALUES (?, ?, ?, ?)";
        if ($this->prepareStatement($sql)) {
            mysqli_stmt_bind_param($this->statement, "ssss", $username, $commentText, $timeStamp, $postId);
            mysqli_stmt_execute($this->statement);
            $this->closeStatementAndConnection();
        }
    }

    public function getPosts() {
        $sql = "SELECT * FROM posts ORDER BY id DESC";
        return $this->selectAllFromOneTable($sql);
    }

    public function getComments() {
        $sql = "SELECT * FROM comments ORDER BY id DESC";
        return $this->selectAllFromOneTable($sql);
    }

    private function selectAllFromOneTable($sql) {
        if ($this->prepareStatement($sql)) {
            mysqli_stmt_execute($this->statement);
            $result = mysqli_stmt_get_result($this->statement);
            $contentArray = array();
            while ($row = mysqli_fetch_array($result)) {
                $contentArray[] = $row;
            }
            $this->closeStatementAndConnection();
            return $contentArray;
        }
    }

    public function deletePostAndComments($postId) {
        $this->deleteFromDataBaseById("DELETE FROM posts WHERE id=?", $postId);
        $this->deleteFromDataBaseById("DELETE FROM comments WHERE postId=?", $postId);
    }

    private function deleteFromDataBaseById($sql, $id) {
        if ($this->prepareStatement($sql)) {
            mysqli_stmt_bind_param($this->statement, "s", $id);
            mysqli_stmt_execute($this->statement);
            $this->closeStatementAndConnection();
        }
    }

    public function getPost($postId) {
        $sql = "SELECT * FROM posts WHERE id=?";
        if ($this->prepareStatement($sql)) {
            mysqli_stmt_bind_param($this->statement, "s", $postId);
            mysqli_stmt_execute($this->statement);
            $result = mysqli_stmt_get_result($this->statement);
            $post = mysqli_fetch_assoc($result);
            $this->closeStatementAndConnection();
            return $post;
        }
    }

    public function updateEditedPost($post) {
        $postTitle = $post->getPostTitle();
        $postText = $post->getPostText();
        $postId = $post->getPostId();
        $this->connectToDatabase();
        $sql = "UPDATE posts SET postTitle=?, postText=? WHERE id=?";
        if ($this->prepareStatement($sql)) {
            mysqli_stmt_bind_param($this->statement, "sss",$postTitle, $postText, $postId);
            mysqli_stmt_execute($this->statement);
            $this->closeStatementAndConnection();
        }
    }
}