<?php

class DatabaseModel {

    // Only used to connect to local database during development
    private $databaseServerName;
    private $databaseUserName;
    private $databasePassword;
    private $databaseName;

    private $connection;
    private $statement;

    public function __construct() {
        $settings = new Settings();
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

    public function checkIfUsernameIsFree($username) {
        $sql = "SELECT username FROM users WHERE username=?";
        if ($this->prepareStatement($sql)) {
            mysqli_stmt_bind_param($this->statement, "s", $username);
            mysqli_stmt_execute($this->statement);
            mysqli_stmt_store_result($this->statement);
            $nrOfUsersWithUsername = mysqli_stmt_num_rows($this->statement);
            $this->closeStatementAndConnection();
            return $nrOfUsersWithUsername == 0 ? true : false;
        }
    }

    public function saveUserToDatabase($username, $password) {
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        if ($this->prepareStatement($sql)) {
            mysqli_stmt_bind_param($this->statement, "ss", $username, $password);
            mysqli_stmt_execute($this->statement);
            $this->closeStatementAndConnection();
        }
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

    public function usernameExistsInDatabase($username) {
        $sql = "SELECT username FROM users WHERE username=?";
        if ($this->prepareStatement($sql)) {
            mysqli_stmt_bind_param($this->statement, "s", $username);
            mysqli_stmt_execute($this->statement);
            mysqli_stmt_store_result($this->statement);
            $nrOfUsersWithUsername = mysqli_stmt_num_rows($this->statement);
            $this->closeStatementAndConnection();
            return $nrOfUsersWithUsername == 1 ? true : false;
        }
    }

    public function userPasswordMatch($username, $password) {
        $this->connectToDatabase();
        $sql = "SELECT * FROM users WHERE username=?";
        $statement = mysqli_stmt_init($this->connection);
        if ($this->prepareStatement($sql)) {
            mysqli_stmt_bind_param($this->statement, "s", $username);
            mysqli_stmt_execute($this->statement);
            $matchingUser = mysqli_stmt_get_result($this->statement);
            if ($user = mysqli_fetch_assoc($matchingUser)) {    
                $matchingPassword = password_verify($password, $user['password']);
                $this->closeStatementAndConnection();
                return $matchingPassword ? true : false;
            }
        }
    }

    public function saveCookieCredentials($cookieValues) {
        $cookieUsername = $cookieValues->getCookieUsername();
        $cookiePassword = $cookieValues->getCookiePassword();
        $this->removeOldCookieIfExisting($cookieValues->getCookieUsername());
        $sql = "INSERT INTO sessions (username, password) VALUES (?, ?)";
        if ($this->prepareStatement($sql)) {
            mysqli_stmt_bind_param($this->statement, "ss", $cookieUsername, $cookiePassword);
            mysqli_stmt_execute($this->statement);
            $this->closeStatementAndConnection();
        }
    }

    private function removeOldCookieIfExisting($username) {
        $sql = "DELETE FROM sessions WHERE username='$username'";
        if ($this->prepareStatement($sql)) {
            mysqli_stmt_execute($this->statement);
        }
        $this->closeStatementAndConnection();
    }

    public function cookiePasswordMatch($cookieValues) {
        $cookieUsername = $cookieValues->getCookieUsername();
        $cookiePassword = $cookieValues->getCookiePassword();
        $sql = "SELECT * FROM sessions WHERE username=?";
        if ($this->prepareStatement($sql)) {
            mysqli_stmt_bind_param($this->statement, "s", $cookieUsername);
            mysqli_stmt_execute($this->statement);
            $matchingUser = mysqli_stmt_get_result($this->statement);
            $user = mysqli_fetch_assoc($matchingUser);    
            $this->closeStatementAndConnection();
            return $cookiePassword == $user['password'] ? true : false;
        }
    }
}