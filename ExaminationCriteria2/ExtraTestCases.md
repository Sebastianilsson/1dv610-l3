# Extra Test Cases

[Already existing Test Cases](https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/TestCases.md)

# Test case 5.1 - Show Billboard when not logged in

### Input:

- Test case 1.1
- Click on the link "View Billboard"

### Output:

- The text "Not logged in", is shown.
- A button/link with text "Back to login" is shown.
- A blank Billboard (No form to add a new post since the user isn't logged in and no posts because no member have made a post yet.).

# BIIIIIIILD

# Test case 5.2 - Back to login when not logged in

### Input:

- Test case 5.1
- Click on the link "Back to login".

### Output:

- No feedback message
- The text "Not logged in", is shown
- Form for login is shown

# BIIIIILD

# Test case 5.3 - Show Billboard when logged in

### Input:

- Test case 4.10 - Enter Username: test and Password "testtest"
- Test case 1.7 - Enter Username: test and Password "testtest"
- Click on the link "View Billboard"

### Output:

- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- A Billboard with a form to submit a new billboard post (No posts because no member have made a post yet.).

# BIIIIIIILD

# Test case 5.4 - Back to login when not logged in

### Input:

- Test case 5.3
- Click on the link "Back to login".

### Output:

- No feedback message
- The text "Logged in", is shown
- A button for logout is shown. (No login form)

# BIIIIILD

# Test case 6.1 - Successfully creating a billboard post

### Input:

- Test case 5.3
- Enter the post title "My first billboard post!" and for your thoughts "I wonder what this will look like?".
- Press the button "Submit Post"

### output:

- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- Feedback: "Your post has been submitted"
- A billboard with a form to submit a new billboard post and the post just submitted with its own comment form.

# BIIIIIIILD

# Test case 6.2 - Creating a billboard post with no title or body should fail

### Input:

- Test case 5.3
- Let the fields post title and for your thoughts be empty.
- Press the button "Submit Post"

### output:

- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- Feedback: "All fields in a Post needs to be filled."
- A billboard with a form to submit a new billboard post and the previously submitted posts.

# BIIIIIIILD

# Test case 6.3 - Creating a billboard post with no body should fail KOLLA OM TITEL SKA VARA KVAR

### Input:

- Test case 5.3
- Enter the post title "Will not work" and let your thoughts be empty.
- Press the button "Submit Post"

### output:

- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- Feedback: "All fields in a Post needs to be filled."
- A billboard with a form to submit a new billboard post and the previously submitted posts.

# BIIIIIIILD

# Test case 6.4 - Creating a billboard post with no title should fail KOLLA OM BODY SKA VARA KVAR

### Input:

- Test case 5.3
- Let the post title be empty and in the your thoughts enter "Will not work either.".
- Press the button "Submit Post"

### output:

- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- Feedback: "All fields in a Post needs to be filled."
- A billboard with a form to submit a new billboard post and the previously submitted posts.

# BIIIIIIILD

# Test case 6.5 - Creating a billboard post with with potential harmful script tags in post title and your thoughts should fail KOLLA OM BODY SKA VARA KVAR UTAN TAGGAR

### Input:

- Test case 5.3
- Enter "<a>Potential harmful</a>" in post title and "<a>Potential harmful</a>" in your thoughts.
- Press the button "Submit Post"

### output:

- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- Feedback: "Post can not contain script-tags."
- A billboard with a form to submit a new billboard post and the previously submitted posts.

# BIIIIIIILD

# Test case 6.6 - Creating a billboard post with with potential harmful script tags in post title and empty your thoughts should fail KOLLA OM BODY SKA VARA KVAR UTAN TAGGAR

### Input:

- Test case 5.3
- Enter "<a>Potential harmful</a>" in post title and leave your thoughts empty.
- Press the button "Submit Post"

### output:

- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- Feedback: "All fields in a Post needs to be filled. Post can not contain script-tags."
- A billboard with a form to submit a new billboard post and the previously submitted posts.

# BIIIIIIILD

# Test case 6.7 - Creating a billboard post with with potential harmful script tags in your thoughts and empty post title should fail KOLLA OM BODY SKA VARA KVAR UTAN TAGGAR

### Input:

- Test case 5.3
- Enter "<a>Potential harmful</a>" in your thoughts and leave post title empty.
- Press the button "Submit Post"

### output:

- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- Feedback: "All fields in a Post needs to be filled. Post can not contain script-tags."
- A billboard with a form to submit a new billboard post and the previously submitted posts.

# BIIIIIIILD

# Test case 7.1 - Successfully editing a billboard post

## Input:

- Test case 6.1
- Scroll down to the post that you created and click on the button "Edit Post"
- Change post title to "This is now an edited post" and your thoughts to "This seems to work as well"
- Press the button "Submit Post"

### output:

- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- A billboard with a form to submit and an edited billboard post.

# BIIIIIIILD

# Test case 7.2 - Editing a post so that both post title and your thoughts are empty should fail

## Input:

- Test case 6.1
- Edit so the fields post title and for your thoughts are empty.
- Press the button "Submit Post"

### output:

- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- Feedback: "All fields in a Post needs to be filled."
- A billboard with a form to submit a new billboard post and the original post.

# BIIIIIIILD

# Test case 7.3 - Editing a post so that post title is empty should fail

## Input:

- Test case 6.1
- Edit so the fields post title is empty and let your thoughts be same as before.
- Press the button "Submit Post"

### output:

- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- Feedback: "All fields in a Post needs to be filled."
- A billboard with a form to submit a new billboard post and the original post.

# BIIIIIIILD

# Test case 7.4 - Editing a post so that your thoughts is empty should fail

## Input:

- Test case 6.1
- Edit so the fields your thoughts is empty and let post title be same as before.
- Press the button "Submit Post"

### output:

- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- Feedback: "All fields in a Post needs to be filled."
- A billboard with a form to submit a new billboard post and the original post.

# BIIIIIIILD

# Test case 7.5 - Editing a post so that both post title and your thoughts is holding potential harmful script tags should fail

## Input:

- Test case 6.1
- Edit so "<a>Potential harmful</a>" in post title and "<a>Potential harmful</a>" in your thoughts.
- Press the button "Submit Post"

### output:

- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- Feedback: "Post can not contain script-tags."
- A billboard with a form to submit a new billboard post and the original post.

# BIIIIIIILD

# Test case 7.6 - Editing a post so that post title is holding potential harmful script tags should fail

## Input:

- Test case 6.1
- Edit so "<a>Potential harmful</a>" in post title and let your thoughts be same as before.
- Press the button "Submit Post"

### output:

- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- Feedback: "Post can not contain script-tags."
- A billboard with a form to submit a new billboard post and the original post.

# BIIIIIIILD

# Test case 7.7 - Editing a post so that your thoughts is holding potential harmful script tags should fail

## Input:

- Test case 6.1
- Edit so "<a>Potential harmful</a>" in your thoughts and let post title be same as before.
- Press the button "Submit Post"

### output:

- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- Feedback: "Post can not contain script-tags."
- A billboard with a form to submit a new billboard post and the original post.

# BIIIIIIILD

# Test case 7.8 - Editing a post so that your thoughts is holding potential harmful script tags and post title is empty should fail

## Input:

- Test case 6.1
- Edit so "<a>Potential harmful</a>" in your thoughts and post title so its empty.
- Press the button "Submit Post"

### Output:

- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- Feedback: "All fields in a Post needs to be filled. Post can not contain script-tags."
- A billboard with a form to submit a new billboard post and the original post.

# BIIIIIIILD

# Test case 7.9 - Editing a post so that post title is holding potential harmful script tags and your thoughts is empty should fail

## Input:

- Test case 6.1
- Edit so "<a>Potential harmful</a>" in post title and your thoughts so its empty.
- Press the button "Submit Post"

### Output:

- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- Feedback: "All fields in a Post needs to be filled. Post can not contain script-tags."
- A billboard with a form to submit a new billboard post and the original post.

# BIIIIIIILD

# Test case 7.10 - A user that hasn't created the post should not be able to edit it

### Input:

- Test case 4.10 - Enter Username: "testing" and Password: "testtest"
- Test case 1.7 - Enter Username: "testing" and Password: "testtest"
- Click on the link "View Billboard"

### Output:

- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- A billboard with a form to submit a new billbord post and the post previously created by the user "test".
- (No buttons "Edit Post" or "Delete Post" since he didn't create the post)

# BIIIIIIILD

# Test case 7.11 - A user that isn't logged in should not be able to edit a billboard post

### Input:

- Test case 5.1

### Output:

- The text "Not logged in", is shown.
- A button/link with text "Back to login" is shown.
- A billboard with the post previously created by the user "test".
- (No form to submit a new billboard post, no form to submit a comment to the existing post or buttons "Edit Post" or "Delete Post" on the exsisting post since the user isn't logged in)

# BIIIIIIILD

# 8.1 A user that created the post and is logged in should be able to submmit a comment to the post

### Input:
- Test case 5.3
- Scroll down to the post previously created by the user "test".
- Enter "This is a test" in the comment field of the comment form.
- Click on the button "Submit Comment"

### Output:
- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- A billboard with a form to submit a new billboard post and the post previously made with its own comment form and the recently submitted comment.

# BIIIIIILD

# 8.2 A user that didn't created the post but is logged in should be able to submmit a comment to the post

### Input:
- Test case 5.3 - Enter Username: "testing" and Password: "testtest"
- Scroll down to the post previously created by the user "test".
- Enter "This is also a test" in the comment field of the comment form.
- Click on the button "Submit Comment"

### Output:
- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- A billboard with a form to submit a new billboard post and the post previously made with its own comment form and the two comments.

# BIIIIIILD

# 8.3 A logged in user that tries to submit an empty comment to a post should fail

### Input:
- Test case 5.3
- Scroll down to the post previously created by the user "test".
- Leave the comment field empty.
- Click on the button "Submit Comment"

### Output:
- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- Feedback: "You can't submit an empty Comment."
- A billboard with a form to submit a new billboard post and the post previously made with its own comment form and the two comments.
- (No third empty comment)

# BIIIIIILD

# 8.4 A logged in user that tries to submit a comment with potential harmful script tags to a post should fail

### Input:
- Test case 5.3
- Scroll down to the post previously created by the user "test".
- Enter "<a>This test will not work</a>" in the comment field.
- Click on the button "Submit Comment"

### Output:
- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- Feedback: "Comment can't contain script-tags."
- A billboard with a form to submit a new billboard post and the post previously made with its own comment form and the two comments.
- (No third comment with script tags)

# BIIIIIILD

# Test case 8.5 - A user that isn't logged in should not be able to comment on a billboard post

### Input:

- Test case 5.1

### Output:

- The text "Not logged in", is shown.
- A button/link with text "Back to login" is shown.
- A billboard with the post previously created by the user "test" and its two comments.
- (No form to submit a new billboard post, no form to submit a comment to the existing post or buttons "Edit Post" or "Delete Post" on the exsisting post since the user isn't logged in)

# BIIIIIIILD

# Test case 9.1 - A user that is logged in but didn't create the post should fail trying to delet it

### Input:
- Test case 5.3 - Enter Username: "testing" and Password: "testtest" (not Username: "test")

### Output:
- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- A billboard with a form to submit a new billboard post, the post previously created by the user "test", a comment form to the post and its two comments.
- (No buttons "Edit Post" or "Delete Post" since the user logged in isn't the one who created the post)

# BIIIILD

# Test case 9.2 - A user that isn't logged in and didn't create the post should fail trying to delet it

### Input:
- Test case 5.1

### Output:
- The text "Not logged in", is shown.
- A button/link with text "Back to login" is shown.
- A billboard with the post previously created by the user "test" and its two comments.
- (No form to submit a new billboard post, no form to submit a comment to the existing post or buttons "Edit Post" or "Delete Post" on the exsisting post since the user isn't logged in)

# BIIIIIILD

# Test case 9.3 - A user that is logged in and createed the post should be able to delet it

### Input:
- Test case 5.3
- Scroll down to the post previously made by "test"
- Click on the button "Delete Post"

### Output:
- The text "Logged in", is shown.
- A button/link with text "Back to login" is shown.
- A billboard with a form to submit a new billboard is shown.
- (No post or comments)
