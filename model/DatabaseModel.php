<?php

class DatabaseModel {

    // Only used to connect to local database during development
    private $databaseServerName = "localhost";
    private $databaseUserName = "root";
    private $databasePassword = "";
    private $databaseName = "1dv610-l2";

    private $connection;
    public function __construct() {
        $this->checkIfOnLocalhost();
    }

    // Method that sets credentials for database if not on localhost
    private function checkIfOnLocalhost() {
        $whitelist = array(
            '127.0.0.1',
            '::1'
        );
        if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
            return;
        } else {
            $this->databaseServerName = getenv('DATABASE_SERVER_NAME');
            $this->databaseUserName = getenv('DATABASE_USERNAME');
            $this->databasePassword = getenv('DATABASE_PASSWORD');
            $this->databaseName = getenv('DATABASE_NAME');
        }
    }

    private function connectToDatabase() {
        $this->connection = mysqli_connect($this->databaseServerName, $this->databaseUserName, $this->databasePassword, $this->databaseName);
        if (!$this->connection) {
            echo "failed connection";
            die("Connection failed...".mysqli_connect_error());
        }
    }

    public function checkIfUsernameIsFree($username) {
        $this->connectToDatabase();
        $sql = "SELECT username FROM users WHERE username=?";
        $statement = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            echo "fail to get user...";
        } else {
            mysqli_stmt_bind_param($statement, "s", $username);
            mysqli_stmt_execute($statement);
            mysqli_stmt_store_result($statement);
            $nrOfUsersWithUsername = mysqli_stmt_num_rows($statement);
            mysqli_stmt_close($statement);
            mysqli_close($this->connection);
            if ($nrOfUsersWithUsername == 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function saveUserToDatabase($username, $password) {
        $this->connectToDatabase();
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $statement = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            echo "fail to get user...";
        } else {
            mysqli_stmt_bind_param($statement, "ss", $username, $password);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
            mysqli_close($this->connection);
        }
    }

    public function savePost($post) {
        $username = $post->getUsername();
        $postTitle = $post->getPostTitle();
        $postText = $post->getPostText();
        $timeStamp = $post->getTimeStamp();
        $this->connectToDatabase();
        $sql = "INSERT INTO posts (username, postTitle, postText, timeStamp) VALUES (?, ?, ?, ?)";
        $statement = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            echo "fail to save post...";
        } else {
            mysqli_stmt_bind_param($statement, "ssss", $username, $postTitle, $postText, $timeStamp);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
            mysqli_close($this->connection);
        }
    }

    public function savePostComment($postComment) {
        $username = $postComment->getUsername();
        $commentText = $postComment->getCommentText();
        $timeStamp = $postComment->getTimeStamp();
        $postId = $postComment->getPostId();

        $this->connectToDatabase();
        $sql = "INSERT INTO comments (username, commentText, timeStamp, postId) VALUES (?, ?, ?, ?)";
        $statement = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            echo "fail to save comment...";
        } else {
            mysqli_stmt_bind_param($statement, "ssss", $username, $commentText, $timeStamp, $postId);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
            mysqli_close($this->connection);
        }
    }

    public function getPosts() {
        $this->connectToDatabase();
        $sql = "SELECT * FROM posts ORDER BY id DESC";
        $statement = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            echo "fail to get posts...";
        } else {
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);
            $postsArray = array();
            while ($row = mysqli_fetch_array($result)) {
                $postsArray[] = $row;
            }
            mysqli_stmt_close($statement);
            mysqli_close($this->connection);
            return $postsArray;
        }
    }

    public function getComments() {
        $this->connectToDatabase();
        $sql = "SELECT * FROM comments ORDER BY id DESC";
        $statement = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            echo "fail to get comments...";
        } else {
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);
            $commentsArray = array();
            while ($row = mysqli_fetch_array($result)) {
                $commentsArray[] = $row;
            }
            mysqli_stmt_close($statement);
            mysqli_close($this->connection);
            return $commentsArray;
        }
    }

    public function deletePost($postId) {
        $this->connectToDatabase();
        $sql = "DELETE FROM posts WHERE id=?";
        $statement = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            echo "fail to get user...";
        } else {
            mysqli_stmt_bind_param($statement, "s", $postId);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
            mysqli_close($this->connection);
            $this->deleteComments($postId);
        }
    }

    public function getPost($postId) {
        $this->connectToDatabase();
        $sql = "SELECT * FROM posts WHERE id=?";
        $statement = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            echo "fail to get user...";
        } else {
            mysqli_stmt_bind_param($statement, "s", $postId);
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);
            $post = mysqli_fetch_assoc($result);
            mysqli_stmt_close($statement);
            mysqli_close($this->connection);
            return $post;
        }
    }

    private function deleteComments($postId) {
        $this->connectToDatabase();
        $sql = "DELETE FROM comments WHERE postId=?";
        $statement = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            echo "fail to get user...";
        } else {
            mysqli_stmt_bind_param($statement, "s", $postId);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
            mysqli_close($this->connection);
        }
    }

    public function updateEditedPost($post) {
        $postTitle = $post->getPostTitle();
        $postText = $post->getPostText();
        $postId = $post->getPostId();
        $this->connectToDatabase();
        $sql = "UPDATE posts SET postTitle=?, postText=? WHERE id=?";
        $statement = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            echo "fail to get user...";
        } else {
            mysqli_stmt_bind_param($statement, "sss",$postTitle, $postText, $postId);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
            mysqli_close($this->connection);
        }
    }

    public function usernameExistsInDatabase($username) {
        $this->connectToDatabase();
        $sql = "SELECT username FROM users WHERE username=?";
        $statement = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            echo "fail to get user...";
        } else {
            mysqli_stmt_bind_param($statement, "s", $username);
            mysqli_stmt_execute($statement);
            mysqli_stmt_store_result($statement);
            $nrOfUsersWithUsername = mysqli_stmt_num_rows($statement);
            mysqli_stmt_close($statement);
            mysqli_close($this->connection);
            if ($nrOfUsersWithUsername == 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function userPasswordMatch($username, $password) {
        $this->connectToDatabase();
        $sql = "SELECT * FROM users WHERE username=?";
        $statement = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            echo "Failed to get user";
        } else {
            mysqli_stmt_bind_param($statement, "s", $username);
            mysqli_stmt_execute($statement);
            $matchingUser = mysqli_stmt_get_result($statement);
            if ($user = mysqli_fetch_assoc($matchingUser)) {    
                $matchingPassword = password_verify($password, $user['password']);
                mysqli_stmt_close($statement);
                mysqli_close($this->connection);
                if ($matchingPassword) {
                    return true;
                }
            } else {
                return false;
            }
        }
    }

    public function saveCookieCredentials($cookieValues) {
        $cookieUsername = $cookieValues->getCookieUsername();
        $cookiePassword = $cookieValues->getCookiePassword();
        $this->removeOldCookieIfExisting($cookieValues->getCookieUsername());
        $this->connectToDatabase();
        $sql = "INSERT INTO sessions (username, password) VALUES (?, ?)";
        $statement = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            echo "fail to save session...";
        } else {
            mysqli_stmt_bind_param($statement, "ss", $cookieUsername, $cookiePassword);
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
            mysqli_close($this->connection);
        }
    }

    private function removeOldCookieIfExisting($username) {
        $this->connectToDatabase();
        $sql = "SELECT username FROM sessions WHERE username=?";
        $statement = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            echo "fail to get user...";
        } else {
            mysqli_stmt_bind_param($statement, "s", $username);
            mysqli_stmt_execute($statement);
            mysqli_stmt_store_result($statement);
            $nrOfUsersWithUsername = mysqli_stmt_num_rows($statement);
            if ($nrOfUsersWithUsername == 1) {
                $sql = "DELETE FROM sessions WHERE username='$username'";
                if (!mysqli_stmt_prepare($statement, $sql)) {
                    echo "failed to delete session";
                } else {
                    mysqli_stmt_execute($statement);
                }
            }
            mysqli_stmt_close($statement);
            mysqli_close($this->connection);
        }
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