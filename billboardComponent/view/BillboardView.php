<?php

class BillboardView {
    private static $postTitle = 'BillboardView::PostTitle';
	private static $postText = 'BillboardView::PostText';
    private static $billboardMessageId = 'BillboardView::PostMessage';
    private static $submitPost = 'BillboardView::SubmitPost';
    private static $updatePost = 'BillboardView::UpdatePost';
    private static $postId = 'BillboardView::PostId';
    private static $commentText = 'BillboardView::CommentText';
    private static $submitComment = 'BillboardView::SubmitComment';
    private static $postEdit = 'BillboardView::PostEdit';
    private static $postEditById = 'BillboardView::PostEditById';
    private static $postDelete = 'BillboardView::PostDelete';

    private static $visible = '';
    private static $hidden = 'hidden="hidden"';

    private $isLoggedIn;
    private $username;
    
    private $isPostEdit = false; //BEHÖVS??
    private $billboardMessage = "";
    private $postTitleEdit = "";
    private $postTextEdit = "";
    private $postIdEdit;
    private $posts;
    private $comments;

    // FULLÖSNING
    private $submitVisibility = '';
    private $updateVisibility = 'hidden="hidden"';

    public function __construct($user) {
        $this->isLoggedIn = $user->getIsLoggedIn();
        $this->username = $user->getUsername();
    }

    public function response() {
        echo $this->generateBillboardHTML();
    }

    private function generateBillboardHTML() {
        return '
        <h1>Billboard</h1>
        <p>' . $this->message() .'</p>
        <h3 id="' . self::$billboardMessageId . '">' .$this->billboardMessage. '</h3>
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
                
                <input type="hidden" name="'.self::$postEdit.'" value="'.$this->isPostEdit.'" />
                <input type="hidden" name="'.self::$postEditById.'" value="'.$this->postIdEdit.'" />
                
                <label for="' . self::$postTitle . '">Post title</label><br>
                <input type="text" id="' . self::$postTitle . '" name="' . self::$postTitle . '" value="'.$this->postTitleEdit.'" /><br>

                <label for="' . self::$postText . '">Your thoughts</label><br>
                <textarea id="' . self::$postText . '" name="' . self::$postText . '" rows="4" cols="50">'.$this->postTextEdit.'</textarea><br>
					
                <input type="submit" name="' . self::$submitPost . '" value="Submit Post" '.$this->submitVisibility.' />
                <input type="submit" name="' . self::$updatePost . '" value="Update Post" '.$this->updateVisibility.' />
			</fieldset>
        </form>
        ';
        }
    }

    private function viewPosts() {
        $posts = '';
        foreach ($this->posts as $post => $postContent) {
            $posts .= '
            <div class="post" style="border:solid;padding:20px;width:450px;margin-bottom:10px;">
                <h1>'.$postContent["postTitle"].'</h1>
                '.$this->handleYourPost($postContent["username"], $postContent["id"]).'
                <hr>
                <h4>Written by : '.$postContent["username"].'</h4>
                <p>'.$postContent["postText"].'</p>
                <p>'.$postContent["timeStamp"].'</p>
                '.$this->commentForm($postContent).'
                '.$this->viewComments($postContent["id"]).'
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

                    <input type="hidden" name="'.self::$postId.'" value="'.$post["id"].'" />

                    <label for="' . self::$commentText . '">Comment</label><br>
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
        foreach ($this->comments as $comment => $commentContent) {
            if($commentContent["postId"] == $postId) {
                $comments .= '
                <hr>
                <p>'.$commentContent["commentText"].'</p>
                <p>'.$commentContent["timeStamp"].'</p>
                <br>
                ';
                }
        }
        return $comments;
    }

    private function handleYourPost($postAuthor, $postId) {
        if ($this->isLoggedIn && $this->username == $postAuthor) {
            return '
            <form method="post">
                <input type="hidden" name="'.self::$postId.'" value="'.$postId.'" />
                <input type="submit" name="'.self::$postEdit.'" value="Edit Post" />
                <input type="submit" name="'.self::$postDelete.'" value="Delete Post" />
            </form>
            ';
        }
    }

    // public function isBillboardRequested() {
    //     return isset($_GET['viewBillboard']);
    // }

    public function isEditPostRequested() {
        return isset($_POST[self::$postEdit]);
    }

    public function isDeletePostRequested() {
        return isset($_POST[self::$postDelete]);
    }

    public function isNewPostSubmitted() {
        return isset($_POST[self::$submitPost]);
    }

    public function isNewCommentSubmitted() {
        return isset($_POST[self::$submitComment]);
    }

    public function isEditPostSubmitted() {
        return (isset($_POST[self::$updatePost]));
    }

    public function setPosts($posts) {
        $this->posts = $posts;
    }

    public function setComments($comments) {
        $this->comments = $comments;
    }

    public function getPost() {
        return new Post($_POST[self::$postTitle], $_POST[self::$postText], $this->username, $_POST[self::$postEditById]);
    }

    public function getComment() {
        return new PostComment($_POST[self::$commentText], $this->username, $_POST[self::$postId]);
    }

    public function getPostId () {
        return $_POST[self::$postId];
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

    public function setPostMessage($message) {
        $this->billboardMessage = $message;
    }

    // FÅ IN ETT OBJEKT HÄR??
    public function setPostTitleAndTextEdit($post) {
        $this->postTitleEdit = $post['postTitle'];
        $this->postTextEdit = $post['postText'];
        $this->isPostEdit = true;
        $this->postIdEdit = $post['id'];
        $this->submitVisibility = self::$hidden;
        $this->updateVisibility = self::$visible;
    }
}