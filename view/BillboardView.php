<?php

class BillboardView {
    private static $postTitle = 'BillboardView::PostTitle';
	private static $postText = 'BillboardView::PostText';
    private static $postMessageId = 'BillboardView::PostMessage';
    private static $submitPost = 'BillboardView::SubmitPost';
    private static $postId = 'BillboardView::PostId';
    private static $commentMessageId = 'BillboardView::CommentMessage';
    private static $commentText = 'BillboardView::CommentText';
    private static $submitComment = 'BillboardView::SubmitComment';

    private $isLoggedIn = false;
    private $postEdit = false;
    private $postMessage = "";
    private $commentMessage = "";
    private $postTitleEdit = "";
    private $postTextEdit = "";
    private $postIdEdit;
    private $posts;
    private $comments;

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
        if ($this->isLoggedIn) {
            return '
        <form method="post" > 
			<fieldset>
				<legend>New Billboard Post - share whats on your mind</legend>
                <p id="' . self::$postMessageId . '">' .$this->postMessage. '</p>
                <input type="hidden" name="postEdit" value="'.$this->postEdit.'" />
                <input type="hidden" name="postIdEdit" value="'.$this->postIdEdit.'" />
                
                <label for="' . self::$postTitle . '">Post title</label><br>
                <input type="text" id="' . self::$postTitle . '" name="' . self::$postTitle . '" value="'.$this->postTitleEdit.'" /><br>

                <label for="' . self::$postText . '">Your thoughts</label><br>
                <textarea id="' . self::$postText . '" name="' . self::$postText . '" rows="4" cols="50">'.$this->postTextEdit.'</textarea><br>
					
				<input type="submit" name="' . self::$submitPost . '" value="Submit Post" />
			</fieldset>
        </form>
        ';
        }
    }

    private function viewPosts() {
        $posts = '';
        foreach ($this->posts as $post => $value) {
            $posts .= '
            <div class="post" style="border:solid;padding:20px;width:33%;margin-bottom:10px;">
                <h1>'.$value["postTitle"].'</h1>
                '.$this->handleYourPost($value["username"], $value["id"]).'
                <hr>
                <h4>Written by : '.$value["username"].'</h4>
                <p>'.$value["postText"].'</p>
                <p>'.$value["timeStamp"].'</p>
                '.$this->commentForm($value).'
                '.$this->viewComments($value["id"]).'
            </div>
            ';
        }
        return $posts;
    }

    private function commentForm($post) {
        if ($this->isLoggedIn) {
            return '
            <div>
                <form method="post" > 
                <fieldset>
                    <legend>New Comment On "'.$post["postTitle"].'" - what do you think about his update?</legend>
                    <p id="' . self::$commentMessageId . '">' .$this->commentMessage. '</p>

                    <input type="hidden" name="'.self::$postId.'" value="'.$post["id"].'" />

                    <label for="' . self::$commentText . '">Password</label><br>
                    <textarea id="' . self::$commentText . '" name="' . self::$commentText . '" rows="4" cols="50"></textarea><br>
                        
                    <input type="submit" name="' . self::$submitComment . '" value="Submit Comment" />
                </fieldset>
                </form>
            </div>
            ';
        }
    }

    private function viewComments($postId) {
        $comments = '<br><h3>Comments</h3>';
        foreach ($this->comments as $comment => $value) {
            if($value["postId"] == $postId) {
                $comments .= '
                <hr>
                <p>'.$value["commentText"].'</p>
                <p>'.$value["timeStamp"].'</p>
                <br>
                ';
                }
        }
        return $comments;
    }

    private function handleYourPost($postAuthor, $postId) {
        if ($this->isLoggedIn && $_SESSION["username"] == $postAuthor) {
            return '
            <form method="post">
                <input type="hidden" name="postId" value="'.$postId.'" />
                <input type="submit" name="editPost" value="Edit Post" />
                <input type="submit" name="deletePost" value="Delete Post" />
            </form>
            ';
        }
    }

    public function isBillboardRequested() {
        return isset($_GET['viewBillboard']);
    }

    public function isEditPostRequested() {
        return isset($_POST['editPost']);
    }

    public function isDeletePostRequested() {
        return isset($_POST['deletePost']);
    }

    public function isNewPostSubmitted() {
        return isset($_POST[self::$submitPost]);
    }

    public function isNewCommentSubmitted() {
        return isset($_POST[self::$submitComment]);
    }

    public function isEditPostSubmitted() {
        return isset($_POST["postEdit"]);
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

    public function setComments($comments) {
        $this->comments = $comments;
    }

    public function getPost() {
        return new Post($_POST[self::$postTitle], $_POST[self::$postText], $_POST['postIdEdit']);
    }

    public function getComment() {
        return new PostComment($_POST[self::$commentText], $_POST[self::$postId]);
    }

    public function getPostId () {
        return $_POST["postId"];
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

    public function setPostTitleAndTextEdit($post) {
        $this->postTitleEdit = $post['postTitle'];
        $this->postTextEdit = $post['postText'];
        $this->postEdit = true;
        $this->postIdEdit = $post['id'];
        $this->postMessage = "Update your post and click \"Submit Post\"";
    }
}