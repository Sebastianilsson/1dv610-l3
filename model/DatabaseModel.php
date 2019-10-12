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
        // $this->checkIfOnLocalhost();
        $settings = new Settings();
        $this->databaseServerName = $settings->getDatabaseServerName();
        $this->databaseUserName = $settings->getDatabaseUsername();
        $this->databasePassword = $settings->getDatabasePassword();
        $this->databaseName = $settings->getDatabaseName();
    }

    // Method that sets credentials for database if not on localhost
    // private function checkIfOnLocalhost() {
    //     $whitelist = array(
    //         '127.0.0.1',
    //         '::1'
    //     );
    //     if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
    //         return;
    //     } else {
    //         $this->databaseServerName = getenv('DATABASE_SERVER_NAME');
    //         $this->databaseUserName = getenv('DATABASE_USERNAME');
    //         $this->databasePassword = getenv('DATABASE_PASSWORD');
    //         $this->databaseName = getenv('DATABASE_NAME');
    //     }
    // }

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
            if ($nrOfUsersWithUsername == 0) {
                return true;
            } else {
                return false;
            }
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
        if ($this->prepareStatement($sql)) {
            mysqli_stmt_execute($this->statement);
            $result = mysqli_stmt_get_result($this->statement);
            $postsArray = array();
            while ($row = mysqli_fetch_array($result)) {
                $postsArray[] = $row;
            }
            $this->closeStatementAndConnection();
            return $postsArray;
        }
    }

    public function getComments() {
        $sql = "SELECT * FROM comments ORDER BY id DESC";
        if ($this->prepareStatement($sql)) {
            mysqli_stmt_execute($this->statement);
            $result = mysqli_stmt_get_result($this->statement);
            $commentsArray = array();
            while ($row = mysqli_fetch_array($result)) {
                $commentsArray[] = $row;
            }
            $this->closeStatementAndConnection();
            return $commentsArray;
        }
    }

    public function deletePostAndComments($postId) {
        $sql = "DELETE posts, comments FROM posts INNER JOIN comments 
        ON comments.postId = posts.id WHERE posts.id = ?";
        if ($this->prepareStatement($sql)) {
            mysqli_stmt_bind_param($this->statement, "s", $postId);
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

    public function cookiePasswordMatch() {
        $this->connectToDatabase();
        $sql = "SELECT * FROM sessions WHERE username=?";
        $statement = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            echo "Failed to get user";
        } else {
            mysqli_stmt_bind_param($statement, "s", $_COOKIE['LoginView::CookieName']);
            mysqli_stmt_execute($statement);
            $matchingUser = mysqli_stmt_get_result($statement);
            if ($user = mysqli_fetch_assoc($matchingUser)) {    
                mysqli_stmt_close($statement);
                mysqli_close($this->connection);
                if ($_COOKIE['LoginView::CookiePassword'] == $user['password']) {
                    return true;
                }
            } else {
                return false;
            }
        }
    }
}