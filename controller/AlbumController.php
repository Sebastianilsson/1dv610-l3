<?php

class AlbumController {

    private $layoutView;
    private $loginView;
    private $databaseModel;
    private $registerModel;
    private $albumView;


    public function __construct($layoutView, $loginView, $databaseModel, $albumView) {
        $this->databaseModel = $databaseModel;
        $this->albumView = $albumView;
        $this->loginView = $loginView;
        $this->layoutView = $layoutView;
    }

    // Method called if registration of a new user is requested
    public function handleAlbumInteraction() {
        // if ($this->albumView->isNewPictureUpload()) {

        // } elseif ($this->albumView->isNewComment()) {

        // }
        $this->isLoggedIn();
        // $this->layoutView->render($this->albumView);
    }

    private function isLoggedIn() {
        if ($this->loginView->getIsLoggedIn()) {
            $this->albumView->isLoggedIn();
        } else {
            $this->albumView->isNotLoggedIn();
        }
    }
}