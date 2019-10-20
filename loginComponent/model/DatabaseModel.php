<?php

class DatabaseModel
{

    private $databaseServerName;
    private $databaseUserName;
    private $databasePassword;
    private $databaseName;

    private $connection;
    private $statement;

    public function __construct()
    {
        $settings = new Settings();
        $this->databaseServerName = $settings->getDatabaseServerName();
        $this->databaseUserName = $settings->getDatabaseUserName();
        $this->databasePassword = $settings->getDatabasePassword();
        $this->databaseName = $settings->getDatabaseName();
    }

    private function connectToDatabase()
    {
        $this->connection = mysqli_connect($this->databaseServerName, $this->databaseUserName, $this->databasePassword, $this->databaseName);
        if (!$this->connection) {
            throw new FailedConnection("Failed to connect to database...");
            die("Connection failed..." . mysqli_connect_error());
        }
    }

    private function prepareStatement($sqlQuery)
    {
        $this->connectToDatabase();
        $this->statement = mysqli_stmt_init($this->connection);
        if (!mysqli_stmt_prepare($this->statement, $sqlQuery)) {
            throw new FailedToPrepareStatement("Couldn't prepare statement for database...");
        }
    }

    private function closeStatementAndConnection()
    {
        mysqli_stmt_close($this->statement);
        mysqli_close($this->connection);
    }

    public function checkIfUsernameIsFree(string $username)
    {
        $sql = "SELECT username FROM users WHERE username=?";
        $this->prepareStatement($sql);
        mysqli_stmt_bind_param($this->statement, "s", $username);
        mysqli_stmt_execute($this->statement);
        mysqli_stmt_store_result($this->statement);
        $nrOfUsersWithUsername = mysqli_stmt_num_rows($this->statement);
        $this->closeStatementAndConnection();
        if ($nrOfUsersWithUsername > 0) {
            throw new UsernameAlreadyExists('The username "' . $username . '" already exists in the database');
        }
    }

    public function saveUserToDatabase(RegisterUser $user)
    {
        $username = $user->getUsername();
        $password = $user->getPassword();
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $this->prepareStatement($sql);
        mysqli_stmt_bind_param($this->statement, "ss", $username, $password);
        mysqli_stmt_execute($this->statement);
        $this->closeStatementAndConnection();
    }

    public function checkIfCredentialsMatch(LoginUser $user)
    {
        if (!$this->usernameExistsInDatabase($user->getUsername()) || !$this->userPasswordMatch($user)) {
            throw new UsernameOrPasswordIsInvalid('Wrong username or password entered');
        }
    }

    public function usernameExistsInDatabase(string $username): bool
    {
        $sql = "SELECT username FROM users WHERE username=?";
        $this->prepareStatement($sql);
        mysqli_stmt_bind_param($this->statement, "s", $username);
        mysqli_stmt_execute($this->statement);
        mysqli_stmt_store_result($this->statement);
        $nrOfUsersWithUsername = mysqli_stmt_num_rows($this->statement);
        $this->closeStatementAndConnection();
        return $nrOfUsersWithUsername == 1 ? true : false;
    }

    public function userPasswordMatch(LoginUser $user): bool
    {
        $username = $user->getUsername();
        $password = $user->getPassword();
        $sql = "SELECT * FROM users WHERE username=?";
        $this->prepareStatement($sql);
        mysqli_stmt_bind_param($this->statement, "s", $username);
        mysqli_stmt_execute($this->statement);
        $matchingUser = mysqli_stmt_get_result($this->statement);
        if ($user = mysqli_fetch_assoc($matchingUser)) {
            $matchingPassword = password_verify($password, $user['password']);
            $this->closeStatementAndConnection();
            return $matchingPassword ? true : false;
        }
    }

    public function saveCookieCredentials(CookieValues $cookieValues)
    {
        $cookieUsername = $cookieValues->getCookieUsername();
        $cookiePassword = $cookieValues->getCookiePassword();
        $this->removeOldCookieIfExisting($cookieUsername);
        $sql = "INSERT INTO cookies (username, password) VALUES (?, ?)";
        $this->prepareStatement($sql);
        mysqli_stmt_bind_param($this->statement, "ss", $cookieUsername, $cookiePassword);
        mysqli_stmt_execute($this->statement);
        $this->closeStatementAndConnection();
    }

    private function removeOldCookieIfExisting($username)
    {
        $sql = "DELETE FROM cookies WHERE username='$username'";
        $this->prepareStatement($sql);
        mysqli_stmt_execute($this->statement);
        $this->closeStatementAndConnection();
    }

    public function cookiePasswordMatch(CookieValues $cookieValues)
    {
        $cookieUsername = $cookieValues->getCookieUsername();
        $cookiePassword = $cookieValues->getCookiePassword();
        $sql = "SELECT * FROM cookies WHERE username=?";
        $this->prepareStatement($sql);
        mysqli_stmt_bind_param($this->statement, "s", $cookieUsername);
        mysqli_stmt_execute($this->statement);
        $matchingUser = mysqli_stmt_get_result($this->statement);
        $user = mysqli_fetch_assoc($matchingUser);
        $this->closeStatementAndConnection();
        if ($cookiePassword != $user['password']) {
            throw new TamperedCookie('"' . $cookiePassword . '" does not match the existing cookie');
        }
    }
}
