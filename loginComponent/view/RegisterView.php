<?php

class RegisterView
{

    private static $message = 'RegisterView::Message';
    private static $username = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $submitRegistration = 'RegisterView::Register';
    private $name = '';
    private $registerMessage = "";
    private $isLoggedIn = false;

    public function response(): string
    {
        return $this->generateRegistrationFormHTML();
    }

    private function generateRegistrationFormHTML(): string
    {
        return '
        <a href="?">Back to login</a>
        <h2>Register new user</h2>
        <form method="post" action="?register">
            <fieldset>
                <legend>Register - choose a username and password</legend>
                <p id=' . self::$message . '>' . $this->registerMessage . '</p>
                <label>Username</label>
                <input id=' . self::$username . ' type="text" name="' . self::$username . '" placeholder="Enter a username..." value="' . $this->name . '" /> <br>
                <label>Password</label>
                <input id=' . self::$password . ' type="password" name="' . self::$password . '" placeholder="Enter a password..." /> <br>
                <label>Repeat password</label>
                <input id=' . self::$passwordRepeat . ' type="password" name="' . self::$passwordRepeat . '" placeholder="Repeat your password..." /> <br>
                <input type="submit" name="' . self::$submitRegistration . '" />
            </fieldset>
        </form>
        ';
    }

    public function isRegisterFormRequested(): bool
    {
        return isset($_GET['register']);
    }

    public function isRegistrationRequested(): bool
    {
        return isset($_POST[self::$submitRegistration]);
    }

    public function isUsernameSet(): bool
    {
        return isset($_POST[self::$username]);
    }

    public function isPasswordSet(): bool
    {
        return isset($_POST[self::$password]);
    }

    public function isRepeatedPasswordSet(): bool
    {
        return isset($_POST[self::$passwordRepeat]);
    }

    public function getUserRegistration(): RegisterUser
    {
        return new RegisterUser($_POST[self::$username], $_POST[self::$password], $_POST[self::$passwordRepeat]);
    }

    public function getUsername(): string
    {
        return $_POST[self::$username];
    }

    public function getPassword(): string
    {
        return $_POST[self::$password];
    }

    public function getRepeatedPassword(): string
    {
        return $_POST[self::$passwordRepeat];
    }

    public function getIsLoggedIn(): bool
    {
        return $this->isLoggedIn;
    }

    public function isRegisterFormSubmitted(): bool
    {
        return isset($_POST[self::$submitRegistration]);
    }

    public function setUsernameValue($name)
    {
        $this->name = $name;
    }

    public function setRegisterMessage($message)
    {
        $this->registerMessage = $message;
    }
}
