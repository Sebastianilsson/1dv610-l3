[Already existing Use Cases](https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/UseCases.md)

# UC5 View the billboard

## Precondition

Main scenario: Navigate to page
Alternate scenario: UC1

## Main Scenario

1. Starts when a logged out user wants to view the billboard.
2. User clicks on the link "View Billboard".
3. System presents the billboard view (without "new post" or "comment" forms) with the existing posts.

# UC6 Create a billboard post

## Precondition

UC1 main scenario is followed and succeeded.

## Main Scenario

1. Starts when a logged in user wants to create a new billboard post.
2. User clicks on the link "View Billboard".
3. System presents the billboard view and in the form "New Billboard Post - share whats on your mind" asks for a "Post title" and "Your thoughts".
4. User provides a "Post title" and "Your thoughts"
5. System saves the billboard post to the database and presents the new post directly under the post form.

## Alternate Scenarios

- 4a. User provides only one of "Post title or "Your thoughts" and the other is left blank.
  - 1. System presents error message.
  - 2. Step 3 in Main Scenario.
- 4b. User tries to submit text containing script-tags in either "Post title" or "Your thoughts".
  - 1. System presents error message.
  - 2. Step 3 in Main Scenario.

# UC7 Edit a billboard post

## Precondition

UC6 main scenario is followed and succeeded.

## Main Scenario

1. Starts when a logged in user wants to edit a post that he has created.
2. System presents the billboard view and all the existing posts.
3. User clicks on the button "Edit Post" (only exists on the ones that he created).
4. System presents a message and asks the the user to edit the "Post title" and/or "Your thoughts".
5. User edit the "Post title" and/or "Your thoughts" and clicks on "Submit Post"
6. System saves the edited post and presents it on the billboard.

## Alternate Scenarios

- 5a. User edit the post so that one or both of the fields "Post title" or "Your thoughts" are left blank.
  - 1. System presents error message.
  - 2. Step 2 in Main Scenario.
- 5b. User edit the post so that one or both of the fields "Post title" or "Your thoughts" are containing script-tags.

  - 1. System presents error message.
  - 2. Step 2 in Main Scenario.

# UC8 Comment on a billboard post

## Precondition

UC6 or UC7 main scenario is followed and succeeded.

## Main Scenario

1. Starts when a logged in user wants to comment on a post on the billboard.
2. System presents the billboard view and all the existing posts.
3. User scrolls down to the post that he wants to comment on and provides a comment in the belonging comment-form.
4. System saves the comment and displays the billboard with the post and its comment.

## Alternate Scenarios

- 3a. User tries to submit a blank comment.
  - 1. System presents error message.
  - 2. Step 2 in Main Scenario.
- 3b. User tries to submit a comment that is containing script-tags.
  - 1. System presents error message.
  - 2. Step 2 in Main Scenario.
  
  # UC9 Delete a billboard post

## Precondition

UC6 or UC7 main scenario is followed and succeeded.

## Main Scenario

1. Starts when a logged in user wants to delete a post that he has created.
2. System presents the billboard view and all the existing posts.
3. User clicks on the button "Delete Post" (only exists on the ones that he created).
4. System deletes the post from the database and presents the billboard without the deleted post.
