<?php

class AlbumView {

    private $isLoggedIn = false;

    public function response() {
        return $this->generateAlbumHTML();
    }

    private function generateAlbumHTML() {
        return '
        <a href="?">Back to login</a>
        <h1>Album</h1>
        ' . $this->message() .'
        ';
    }

    private function message() {
        if ($this->isLoggedIn) {
            return 'You are logged in and are now able to add/remove pictures to the album as well as comment on pictures.';
        } else {
            return 'You are not logged in and can only view pictures and comments';
        }
    }

    public function isAlbumRequested() {
        return isset($_GET['viewImages']);
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