<?php

class BillboardView {

    private $isLoggedIn = false;

    public function response() {
        return $this->generateBillboardHTML();
    }

    private function generateBillboardHTML() {
        return '
        <a href="?">Back to login</a>
        <h1>Billboard</h1>
        ' . $this->message() .'
        ';
    }

    private function message() {
        if ($this->isLoggedIn) {
            return 'You are logged in and are now able to add/edit/remove posts to the billboard as well as comment on other posts.';
        } else {
            return 'You are not logged in and can only view posts and comments';
        }
    }

    public function isBillboardRequested() {
        return isset($_GET['viewBillboard']);
    }

    public function getIsLoggedIn() {
        return $this->isLoggedIn;
    }

    public function isLoggedIn() {
		$this->isLoggedIn = true;
	}

	public function isNotLoggedIn() {
		$this->loggedIn = false;
	}
}