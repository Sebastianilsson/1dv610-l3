<?php

class BillboardView {
    private static $postTitle = 'BillboardView::PostTitle';
	private static $postText = 'BillboardView::PostText';
    private static $messageId = 'BillboardView::Message';
    private static $submitPost = 'BillboardView::SubmitPost';

    private $isLoggedIn = false;
    private $postMessage = "";
    private $posts;

    public function response() {
        return $this->generateBillboardHTML();
    }

    private function generateBillboardHTML() {
        return '
        <a href="?">Back to login</a>
        <h1>Billboard</h1>
        <p>' . $this->message() .'</p>
        '.$this->viewPostForm().'
        <br>
        <hr>
        '.$this->viewPosts().'
        ';
    }

    private function message() {
        if ($this->isLoggedIn) {
            return 'You are logged in and are now able to add/edit/remove posts to the billboard as well as comment on other posts.';
        } else {
            return 'You are not logged in and can only view posts and comments';
        }
    }

    private function viewPostForm() {
        return '
        <form method="post" > 
				<fieldset>
					<legend>New Billboard Post - share whats on your mind</legend>
					<p id="' . self::$messageId . '">' .$this->postMessage. '</p>
					
                    <label for="' . self::$postTitle . '">Post title</label> <br>
					<input type="text" id="' . self::$postTitle . '" name="' . self::$postTitle . '" /><br>

                    <label for="' . self::$postText . '">Password</label><br>
                    <textarea id="' . self::$postText . '" name="' . self::$postText . '" rows="4" cols="50"></textarea><br>
					
					<input type="submit" name="' . self::$submitPost . '" value="Submit Post" />
				</fieldset>
            </form>
        ';
    }

    private function viewPosts() {
        $posts = '';
        while ($post = mysqli_fetch_array($this->posts)) {
            $posts .= '
            <div class="post" style="border:solid;padding:20px;width:33%;margin-bottom:10px;">
                <h1>'.$post["postTitle"].'</h1>
                <hr>
                <h4>Written by : '.$post["username"].'</h4>
                <p>'.$post["postText"].'</p>
                <p>'.$post["timeStamp"].'</p>
            </div>
            ';
        }
        return $posts;
    }

    public function isBillboardRequested() {
        return isset($_GET['viewBillboard']);
    }

    public function isNewPostSubmitted() {
        return isset($_POST[self::$submitPost]);
    }

    public function isLoggedIn() {
		$this->isLoggedIn = true;
	}

	public function isNotLoggedIn() {
		$this->loggedIn = false;
    }

    public function setPosts($posts) {
        $this->posts = $posts;
    }

    public function getPost() {
        return new Post($_POST[self::$postTitle], $_POST[self::$postText]);
    }
    
    public function getIsLoggedIn() {
        return $this->isLoggedIn;
    }

    public function getPostTitle() {
        return $_POST[self::$postTitle];
    }

    public function getPostText() {
        return $_POST[self::$postText];
    }
}