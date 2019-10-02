<?php

class RegisterView {

    private static $message = 'RegisterView::Message';
    private static $username = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $submitRegistration = 'RegisterView::Register';
    private $name = '';
    private $registerMessage = "";

    public function response() {
        return $this->generateRegistrationFormHTML();
    }

    private function generateRegistrationFormHTML() {
        return '
        <a href="?">Back to login</a>
        <h2>Register new user</h2>
        <form method="post" action="?register">
            <fieldset>
                <legend>Register - choose a username and password</legend>
                <p id='. self::$message .'>'. $this->registerMessage .'</p>
                <label>Username</label>
                <input id='. self::$username .' type="text" name="'. self::$username .'" placeholder="Enter a username..." value="'.$this->name.'" /> <br>
                <label>Password</label>
                <input id='. self::$password .' type="password" name="'. self::$password .'" placeholder="Enter a password..." /> <br>
                <label>Repeat password</label>
                <input id='. self::$passwordRepeat .' type="password" name="'. self::$passwordRepeat .'" placeholder="Repeat your password..." /> <br>
                <input type="submit" name="'. self::$submitRegistration .'" />
            </fieldset>
        </form>
        ';
    }

    public function isRegisterFormRequested() {
        return isset($_GET['register']);
    }

    public function isRegistrationRequested() {
        return isset($_POST[self::$submitRegistration]);
    }

    public function isUsernameSet() {
        return isset($_POST[self::$username]);
    }

    public function isPasswordSet() {
        return isset($_POST[self::$password]);
    }

    public function isRepeatedPasswordSet() {
        return isset($_POST[self::$passwordRepeat]);
    }

    public function getUsername() {
        return isset($_POST[self::$username]) ? $_POST[self::$username] : "";
    }

    public function getPassword() {
        return isset($_POST[self::$password]) ? $_POST[self::$password] : "";
    }

    public function getRepeatedPassword() {
        return isset($_POST[self::$passwordRepeat]) ? $_POST[self::$passwordRepeat] : "";
    }

    public function isRegisterFormSubmitted() {
        if (isset($_POST[self::$submitRegistration])) {
            return true;
        } else {
            return false;
        }
    }

    public function setUsernameValue($name) {
        $this->name = $name;
    }

    public function setRegisterMessage($message) {
        $this->registerMessage = $message;
    }
}