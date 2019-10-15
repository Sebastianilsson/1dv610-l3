<?php

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $username = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private $cookieUsername;
	private $name = '';
	private $logInMessage = '';
	private $loggedIn = false;

	

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		$response;
		if ($this->getIsLoggedIn()) {
			$response = $this->generateLogoutButtonHTML();
		} else {
			$response = $this->generateLoginFormHTML();
		}
		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML() {
		return '
			<a href="?viewBillboard">View Billboard</a>
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $this->logInMessage .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML() {
		return '
			<a href="?register">Register a new user</a>
			<a href="?viewBillboard">View Billboard</a>
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' .$this->logInMessage. '</p>
					
					<label for="' . self::$username . '">Username :</label>
					<input type="text" id="' . self::$username . '" name="' . self::$username . '" value="'.$this->name.'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	public function handleNewCookies() {
		$cookieValues = new CookieValues($_POST[self::$username], $this->generateRandomString());
		$this->setCookies($cookieValues);
		$this->setLoginMessage("Welcome and you will be remembered");
		return $cookieValues;
    }

	private function setCookies($cookieValues) {
        setcookie(self::$cookieName, $cookieValues->getCookieUsername(), time()+3600);
		setcookie(self::$cookiePassword, $cookieValues->getCookiePassword(), time()+3600);
	}
	
	private function generateRandomString() {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$lengthOfPassword = 20;
    	$cookiePassword = '';
    	for ($index = 0; $index < $lengthOfPassword; $index++) {
        	$cookiePassword .= $characters[rand(0, $charactersLength - 1)];
		}
		return $cookiePassword;
	}
	
	public function destroyCookies() {
        setcookie (self::$cookieName, "", time() - 3600);
        setcookie (self::$cookiePassword, "", time() - 3600);
	}
	
	public function userHasCookie() {
		return isset($_COOKIE[self::$cookieName]);
	}

	public function getCookiePassword() {
		return $_COOKIE[self::$cookiePassword];
	}

	public function getCookieUsernameAndPassword() : CookieValues {
		return new CookieValues($_COOKIE[self::$cookieName], $_COOKIE[self::$cookiePassword]);
	}

	public function getUsername() {
        return isset($_POST[self::$username]) ? $_POST[self::$username] :"";
    }

    public function getPassword() {
        return isset($_POST[self::$password]) ? $_POST[self::$password] :"";
	}

	public function getIsLoggedIn() {
		return $this->loggedIn;
	}

	public function isKeepLoggedInRequested() {
		return isset($_POST[self::$keep]);
	}

	public function isLoggedOutRequested() {
		return isset($_POST[self::$logout]);
	}
	
	public function isLoginFormSubmitted() {
		return isset($_POST[self::$login]);
	}

	public function setUsernameValue($name) {
		$this->name = $name;
	}

	public function setLoginMessage($message) {
		$this->logInMessage = $message;
	}

	public function isLoggedIn() {
		$this->loggedIn = true;
	}

	public function isNotLoggedIn() {
		$this->loggedIn = false;
	}
	
}