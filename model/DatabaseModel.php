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

    public function removeOldSessionIfExisting($username) {
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

    public function saveCookieToDatabase($username, $password) {
        $this->connectToDatabase();
        $sql = "INSERT INTO sessions (username, password) VALUES (?, ?)";
        $statement = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($statement, $sql)) {
            echo "fail to save session...";
        } else {
            mysqli_stmt_bind_param($statement, "ss", $username, $password);
            mysqli_stmt_execute($statement);
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