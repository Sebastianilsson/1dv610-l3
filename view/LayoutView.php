<?php


class LayoutView {

  public function __construct($dateTimeView) {
    $this->dateTimeView = $dateTimeView;
  }
  
  public function render($isLoggedIn, $activeView) {
    echo '<!DOCTYPE html>
      <html lang="en">
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn($isLoggedIn) . '
          
          <div class="container">
              ' . $activeView->response() . '
              
              ' . $this->dateTimeView->showDateTimeString() . '
          </div>
         </body>
      </html>
    ';
  }
  
  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}
